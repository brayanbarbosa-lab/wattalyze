<?php

namespace App\Services;

use App\Models\Alert;
use App\Mail\AlertNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendAlertNotification(Alert $alert)
    {
        $rule = $alert->alertRule;

        if (!$rule) {
            Log::warning("Alerta {$alert->id} sem regra associada");
            return;
        }

        // Enviar por email se configurado
        $this->sendEmailNotification($alert, $rule);

    }

    private function sendEmailNotification(Alert $alert, $rule)
    {
        try {
            // Verificar se usuário existe e tem email
            if (!$alert->user || !$alert->user->email) {
                Log::warning("Usuário sem email para alerta {$alert->id}");
                return;
            }

            // Verificar se email está habilitado
            $channels = $rule->notification_channels
                ? json_decode($rule->notification_channels, true)
                : [];

            if (!in_array('email', $channels)) {
                Log::info("Email não habilitado para alerta {$alert->id}");
                return;
            }

            // Enviar email
            Mail::to($alert->user->email)
                ->queue(new AlertNotificationMail($alert));

            Log::info("Email de alerta {$alert->id} enviado para {$alert->user->email}");
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email para alerta {$alert->id}: " . $e->getMessage());
        }
    }

    public function sendTestNotification($userEmail, $message = null)
    {
        try {
            // Criar um alerta de teste com created_at definido
            $testAlert = new Alert([
                'title' => 'Teste de Notificação',
                'message' => $message ?? 'Este é um teste do sistema de notificações.',
                'type' => 'test',
                'severity' => 'low',
            ]);

            // Garantir que created_at seja uma instância de Carbon
            $testAlert->created_at = now();

            Mail::to($userEmail)->send(new AlertNotificationMail($testAlert));

            return true;
        } catch (\Exception $e) {
            Log::error("Erro ao enviar teste de notificação: " . $e->getMessage());
            return false;
        }
    }
}
