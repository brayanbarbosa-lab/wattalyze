@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-orange: #e67e22;
        --primary-blue: #3498db;
        --bg-light: #f8f9fa;
        --text-muted: #6c757d;
        --border-radius: 16px;
        --border-radius-small: 8px;
        --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.08);
        --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --spacing-xs: 0.5rem;
        --spacing-sm: 1rem;
        --spacing-md: 1.5rem;
        --spacing-lg: 2rem;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    /* Container principal responsivo */
    .main-container {
        width: 100%;
        padding: var(--spacing-sm);
        margin: 0 auto;
        min-height: 100vh;
    }

    /* Navegação com abas responsiva */
    .nav-tabs {
        border: none;
        margin-bottom: var(--spacing-md);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 8px;
        box-shadow: var(--shadow-light);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nav-tabs .nav-item {
        margin-bottom: 0;
    }

    .nav-tabs .nav-link {
        color: var(--text-muted);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 16px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        text-decoration: none;
        will-change: transform;
    }

    .nav-tabs .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        opacity: 0;
        transition: var(--transition);
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white !important;
        box-shadow: var(--shadow-light);
        transform: translateY(-1px);
    }

    .nav-tabs .nav-link:hover:not(.active) {
        background: rgba(39, 174, 96, 0.1);
        color: var(--primary-green);
        transform: translateY(-1px);
    }

    /* Tabela responsiva moderna */
    .modern-table-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        transition: var(--transition);
    }

    .modern-table-container:hover {
        box-shadow: var(--shadow-medium);
    }

    /* Tabela desktop */
    .table {
        margin: 0;
        border: none;
    }

    .table thead {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .table thead th {
        border: none;
        font-weight: 700;
        font-size: clamp(0.75rem, 2vw, 0.9rem);
        padding: var(--spacing-md) var(--spacing-sm);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        border: none;
        transition: var(--transition);
        position: relative;
    }

    .table tbody tr::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: var(--primary-green);
        transition: var(--transition);
    }

    .table tbody tr:hover {
        background: rgba(39, 174, 96, 0.05);
        transform: translateX(4px);
    }

    .table tbody tr:hover::before {
        width: 4px;
    }

    .table tbody td {
        border: none;
        padding: var(--spacing-md) var(--spacing-sm);
        vertical-align: middle;
        font-weight: 500;
        color: var(--primary-dark);
    }

    /* Cards para mobile */
    .alert-card-mobile {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: var(--spacing-sm);
        overflow: hidden;
        position: relative;
        display: none;
    }

    .alert-card-mobile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--status-color), var(--status-color-dark));
    }

    .alert-card-mobile.resolved {
        --status-color: #27ae60;
        --status-color-dark: #229954;
    }

    .alert-card-mobile.active {
        --status-color: #f39c12;
        --status-color-dark: #e67e22;
    }

    .alert-card-body {
        padding: var(--spacing-md);
    }

    .alert-card-title {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-xs);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-card-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: var(--spacing-xs);
        margin-bottom: var(--spacing-sm);
    }

    .alert-card-meta-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .alert-card-meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .alert-card-meta-value {
        font-size: 0.85rem;
        color: var(--primary-dark);
        font-weight: 500;
    }

    /* Badges modernos */
    .modern-status-badge {
        background: linear-gradient(135deg, var(--badge-color), var(--badge-color-dark));
        color: white;
        border: none;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: var(--shadow-light);
    }

    .modern-status-badge.resolved {
        --badge-color: #27ae60;
        --badge-color-dark: #229954;
    }

    .modern-status-badge.active {
        --badge-color: #f39c12;
        --badge-color-dark: #e67e22;
        color: var(--primary-dark);
    }

    /* Estado vazio responsivo */
    .empty-state {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: var(--spacing-xl) var(--spacing-md);
        text-align: center;
        box-shadow: var(--shadow-light);
        margin-top: var(--spacing-md);
    }

    .empty-state-icon {
        font-size: clamp(3rem, 8vw, 4rem);
        margin-bottom: var(--spacing-md);
        color: var(--text-muted);
    }

    .empty-state-title {
        font-size: clamp(1.2rem, 4vw, 1.4rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state-message {
        color: var(--text-muted);
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
    }

    /* Media Queries */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }

        .nav-tabs {
            flex-direction: row;
            gap: 8px;
        }
    }

    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        .alert-card-mobile {
            display: none !important;
        }

        .modern-table-container {
            display: block !important;
        }
    }

    @media (min-width: 1200px) {
        .main-container {
            margin-left: 25vw;
            max-width: 70vw;
        }
    }

    @media (max-width: 767.98px) {
        .modern-table-container {
            display: none !important;
        }

        .alert-card-mobile {
            display: block !important;
        }

        .nav-tabs .nav-link {
            justify-content: center;
        }
    }

    /* Animações */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }
