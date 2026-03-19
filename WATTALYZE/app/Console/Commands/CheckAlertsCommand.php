<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckAlertsJob;

class CheckAlertsCommand extends Command
{
    protected $signature = 'alerts:check';
    protected $description = 'Verifica alertas de consumo';

    public function handle()
    {
        $this->info('Executando verificação de alertas...');
        
        $job = new CheckAlertsJob();
        $job->handle();
        
        $this->info('Verificação concluída! Veja os logs para detalhes.');
    }
}
