<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

class CreateDefaultMeasurements extends Command
{
    protected $signature = 'influx:create-device-measurements {--count=5 : Número de devices fictícios}';
    protected $description = 'Cria measurements no InfluxDB com dados fictícios';

    public function handle()
    {
        $client = new Client([
            'url' => config('influxdb.url'),
            'token' => config('influxdb.token'),
            'org' => config('influxdb.org'),
            'bucket' => config('influxdb.bucket'),
            'precision' => WritePrecision::S,
        ]);

        $writeApi = $client->createWriteApi();
        $count = (int) $this->option('count');

        // Gerar dados fictícios para múltiplos devices
        for ($i = 1; $i <= $count; $i++) {
            $deviceId = "device_$i";
            $mac = $this->generateMacAddress();
            $environmentId = "env_" . rand(1, 3);

            // Gerar múltiplos pontos de dados (simulando histórico)
            $dataPoints = rand(10, 30);

            for ($j = 0; $j < $dataPoints; $j++) {
                $timestamp = time() - (3600 * $j); // 1 hora de intervalo entre pontos

                // Energy - valores realistas
                $pointEnergy = Point::measurement('energy')
                    ->addTag('device_id', $deviceId)
                    ->addTag('mac', "AA:AA:AA:AA:AA:AA")
                    ->addTag('environment_id', $environmentId)
                    ->addField('instantaneous_power', rand(100, 5000) / 100000) // 1W a 50W
                    ->addField('consumption_kwh', rand(1, 1000) / 100000) // 0.01 a 10 kWh
                    ->addField('voltage', rand(2100, 2300) / 10) // 210V a 230V
                    ->addField('current', rand(50, 500) / 1000) // 0.5A a 5A
                    ->time($timestamp, WritePrecision::S);

                $writeApi->write($pointEnergy);

                // Temperature - valores realistas
                $pointTemp = Point::measurement('temperature')
                    ->addTag('device_id', $deviceId)
                    ->addTag('mac', $mac)
                    ->addTag('environment_id', $environmentId)
                    ->addField('temperature', (float)(rand(180, 320) / 10)) // 18.0°C a 32.0°C
                    ->time($timestamp, WritePrecision::S);

                $writeApi->write($pointTemp);

                $writeApi->write($pointTemp);

                // Humidity - valores realistas
                $pointHumidity = Point::measurement('humidity')
                    ->addTag('device_id', $deviceId)
                    ->addTag('mac', $mac)
                    ->addTag('environment_id', $environmentId)
                    ->addField('humidity', (float)(rand(300, 800) / 10)) // 30% a 80%
                    ->time($timestamp, WritePrecision::S);

                $writeApi->write($pointHumidity);
            }

            $this->info("Device fictício $deviceId criado com $dataPoints pontos de dados (MAC: $mac)");
        }

        $client->close();
        $this->info("Todas as measurements fictícias foram criadas com sucesso!");
        $this->info("Total: $count devices com dados históricos");
    }

    private function generateMacAddress(): string
    {
        return sprintf(
            '%02X:%02X:%02X:%02X:%02X:%02X',
            rand(0, 255),
            rand(0, 255),
            rand(0, 255),
            rand(0, 255),
            rand(0, 255),
            rand(0, 255)
        );
    }
}
