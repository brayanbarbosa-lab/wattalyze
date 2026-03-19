<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ChartGeneratorTrait
{
    /**
     * Gera gráfico de pizza
     */
    protected function generatePieChart(array $labels, array $data, string $title): string
    {
        $colors = ['#2E8B57', '#3498db', '#e67e22', '#9b59b6', '#e74c3c', '#1abc9c', '#34495e'];

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff'
                ]]
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                        'labels' => [
                            'color' => '#333333',
                            'font' => [
                                'size' => 12
                            ],
                            'padding' => 15,
                            'usePointStyle' => true
                        ]
                    ],
                    'title' => [
                        'display' => true,
                        'text' => $title,
                        'font' => [
                            'size' => 16,
                            'weight' => 'bold'
                        ],
                        'color' => '#2D3748'
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig);
    }

    /**
     * Gera gráfico Doughnut
     */
    protected function generateDoughnutChart(array $labels, array $data, string $title): string
    {
        $colors = ['#2E8B57', '#3498db', '#e67e22', '#9b59b6', '#e74c3c', '#1abc9c', '#34495e'];

        $chartConfig = [
            'type' => 'doughnut',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff'
                ]]
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                        'labels' => [
                            'color' => '#333333',
                            'font' => [
                                'size' => 12
                            ],
                            'padding' => 15,
                            'usePointStyle' => true
                        ]
                    ],
                    'title' => [
                        'display' => true,
                        'text' => $title,
                        'font' => [
                            'size' => 16,
                            'weight' => 'bold'
                        ],
                        'color' => '#2D3748'
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig);
    }

    /**
     * Gera gráfico Gauge (medidor)
     */
    protected function generateGaugeChart(float $value, string $title): string
    {
        $color = $value >= 80 ? '#27ae60' : ($value >= 50 ? '#f39c12' : '#e74c3c');

        $chartConfig = [
            'type' => 'radialGauge',
            'data' => [
                'datasets' => [[
                    'data' => [$value],
                    'backgroundColor' => $color,
                    'borderWidth' => 0
                ]]
            ],
            'options' => [
                'responsive' => true,
                'domain' => [0, 100],
                'trackColor' => '#E2E8F0',
                'centerPercentage' => 80,
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => $title
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 400, 300);
    }

    /**
     * Gera Line Chart
     */
    protected function generateLineChart(array $labels, array $data, string $title, string $color = '#2E8B57'): string
    {
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => $title,
                    'data' => $data,
                    'borderColor' => $color,
                    'backgroundColor' => $color . '20',
                    'fill' => true,
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => $color
                ]]
            ],
            'options' => [
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig);
    }

    /**
     * Gera Heatmap simples
     */
    protected function generateHeatmapChart(array $data): string
    {
        // Validar se há dados
        if (empty($data)) {
            Log::warning("Tentativa de gerar heatmap com dados vazios");
            return '';
        }

        // Para heatmap simples, vamos usar um bar chart horizontal com cores graduadas
        $labels = array_keys($data);
        $values = array_values($data);
        $maxValue = max($values);

        // Gerar cores baseadas nos valores
        $colors = [];
        foreach ($values as $value) {
            $intensity = $maxValue > 0 ? ($value / $maxValue) : 0;
            $r = 46;
            $g = 139;
            $b = 87;
            $alpha = 0.3 + ($intensity * 0.7); // De 0.3 a 1.0
            $colors[] = "rgba($r, $g, $b, $alpha)";
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Consumo',
                    'data' => $values,
                    'backgroundColor' => $colors,
                    'borderWidth' => 1,
                    'borderColor' => '#ffffff'
                ]]
            ],
            'options' => [
                'indexAxis' => 'y',
                'responsive' => true,
                'scales' => [
                    'x' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 800, 600);
    }

    /**
     * Gera gráfico radar
     */
    protected function generateRadarChart(array $devicesData): string
    {
        $labels = ['Eficiência', 'Load Factor', 'Consistência', 'Otimização', 'Score Geral'];
        $datasets = [];
        $colors = ['#2E8B57', '#3498db', '#e67e22', '#9b59b6', '#e74c3c'];
        $index = 0;

        foreach ($devicesData as $deviceName => $metrics) {
            // Extrair métricas para o radar
            $efficiencyScore = $metrics['efficiency_score'] ?? 50;
            $loadFactor = $metrics['load_factor'] ?? 50;

            $radarData = [
                $efficiencyScore,
                $loadFactor,
                80, // Consistência (placeholder)
                70, // Otimização (placeholder)
                ($efficiencyScore + $loadFactor) / 2 // Score Geral calculado corretamente
            ];

            $color = $colors[$index % count($colors)];

            $datasets[] = [
                'label' => $deviceName,
                'data' => $radarData,
                'borderColor' => $color,
                'backgroundColor' => $color . '40',
                'borderWidth' => 2
            ];

            $index++;
        }

        // Se não houver datasets, não gerar gráfico
        if (empty($datasets)) {
            Log::warning("Tentativa de gerar radar chart sem dados");
            return '';
        }

        $chartConfig = [
            'type' => 'radar',
            'data' => [
                'labels' => $labels,
                'datasets' => $datasets
            ],
            'options' => [
                'responsive' => true,
                'scales' => [
                    'r' => [
                        'beginAtZero' => true,
                        'max' => 100
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 600, 600);
    }

    /**
     * Gera gráfico de barras agrupadas
     */
    protected function generateGroupedBarChart(array $devicesData): string
    {
        if (empty($devicesData)) {
            Log::warning("Tentativa de gerar grouped bar chart sem dados");
            return '';
        }

        $labels = array_keys($devicesData);
        $currentValues = array_column($devicesData, 'current_total');
        $previousValues = array_column($devicesData, 'previous_total');

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Período Atual',
                        'data' => $currentValues,
                        'backgroundColor' => '#2E8B5780',
                        'borderColor' => '#2E8B57',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Período Anterior',
                        'data' => $previousValues,
                        'backgroundColor' => '#3498db80',
                        'borderColor' => '#3498db',
                        'borderWidth' => 1
                    ]
                ]
            ],
            'options' => [
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 800, 400);
    }

    /**
     * Gera Multi-line Chart (Tendências)
     */
    protected function generateMultiLineTrendChart(array $devicesData): string
    {
        if (empty($devicesData)) {
            Log::warning("Tentativa de gerar multi-line chart sem dados");
            return '';
        }

        $labels = [];
        $datasets = [];
        $colors = ['#2E8B57', '#3498db', '#e67e22', '#9b59b6', '#e74c3c'];

        // Obter todas as datas/labels
        foreach ($devicesData as $device => $data) {
            if (is_array($data) && isset($data['current_total'])) {
                $labels[] = $device;
            }
        }

        // Criar dataset por dispositivo
        $index = 0;
        foreach ($devicesData as $device => $data) {
            if (is_array($data) && isset($data['current_total'])) {
                $datasets[] = [
                    'label' => $device,
                    'data' => [$data['current_total'] ?? 0],
                    'borderColor' => $colors[$index % count($colors)],
                    'backgroundColor' => $colors[$index % count($colors)] . '20',
                    'fill' => true,
                    'borderWidth' => 2,
                    'tension' => 0.4
                ];
                $index++;
            }
        }

        if (empty($datasets)) {
            return '';
        }

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => !empty($labels) ? $labels : ['Período'],
                'datasets' => $datasets
            ],
            'options' => [
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 1000, 500);
    }

    /**
     * Gera Stacked Area Chart
     */
    protected function generateStackedAreaChart(array $devicesData): string
    {
        if (empty($devicesData)) {
            Log::warning("Tentativa de gerar stacked area chart sem dados");
            return '';
        }

        $labels = array_keys($devicesData);
        $datasets = [];
        $colors = ['#2E8B57', '#3498db', '#e67e22', '#9b59b6', '#e74c3c'];
        $index = 0;

        foreach ($devicesData as $device => $data) {
            $value = is_array($data) ? ($data['current_total'] ?? 0) : 0;

            $datasets[] = [
                'label' => $device,
                'data' => [$value],
                'backgroundColor' => $colors[$index % count($colors)] . '80',
                'borderColor' => $colors[$index % count($colors)],
                'fill' => true,
                'borderWidth' => 2
            ];
            $index++;
        }

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => ['Consumo'],
                'datasets' => $datasets
            ],
            'options' => [
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'stacked' => true,
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 900, 450);
    }

    /**
     * Gera Bullet Charts
     */
    protected function generateBulletCharts(array $devicesData): string
    {
        if (empty($devicesData)) {
            Log::warning("Tentativa de gerar bullet chart sem dados");
            return '';
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($devicesData),
                'datasets' => [[
                    'data' => array_column($devicesData, 'current_total'),
                    'backgroundColor' => '#2E8B57',
                    'borderColor' => '#1F5F3F',
                    'borderWidth' => 1
                ]]
            ],
            'options' => [
                'indexAxis' => 'y',
                'responsive' => true,
                'scales' => [
                    'x' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 600, 300);
    }

    /**
     * Gera Ranking Bar Chart
     */
    protected function generateRankingBarChart(array $ranking): string
    {
        if (empty($ranking)) {
            Log::warning("Tentativa de gerar ranking chart sem dados");
            return '';
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($ranking),
                'datasets' => [[
                    'data' => array_values($ranking),
                    'backgroundColor' => '#2E8B57',
                    'borderColor' => '#1F5F3F',
                    'borderWidth' => 1
                ]]
            ],
            'options' => [
                'indexAxis' => 'y',
                'responsive' => true,
                'scales' => [
                    'x' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];

        return $this->generateChartUrl($chartConfig, 800, 400);
    }

    /**
     * Gera URL do QuickChart
     */
    protected function generateChartUrl(array $config, int $width = 800, int $height = 400): string
    {
        try {
            $jsonConfig = json_encode($config);

            if ($jsonConfig === false) {
                throw new \Exception('Erro ao codificar configuração JSON: ' . json_last_error_msg());
            }

            $encodedConfig = urlencode($jsonConfig);
            $url = "https://quickchart.io/chart?c={$encodedConfig}&format=png&backgroundColor=white&width={$width}&height={$height}&devicePixelRatio=2";

            // Verificar se a URL não está muito longa (limite de QuickChart é ~16KB)
            if (strlen($url) > 16000) {
                Log::warning("URL do gráfico muito longa: " . strlen($url) . " bytes");
                throw new \Exception('Configuração do gráfico muito grande');
            }

            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'method' => 'GET',
                    'ignore_errors' => true
                ]
            ]);

            $imageContents = @file_get_contents($url, false, $context);

            if ($imageContents === false) {
                $error = error_get_last();
                throw new \Exception('Falha ao gerar gráfico: ' . ($error['message'] ?? 'Erro desconhecido'));
            }

            // Verificar se a resposta é realmente uma imagem
            if (substr($imageContents, 0, 4) !== "\x89PNG") {
                Log::error("Resposta do QuickChart não é PNG válido. Resposta: " . substr($imageContents, 0, 200));
                throw new \Exception('Resposta inválida do serviço de gráficos');
            }

            return "data:image/png;base64," . base64_encode($imageContents);

        } catch (\Exception $e) {
            Log::error("Erro ao gerar gráfico: " . $e->getMessage(), [
                'config' => $config,
                'width' => $width,
                'height' => $height
            ]);

            // Retornar uma imagem de erro placeholder em base64
            return $this->generateErrorPlaceholder();
        }
    }

    /**
     * Gera um placeholder de erro
     */
    private function generateErrorPlaceholder(): string
    {
        // PNG 1x1 transparente em base64
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
    }
}