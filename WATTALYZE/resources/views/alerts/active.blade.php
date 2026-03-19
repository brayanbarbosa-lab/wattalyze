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
        --spacing-xl: 3rem;
    }

    /* Body e Container */
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    /* Container responsivo */
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
        font-size: clamp(0.75rem, 2vw, 0.9rem);
        text-decoration: none;
        will-change: transform;
        text-align: center;
        justify-content: center;
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

    /* Título moderno responsivo */
    .modern-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-lg);
        position: relative;
        display: flex;
        align-items: center;
    }

    .modern-title::before {
        content: '';
        width: 4px;
        height: clamp(30px, 8vw, 40px);
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        border-radius: 2px;
        margin-right: 16px;
    }

    /* Cards de alerta modernos e responsivos */
    .alert-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        margin-bottom: var(--spacing-md);
    }

    .alert-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-red), #ec7063);
    }

    .alert-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-medium);
    }

    .alert-card .card-body {
        flex-grow: 1;
        padding: var(--spacing-md);
        display: flex;
        flex-direction: column;
    }

    .alert-card-title {
        font-size: clamp(1rem, 3vw, 1.2rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-sm);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-card-title::before {
        content: '⚠️';
        font-size: 1.4rem;
    }

    .alert-meta {
        margin-bottom: var(--spacing-sm);
    }

    .alert-meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        flex-wrap: wrap;
        gap: 4px;
    }

    .alert-meta-icon {
        min-width: 16px;
        height: 16px;
        color: var(--primary-green);
    }

    .alert-message {
        background: rgba(231, 76, 60, 0.1);
        border-left: 4px solid var(--primary-red);
        padding: 12px 16px;
        border-radius: 8px;
        margin: var(--spacing-sm) 0;
        color: var(--primary-dark);
        font-weight: 500;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        line-height: 1.5;
    }

    /* Grupo de ações responsivo */
    .modern-action-group {
        margin-top: auto;
        padding-top: var(--spacing-sm);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .modern-action-btn {
        padding: 10px 16px;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: clamp(0.75rem, 2.5vw, 0.9rem);
        flex: 1;
        max-width: 200px;
    }

    .modern-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        pointer-events: none;
    }

    .modern-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-resolve {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .btn-acknowledge {
        background: linear-gradient(135deg, var(--primary-blue), #5dade2);
        color: white;
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
        color: var(--primary-green);
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

    /* Paginação responsiva */
    .pagination {
        justify-content: center !important;
        margin-top: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .pagination .page-item .page-link {
        border: none;
        border-radius: 12px;
        margin: 2px 4px;
        padding: 8px 12px;
        color: var(--text-muted);
        background: rgba(255, 255, 255, 0.8);
        transition: var(--transition);
        font-size: clamp(0.75rem, 2.5vw, 0.9rem);
        min-width: 40px;
        text-align: center;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
        box-shadow: var(--shadow-light);
    }

    .pagination .page-item .page-link:hover {
        background: rgba(39, 174, 96, 0.1);
        color: var(--primary-green);
        transform: translateY(-1px);
    }

    /* Grid responsivo para cards */
    .alerts-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--spacing-md);
        margin-top: var(--spacing-md);
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

    /* Media Queries */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }

        .nav-tabs {
            flex-direction: row;
            gap: 8px;
        }

        .nav-tabs .nav-link {
            justify-content: flex-start;
            text-align: left;
        }

        .alerts-grid {
            grid-template-columns: 1fr;
        }

        .modern-action-group {
            flex-wrap: nowrap;
        }

        .modern-action-btn {
            flex: 0 1 auto;
        }
    }

    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        .alerts-grid {
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        }
    }

    @media (min-width: 992px) {
        .alerts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .main-container {
            margin-left: 25vw;
            max-width: 70vw;
        }
    }

    /* Mobile - mantém os nomes sempre visíveis */
    @media (max-width: 575.98px) {
        .modern-action-group {
            flex-direction: column;
        }

        .modern-action-btn {
            min-width: auto;
            max-width: none;
        }

        .alert-meta-item {
            font-size: 0.8rem;
        }
    }
</style>

<div class="main-container">
    {{-- Navegação com abas --}}
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

    <h2 class="modern-title animate-fade-in" style="animation-delay: 0.1s;">
        Alertas Ativos
    </h2>

    @if($alerts->isEmpty())
        <div class="empty-state animate-fade-in" style="animation-delay: 0.2s;">
            <div class="empty-state-icon">🛡️</div>
            <h3 class="empty-state-title">Tudo sob controle!</h3>
            <p class="empty-state-message">Nenhum alerta ativo no momento. Seu sistema está funcionando perfeitamente.</p>
        </div>
    @else
        <div class="alerts-grid animate-fade-in" style="animation-delay: 0.2s;">
            @foreach($alerts as $index => $alert)
            <div class="animate-fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                <div class="card alert-card">
                    <div class="card-body">
                        <h5 class="alert-card-title">{{ $alert->title }}</h5>
                        
                        <div class="alert-meta">
                            <div class="alert-meta-item">
                                <i class="bi bi-cpu alert-meta-icon"></i>
                                <strong>Dispositivo:</strong>
                                <span>{{ $alert->device->name ?? 'Não especificado' }}</span>
                            </div>
                            <div class="alert-meta-item">
                                <i class="bi bi-house alert-meta-icon"></i>
                                <strong>Ambiente:</strong>
                                <span>{{ $alert->environment->name ?? 'Não especificado' }}</span>
                            </div>
                        </div>

                        <div class="alert-message">
                            {{ $alert->message }}
                        </div>

                        <div class="modern-action-group">
                            <form action="{{ route('alerts.resolve', $alert->id) }}" method="POST" class="d-inline flex-fill">
                                @csrf
                                <button class="btn modern-action-btn btn-resolve w-100" type="submit">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Resolver</span>
                                </button>
                            </form>
                            <form action="{{ route('alerts.acknowledge', $alert->id) }}" method="POST" class="d-inline flex-fill">
                                @csrf
                                <button class="btn modern-action-btn btn-acknowledge w-100" type="submit">
                                    <i class="bi bi-eye"></i>
                                    <span>Marcar como lido</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

       
    @endif
</div>

<!-- FontAwesome e Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">