</style>

<div class="main-container">
    <!-- Navegação com abas -->
    <ul class="nav nav-tabs animate-fade-in">
        <li class="nav-item">
            <a href="{{ route('alerts.rules') }}" class="nav-link {{ request()->routeIs('alerts.rules') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Regras de Alerta</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('alerts.active') }}" class="nav-link {{ request()->routeIs('alerts.active') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Alertas Ativos</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('alerts.history') }}" class="nav-link {{ request()->routeIs('alerts.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Histórico</span>
            </a>
        </li>
    </ul>

    @if($alerts->isEmpty())
    <div class="empty-state animate-fade-in" style="animation-delay: 0.2s;">
        <div class="empty-state-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <h3 class="empty-state-title">Histórico vazio</h3>
        <p class="empty-state-message">Nenhum alerta foi registrado ainda em seu sistema.</p>
    </div>
    @else
    <!-- Tabela Desktop -->
    <div class="modern-table-container animate-fade-in" style="animation-delay: 0.2s;">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><i class="bi bi-card-text me-2"></i>Título</th>
                        <th><i class="bi bi-cpu me-2"></i>Dispositivo</th>
                        <th><i class="bi bi-house me-2"></i>Ambiente</th>
                        <th><i class="bi bi-info-circle me-2"></i>Status</th>
                        <th><i class="bi bi-calendar3 me-2"></i>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alerts as $alert)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                <strong>{{ $alert->title }}</strong>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cpu text-primary me-2"></i>
                                {{ $alert->device->name ?? 'Não especificado' }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-house text-success me-2"></i>
                                {{ $alert->environment->name ?? 'Não especificado' }}
                            </div>
                        </td>
                        <td>
                            @if($alert->is_resolved)
                            <span class="modern-status-badge resolved">
                                <i class="bi bi-check-circle"></i>
                                Resolvido
                            </span>
                            @else
                            <span class="modern-status-badge active">
                                <i class="bi bi-exclamation-circle"></i>
                                Ativo
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="fw-bold">{{ $alert->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $alert->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards Mobile -->
    @foreach($alerts as $index => $alert)
    <div class="alert-card-mobile {{ $alert->is_resolved ? 'resolved' : 'active' }} animate-fade-in"
        style="animation-delay: {{ 0.2 + ($index * 0.1) }}s;">
        <div class="alert-card-body">
            <div class="alert-card-title">
                <i class="bi bi-exclamation-triangle"></i>
                {{ $alert->title }}
            </div>

            <div class="alert-card-meta">
                <div class="alert-card-meta-item">
                    <div class="alert-card-meta-label">Dispositivo</div>
                    <div class="alert-card-meta-value">{{ $alert->device->name ?? 'Não especificado' }}</div>
                </div>
                <div class="alert-card-meta-item">
                    <div class="alert-card-meta-label">Ambiente</div>
                    <div class="alert-card-meta-value">{{ $alert->environment->name ?? 'Não especificado' }}</div>
                </div>
                <div class="alert-card-meta-item">
                    <div class="alert-card-meta-label">Data</div>
                    <div class="alert-card-meta-value">{{ $alert->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="alert-card-meta-item">
                    <div class="alert-card-meta-label">Status</div>
                    <div class="alert-card-meta-value">
                        @if($alert->is_resolved)
                        <span class="modern-status-badge resolved">
                            <i class="bi bi-check-circle"></i>
                            Resolvido
                        </span>
                        @else
                        <span class="modern-status-badge active">
                            <i class="bi bi-exclamation-circle"></i>
                            Ativo
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    
    @endif
</div>