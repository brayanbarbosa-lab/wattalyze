<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use InfluxDB2\Client;
use Exception;

class TestInfluxConnection extends Command
{
    protected $signature = 'influx:test-connection';
    protected $description = 'Testa e diagnostica a conexão com InfluxDB';

    public function handle()
    {
        $this->info('=== DIAGNÓSTICO DE CONEXÃO INFLUXDB ===');
        $this->newLine();

        // 1. Verificar variáveis de ambiente
        $this->info('1. Verificando variáveis de ambiente:');
        $url = config('influxdb.url');
        $token = config('influxdb.token');
        $org = config('influxdb.org');
        $bucket = config('influxdb.bucket');

        $this->line("   URL: " . ($url ?: '❌ NÃO DEFINIDA'));
        $this->line("   Token: " . ($token ? '✓ Definido (' . strlen($token) . ' caracteres)' : '❌ NÃO DEFINIDO'));
        $this->line("   Org: " . ($org ?: '❌ NÃO DEFINIDA'));
        $this->line("   Bucket: " . ($bucket ?: '❌ NÃO DEFINIDO'));
        $this->newLine();

        if (!$url || !$token || !$org || !$bucket) {
            $this->error('Configurações incompletas! Verifique seu arquivo .env');
            return 1;
        }

        // 2. Testar conectividade básica
        $this->info('2. Testando conectividade com o servidor:');
        try {
            $client = new Client([
                'url' => $url,
                'token' => $token,
                'org' => $org,
                'bucket' => $bucket,
                'timeout' => 10,
                'verifySSL' => true,
                'debug' => false,
            ]);

            $this->line('   ✓ Cliente criado com sucesso');

        } catch (Exception $e) {
            $this->error("   ❌ Erro ao criar cliente: {$e->getMessage()}");
            return 1;
        }

        // 3. Testar Health Check
        $this->info('3. Testando Health Check:');
        try {
            $health = $client->health();
            
            $this->line("   Status: {$health->getStatus()}");
            $this->line("   Message: {$health->getMessage()}");
            $this->line("   Version: {$health->getVersion()}");
            
            if ($health->getStatus() === 'pass') {
                $this->info('   ✓ InfluxDB está saudável!');
            } else {
                $this->warn("   ⚠ Status: {$health->getStatus()}");
            }

        } catch (Exception $e) {
            $this->error("   ❌ Erro no health check: {$e->getMessage()}");
            $this->error("   Tipo: " . get_class($e));
            
            if (method_exists($e, 'getResponse')) {
                $response = $e->getResponse();
                if ($response) {
                    $this->error("   Status HTTP: " . $response->getStatusCode());
                    $this->error("   Body: " . $response->getBody());
                }
            }
        }
        $this->newLine();

        // 4. Testar Ping
        $this->info('4. Testando Ping:');
        try {
            $ping = $client->ping();
            $this->info("   ✓ Ping bem-sucedido!");
        } catch (Exception $e) {
            $this->error("   ❌ Erro no ping: {$e->getMessage()}");
        }
        $this->newLine();

        // 5. Verificar permissões do bucket
        $this->info('5. Verificando acesso ao bucket:');
        try {
            $queryApi = $client->createQueryApi();
            
            $query = "from(bucket: \"{$bucket}\")
  |> range(start: -1m)
  |> limit(n: 1)";

            $result = $queryApi->query($query);
            $this->info("   ✓ Query executada com sucesso!");
            $this->line("   Bucket '{$bucket}' está acessível");
            
        } catch (Exception $e) {
            $this->error("   ❌ Erro ao acessar bucket: {$e->getMessage()}");
            
            if (strpos($e->getMessage(), 'unauthorized') !== false) {
                $this->warn('   → Token pode não ter permissões corretas');
            }
            if (strpos($e->getMessage(), 'not found') !== false) {
                $this->warn("   → Bucket '{$bucket}' pode não existir");
            }
        }
        $this->newLine();

        // 6. Testar escrita
        $this->info('6. Testando escrita de dados:');
        try {
            $writeApi = $client->createWriteApi();
            
            $point = new \InfluxDB2\Point(
                'test_measurement',
                ['test_tag' => 'diagnostic'],
                ['test_field' => 1.0],
                time()
            );
            
            $writeApi->write($point);
            $writeApi->close();
            
            $this->info('   ✓ Escrita de teste bem-sucedida!');
            
        } catch (Exception $e) {
            $this->error("   ❌ Erro ao escrever: {$e->getMessage()}");
        }
        $this->newLine();

        $client->close();
        
        $this->info('=== FIM DO DIAGNÓSTICO ===');
        return 0;
    }
}