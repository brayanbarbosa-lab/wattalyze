<?php

namespace App\Services\Reports;


use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
USE App\Services\Reports\ReportGeneratorInterface;

/**
 * Factory para criação de geradores de relatórios
 * 
 * Padrão Factory para instanciar o gerador correto baseado no tipo
 * 
 * Uso:
 *   $generator = ReportGeneratorFactory::make('consumption');
 *   $data = $generator->generate($report);
 */
class ReportGeneratorFactory
{
    /**
     * Mapa de tipos de relatório para suas classes geradoras
     * 
     * @var array
     */
    private static array $generators = [
        'consumption' => \App\Services\Reports\Generators\ConsumptionReportGenerator::class,
        'cost' => \App\Services\Reports\Generators\CostReportGenerator::class,
        'efficiency' => \App\Services\Reports\Generators\EfficiencyReportGenerator::class,
        'comparative' => \App\Services\Reports\Generators\ComparativeReportGenerator::class,
        'custom' => \App\Services\Reports\Generators\CustomReportGenerator::class,
    ];

    /**
     * Cria e retorna uma instância do gerador apropriado
     * 
     * @param string $type - Tipo do relatório: 'consumption', 'cost', 'efficiency', 'comparative', 'custom'
     * @return ReportGeneratorInterface - Instância do gerador
     * @throws InvalidArgumentException - Se tipo não é válido
     */
    public static function make(string $type): ReportGeneratorInterface
    {
        // Normalizar tipo (lowercase)
        $type = strtolower(trim($type));

        // Validar tipo
        if (!isset(self::$generators[$type])) {
            Log::warning("Tentativa de criar gerador com tipo inválido: {$type}");
            throw new InvalidArgumentException(
                "Tipo de relatório inválido: '{$type}'. " .
                "Tipos disponíveis: " . implode(', ', array_keys(self::$generators))
            );
        }

        try {
            // Instanciar gerador
            $generatorClass = self::$generators[$type];
            $generator = new $generatorClass();

            // Validar interface
            if (!$generator instanceof ReportGeneratorInterface) {
                throw new \LogicException(
                    "Gerador {$generatorClass} não implementa ReportGeneratorInterface"
                );
            }

            Log::debug("Gerador '{$type}' criado com sucesso");
            return $generator;

        } catch (\Exception $e) {
            Log::error("Erro ao criar gerador '{$type}': " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retorna todos os tipos de relatório disponíveis com suas descrições
     * 
     * @return array - Array com formato: ['tipo' => 'Descrição']
     */
    public static function getAvailableTypes(): array
    {
        return [
            'consumption' => 'Análise de Consumo',
            'cost' => 'Análise de Custos',
            'efficiency' => 'Eficiência Energética',
            'comparative' => 'Relatório Comparativo',
            'custom' => 'Relatório Personalizado'
        ];
    }

    /**
     * Verifica se um tipo de relatório é válido
     * 
     * @param string $type - Tipo a validar
     * @return bool - True se válido, false caso contrário
     */
    public static function isValidType(string $type): bool
    {
        return isset(self::$generators[strtolower(trim($type))]);
    }

    /**
     * Retorna apenas a lista de tipos disponíveis
     * 
     * @return array - Array simples com tipos
     */
    public static function getTypes(): array
    {
        return array_keys(self::$generators);
    }

    /**
     * Obtém a descrição de um tipo específico
     * 
     * @param string $type - Tipo do relatório
     * @return string|null - Descrição ou null se não encontrado
     */
    public static function getTypeDescription(string $type): ?string
    {
        $type = strtolower(trim($type));
        $available = self::getAvailableTypes();
        return $available[$type] ?? null;
    }
}