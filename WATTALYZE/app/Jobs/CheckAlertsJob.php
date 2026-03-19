<?php

namespace App\Jobs;

use App\Models\Alert;
use App\Models\AlertRule;
use App\Services\InfluxDBService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertNotificationMail;

class CheckAlertsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $influx;
    private const VOLTAGE = 220;
    private const GAP_THRESHOLD = 5 * 60;

    public function __construct() {}

    public function handle()
    {
        Log::info("Iniciando verificação de alertas");
        $this->influx = app(InfluxDBService::class);

        // ✅ Verifica se está ativa antes de processar
        $rules = AlertRule::with(['device', 'user'])
            ->where('is_active', true)
            ->whereIn('type', ['consumption_spike', 'consumption_threshold'])
            ->get();

        foreach ($rules as $rule) {
            try {
                $this->evaluateRule($rule);
            } catch (\Exception $e) {
                Log::error("Erro na regra {$rule->id}: " . $e->getMessage());
            }
        }
    }

    protected function evaluateRule(AlertRule $rule)
    {
        Log::info("Avaliando regra {$rule->id} do tipo {$rule->type}");

        switch ($rule->type) {
            case 'consumption_spike':
                $this->checkConsumptionSpike($rule);
                break;
            case 'consumption_threshold':
                $this->checkConsumptionThreshold($rule);
                break;
            default:
                Log::warning("Tipo de regra não suportado: {$rule->type}");
        }
    }

    protected function checkConsumptionSpike(AlertRule $rule)
    {
        Log::info("checkConsumptionSpike para regra {$rule->id}");

        $avgConsumption = $this->getAverageConsumptionInPeriod($rule);
        $currentConsumption = $this->getCurrentConsumption($rule);

        Log::info("Consumo médio: {$avgConsumption} kWh, Consumo atual: {$currentConsumption} kWh");

        $existingAlert = Alert::where('alert_rule_id', $rule->id)
            ->where('is_resolved', false)
            ->latest()
            ->first();

        if ($avgConsumption > 0 && $currentConsumption > ($avgConsumption * $rule->threshold_value)) {
            if (!$existingAlert) {
                Log::info("Limite excedido! Criando alerta para regra {$rule->id}");
                $this->createAlert($rule, $currentConsumption);
            } else {
                Log::info("Pico continua, alerta {$existingAlert->id} permanece ativo");
                $existingAlert->update(['actual_value' => $currentConsumption]);
            }
        } else {
            if ($existingAlert) {
                Log::info("Consumo normalizado! Resolvendo alerta {$existingAlert->id}");
                $existingAlert->update([
                    'is_resolved' => true,
                    'resolved_at' => Carbon::now()
                ]);
            } else {
                Log::info("Consumo normal para regra {$rule->id}");
            }
        }
    }

    protected function checkConsumptionThreshold(AlertRule $rule)
    {
        Log::info("checkConsumptionThreshold para regra {$rule->id}");

        $totalConsumption = $this->getTotalConsumptionInPeriod($rule);
        Log::info("Consumo total: {$totalConsumption} kWh, Limite: {$rule->threshold_value} kWh");

        $existingAlert = Alert::where('alert_rule_id', $rule->id)
            ->where('is_resolved', false)
            ->latest()
            ->first();

        if ($totalConsumption > $rule->threshold_value) {
            if (!$existingAlert) {
                Log::info("LIMITE EXCEDIDO! Criando alerta para regra {$rule->id}");
                $this->createAlert($rule, $totalConsumption);
            } else {
                Log::info("Limite ainda excedido, alerta {$existingAlert->id} continua ativo");
                $existingAlert->update(['actual_value' => $totalConsumption]);
            }
        } else {
            if ($existingAlert) {
                Log::info("Consumo normalizado! Resolvendo alerta {$existingAlert->id}");
                $existingAlert->update([
                    'is_resolved' => true,
                    'resolved_at' => Carbon::now()
                ]);
            } else {
                Log::info("Consumo dentro do limite para regra {$rule->id}");
            }
        }
    }

    protected function getTotalConsumptionInPeriod(AlertRule $rule)
    {
        if (!$rule->device) {
            Log::warning("Regra {$rule->id} não tem dispositivo associado");
            return 0;
        }

        $timezone = config('app.timezone', 'America/Sao_Paulo');

        // ✅ Define período: data_inicio -> data_fim OU desde created_at até agora
        if ($rule->data_inicio) {
            $start = Carbon::parse($rule->data_inicio, $timezone)->startOfDay();
        } else {
            // Se não tem data_inicio, usa a data de criação da regra
            $start = Carbon::parse($rule->created_at, $timezone);
        }

        if ($rule->data_fim) {
            $stop = Carbon::parse($rule->data_fim, $timezone)->endOfDay();
            // Não permite data_fim futura
            $stop = $stop->gt(Carbon::now($timezone)) ? Carbon::now($timezone) : $stop;
        } else {
            // Se não tem data_fim, calcula até agora
            $stop = Carbon::now($timezone);
        }

        Log::info("Calculando consumo de {$start->toDateTimeString()} até {$stop->toDateTimeString()}");

        $mac = $rule->device->mac_address;
        $bucket = $this->influx->getBucket();

        $startUTC = $start->copy()->setTimezone('UTC')->toIso8601String();
        $stopUTC = $stop->copy()->setTimezone('UTC')->toIso8601String();

        $query = <<<FLUX
from(bucket: "{$bucket}")
  |> range(start: {$startUTC}, stop: {$stopUTC})
  |> filter(fn: (r) => r._measurement == "energy")
  |> filter(fn: (r) => r.mac == "{$mac}")
  |> filter(fn: (r) => r._field == "current")
  |> sort(columns: ["_time"])
  |> yield()
FLUX;

        try {
            $results = $this->influx->queryEnergyData($query);

            if (empty($results)) {
                Log::info("Nenhum dado encontrado para o período");
                return 0;
            }

            $consumption = $this->calculateConsumptionFromCurrentData($results, $timezone, $rule->device);
            Log::info("Consumo total calculado: " . round($consumption, 6) . " kWh com " . count($results) . " registros");

            return $consumption;
        } catch (\Exception $e) {
            Log::error("Erro ao calcular consumo total: " . $e->getMessage());
            return 0;
        }
    }

    protected function getAverageConsumptionInPeriod(AlertRule $rule)
    {
        if (!$rule->device) {
            Log::warning("Regra {$rule->id} não tem dispositivo associado");
            return 0;
        }

        $timezone = config('app.timezone', 'America/Sao_Paulo');

        // ✅ Define período: data_inicio até 5 min atrás OU últimos 7 dias
        if ($rule->data_inicio) {
            $start = Carbon::parse($rule->data_inicio, $timezone)->startOfDay();
        } else {
            $start = Carbon::parse($rule->created_at, $timezone);
        }

        $stop = Carbon::now($timezone)->subMinutes(5);

        $mac = $rule->device->mac_address;
        $bucket = $this->influx->getBucket();

        $startUTC = $start->copy()->setTimezone('UTC')->toIso8601String();
        $stopUTC = $stop->copy()->setTimezone('UTC')->toIso8601String();

        $query = <<<FLUX
from(bucket: "{$bucket}")
  |> range(start: {$startUTC}, stop: {$stopUTC})
  |> filter(fn: (r) => r._measurement == "energy")
  |> filter(fn: (r) => r.mac == "{$mac}")
  |> filter(fn: (r) => r._field == "current")
  |> sort(columns: ["_time"])
  |> yield()
FLUX;

        try {
            $results = $this->influx->queryEnergyData($query);

            if (empty($results)) {
                Log::info("Nenhum dado encontrado para cálculo de média");
                return 0;
            }

            $totalConsumption = $this->calculateConsumptionFromCurrentData($results, $timezone, $rule->device);
            $hours = $start->diffInHours($stop);
            $avgConsumptionPerHour = $hours > 0 ? $totalConsumption / $hours : 0;

            Log::info("Média calculada: " . round($avgConsumptionPerHour, 6) . " kWh/h");

            return $avgConsumptionPerHour;
        } catch (\Exception $e) {
            Log::error("Erro ao calcular consumo médio: " . $e->getMessage());
            return 0;
        }
    }

    protected function getCurrentConsumption(AlertRule $rule)
    {
        if (!$rule->device) {
            Log::warning("Regra {$rule->id} não tem dispositivo associado");
            return 0;
        }

        $mac = $rule->device->mac_address;
        $bucket = $this->influx->getBucket();
        $timezone = config('app.timezone', 'America/Sao_Paulo');

        $start = Carbon::now($timezone)->subMinutes(5)->setTimezone('UTC')->toIso8601String();
        $stop = Carbon::now($timezone)->setTimezone('UTC')->toIso8601String();

        $query = <<<FLUX
from(bucket: "{$bucket}")
  |> range(start: {$start}, stop: {$stop})
  |> filter(fn: (r) => r._measurement == "energy")
  |> filter(fn: (r) => r.mac == "{$mac}")
  |> filter(fn: (r) => r._field == "current")
  |> sort(columns: ["_time"])
  |> yield()
FLUX;

        try {
            $results = $this->influx->queryEnergyData($query);

            if (empty($results)) {
                Log::info("Nenhum dado atual encontrado");
                return 0;
            }

            $consumption = $this->calculateConsumptionFromCurrentData($results, $timezone, $rule->device);
            Log::info("Consumo atual: " . round($consumption, 6) . " kWh");

            return $consumption;
        } catch (\Exception $e) {
            Log::error("Erro ao obter consumo atual: " . $e->getMessage());
            return 0;
        }
    }

    private function calculateConsumptionFromCurrentData(array $results, string $timezone, $device): float
    {
        if (empty($results)) {
            return 0;
        }

        $data = [];
        foreach ($results as $row) {
            if (!isset($row['value']) || $row['value'] === null) continue;

            try {
                $time = Carbon::parse($row['time'])->setTimezone($timezone);
                $value = floatval($row['value']);

                $data[] = [
                    'time' => $time,
                    'current' => $value,
                    'timestamp' => $time->timestamp
                ];
            } catch (\Exception $e) {
                Log::warning("Erro ao parsear timestamp: " . $e->getMessage());
                continue;
            }
        }

        if (count($data) < 2) {
            return 0;
        }

        usort($data, fn($a, $b) => $a['timestamp'] - $b['timestamp']);

        $operationHours = $this->calculateOperationHours($data);
        $avgCurrent = array_sum(array_column($data, 'current')) / count($data);
        $powerW = self::VOLTAGE * $avgCurrent;
        $energyKwh = ($powerW * $operationHours) / 1000;

        return $energyKwh;
    }

    private function calculateOperationHours(array $data): float
    {
        if (count($data) < 2) {
            return 0;
        }

        $operationSeconds = 0;
        $lastTime = null;

        foreach ($data as $point) {
            if ($lastTime === null) {
                $lastTime = $point['timestamp'];
                continue;
            }

            $timeDiff = $point['timestamp'] - $lastTime;

            if ($timeDiff < self::GAP_THRESHOLD) {
                $operationSeconds += $timeDiff;
            }

            $lastTime = $point['timestamp'];
        }

        return $operationSeconds / 3600;
    }

    protected function createAlert(AlertRule $rule, $actualValue)
    {
        $recentAlert = Alert::where('alert_rule_id', $rule->id)
            ->where('is_resolved', false)
            ->where('created_at', '>=', Carbon::now()->subHours(1))
            ->first();

        if ($recentAlert) {
            Log::info("Alerta recente já existe para regra {$rule->id}, ignorando...");
            return;
        }

        Log::info("===== CRIANDO ALERTA =====");
        Log::info("Regra: {$rule->id} | Valor: {$actualValue} | Limite: {$rule->threshold_value}");

        $alert = Alert::create([
            'user_id' => $rule->user_id,
            'device_id' => $rule->device_id,
            'environment_id' => $rule->environment_id,
            'alert_rule_id' => $rule->id,
            'type' => $rule->type,
            'severity' => $rule->severity ?? 'medium',
            'title' => $this->getAlertTitle($rule),
            'message' => $this->getAlertMessage($rule, $actualValue),
            'threshold_value' => $rule->threshold_value,
            'actual_value' => $actualValue,
            'is_resolved' => false,
            'is_read' => false,
        ]);

        // ✅ Desativa a regra após criar o alerta
        $rule->update(['is_active' => false]);
        Log::info("Regra {$rule->id} desativada após acionamento do alerta");

        Log::info("Alerta ID {$alert->id} criado com sucesso!");

        if ($rule->user && $rule->user->notification_channels) {
            $channels = json_decode($rule->user->notification_channels, true);
            if (isset($channels['email']) && $channels['email']) {
                $this->sendEmailNotification($alert, $rule);
            }
        } else {
            $this->sendEmailNotification($alert, $rule);
        }
    }

    private function sendEmailNotification(Alert $alert, AlertRule $rule)
    {
        Log::info("===== ENVIANDO EMAIL =====");

        try {
            if (!$rule->user || !$rule->user->email) {
                Log::error("ERRO: Usuário sem email!");
                return;
            }

            Log::info("Enviando email para: {$rule->user->email}");

            Mail::to($rule->user->email)
                ->send(new AlertNotificationMail($alert));

            Log::info("✅ EMAIL ENVIADO COM SUCESSO para {$rule->user->email}");
        } catch (\Exception $e) {
            Log::error("❌ ERRO ao enviar email: " . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    protected function getAlertTitle(AlertRule $rule)
    {
        return match ($rule->type) {
            'consumption_spike' => 'Pico de consumo detectado',
            'consumption_threshold' => 'Limite de consumo excedido',
            default => 'Alerta de consumo'
        };
    }

    protected function getAlertMessage(AlertRule $rule, $actualValue)
    {
        $device = $rule->device ? $rule->device->name : 'Dispositivo';
        $threshold = $rule->threshold_value;
        $actualFormatted = number_format($actualValue, 3, ',', '.');
        $thresholdFormatted = number_format($threshold, 3, ',', '.');

        $periodo = '';
        if ($rule->data_inicio) {
            $inicio = Carbon::parse($rule->data_inicio)->format('d/m/Y');
            $fim = $rule->data_fim ? Carbon::parse($rule->data_fim)->format('d/m/Y') : 'atual';
            $periodo = " (período: {$inicio} - {$fim})";
        }

        return match ($rule->type) {
            'consumption_spike' => "Pico de consumo em {$device}: {$actualFormatted} kWh/h (limite: {$thresholdFormatted}x média){$periodo}",
            'consumption_threshold' => "{$device} excedeu limite: {$actualFormatted} kWh > {$thresholdFormatted} kWh{$periodo}",
            default => "Alerta de consumo em {$device}: {$actualFormatted} kWh{$periodo}"
        };
    }
}
