<?php

namespace App\Services\Reports;

use App\Models\Report;


interface ReportGeneratorInterface
{
    public function generate($report): array;
    
    public function calculateMetrics($devices, array $period): array;
    
    public function generateCharts(array $data): array;
    
    public function getTemplateName(): string;
    
    public function getType(): string;  
}