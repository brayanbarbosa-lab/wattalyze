
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alerta de Sistema - Wattalyze</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(39, 174, 96, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(44, 62, 80, 0.2) 0%, transparent 50%);
            z-index: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .alert-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 20px;
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .logo {
            background: linear-gradient(135deg, #27ae60, #2c3e50);
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .logo svg {
            width: 32px;
            height: 32px;
            color: white;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .brand-name {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .alert-header {
            text-align: center;
            margin-bottom: 32px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
        }
        
        .alert-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .severity-critical { 
            color: #dc3545; 
            background: rgba(220, 53, 69, 0.1);
            padding: 8px 16px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }
        
        .severity-high { 
            color: #fd7e14; 
            background: rgba(253, 126, 20, 0.1);
            padding: 8px 16px;
            border-radius: 8px;
            border-left: 4px solid #fd7e14;
        }
        
        .severity-medium { 
            color: #ffc107; 
            background: rgba(255, 193, 7, 0.1);
            padding: 8px 16px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
        }
        
        .severity-low { 
            color: #28a745; 
            background: rgba(40, 167, 69, 0.1);
            padding: 8px 16px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .timestamp {
            color: #6c757d;
            font-size: 14px;
            font-weight: 400;
        }
        
        .alert-message {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        
        .message-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .message-icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            color: #27ae60;
        }
        
        .message-content {
            font-size: 16px;
            line-height: 1.6;
            color: #495057;
        }
        
        .alert-details {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        
        .details-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .details-icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            color: #27ae60;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #495057;
            font-size: 14px;
        }
        
        .detail-value {
            color: #212529;
            font-weight: 600;
            text-align: right;
        }
        
        .critical-value {
            color: #dc3545 !important;
            background: rgba(220, 53, 69, 0.1);
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .btn-container {
            text-align: center;
            margin: 32px 0;
        }
        
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 8px 20px -4px rgba(39, 174, 96, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-icon {
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .footer {
            text-align: center;
            padding: 24px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: #6c757d;
            font-size: 13px;
        }
        
        .footer-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
        }
        
        .footer p {
            margin-bottom: 8px;
        }
        
        .footer p:last-child {
            margin-bottom: 0;
        }
        
        /* Responsividade para emails */
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
            
            .alert-card {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
            
            .detail-value {
                text-align: left;
            }
            
            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="alert-card">
            <!-- Logo e Branding -->
            <div class="logo-section">
                <div class="logo">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="brand-name">Wattalyze</div>
            </div>

            <!-- Header do Alerta -->
            <div class="alert-header">
                <div class="alert-title severity-{{ $alert->severity ?? 'medium' }}">
                    {{ $alert->title ?? 'Alerta do Sistema' }}
                </div>
                <div class="timestamp">
                    {{ $alert->created_at ? $alert->created_at->format('d/m/Y às H:i:s') : now()->format('d/m/Y às H:i:s') }}
                </div>
            </div>

            <!-- Mensagem do Alerta -->
            <div class="alert-message">
                <div class="message-title">
                    <svg class="message-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Mensagem do Alerta
                </div>
                <div class="message-content">
                    {{ $alert->message ?? 'Nenhuma mensagem disponível.' }}
                </div>
            </div>

            <!-- Detalhes do Alerta -->
            <div class="alert-details">
                <div class="details-title">
                    <svg class="details-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M12 1v6m0 6v6m11-7h-6m-6 0H1"/>
                    </svg>
                    Detalhes do Alerta
                </div>
                
                @if(isset($device) && $device)
                <div class="detail-row">
                    <span class="detail-label">Dispositivo:</span>
                    <span class="detail-value">{{ $device->name ?? 'N/A' }}</span>
                </div>
                @endif

                @if(isset($environment) && $environment)
                <div class="detail-row">
                    <span class="detail-label">Ambiente:</span>
                    <span class="detail-value">{{ $environment->name ?? 'N/A' }}</span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Tipo:</span>
                    <span class="detail-value">{{ $alert->type ? ucfirst(str_replace('_', ' ', $alert->type)) : 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Severidade:</span>
                    <span class="status-badge severity-{{ $alert->severity ?? 'medium' }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        {{ strtoupper($alert->severity ?? 'MEDIUM') }}
                    </span>
                </div>

                @if($alert->threshold_value ?? false)
                <div class="detail-row">
                    <span class="detail-label">Limite Configurado:</span>
                    <span class="detail-value">
                        {{ $alert->threshold_value }} 
                        @if($alert->type ?? false)
                            @switch($alert->type)
                                @case('consumption_threshold')
                                    kWh
                                    @break
                                @case('cost_threshold')
                                    R$
                                    @break
                                @case('offline_duration')
                                    minutos
                                    @break
                            @endswitch
                        @endif
                    </span>
                </div>
                @endif

                @if($alert->actual_value ?? false)
                <div class="detail-row">
                    <span class="detail-label">Valor Detectado:</span>
                    <span class="detail-value critical-value">
                        {{ $alert->actual_value }}
                        @if($alert->type ?? false)
                            @switch($alert->type)
                                @case('consumption_threshold')
                                    kWh
                                    @break
                                @case('cost_threshold')
                                    R$
                                    @break
                                @case('offline_duration')
                                    minutos
                                    @break
                            @endswitch
                        @endif
                    </span>
                </div>
                @endif
            </div>

            <!-- Botão de Ação -->
            <div class="btn-container">
                <a href="{{ config('app.url') }}/alerts/active" class="btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Ver Alertas Ativos
                </a>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="footer-title">Sistema de Monitoramento Energético</div>
                <p>Este email foi gerado automaticamente pelo sistema Wattalyze.</p>
                <p>Para gerenciar suas notificações, acesse as configurações da sua conta.</p>
                <p><strong>© 2025 Wattalyze</strong> - Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
