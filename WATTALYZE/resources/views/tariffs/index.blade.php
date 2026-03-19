@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
        --primary-blue: #3498db;
        --primary-orange: #e67e22;
        --primary-purple: #9b59b6;
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

    /* Reset e otimizações base */
    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Container principal responsivo */
    .main-container {
        width: 100%;
        padding: var(--spacing-sm);
        margin: 0 auto;
        min-height: 100vh;
    }

    /* Header responsivo */
    .header-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        border: none;
    }

    .header-content {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        align-items: flex-start;
    }

    .modern-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
        position: relative;
        line-height: 1.2;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .modern-title::before {
        content: '';
        width: 4px;
        height: clamp(30px, 6vw, 40px);
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* Cards modernos responsivos */
    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        margin-bottom: var(--spacing-md);
        position: relative;
        will-change: transform;
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
    }

    .modern-card.success {
        border-left: 4px solid var(--primary-green);
        padding: var(--spacing-md);
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05));
        color: #155724;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .modern-card.success::before {
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
    }

    .modern-card.success i {
        color: var(--primary-green);
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Botões modernos responsivos */
    .btn-modern {
        border-radius: var(--border-radius-small);
        padding: clamp(8px, 2vw, 12px) clamp(16px, 4vw, 20px);
        font-weight: 600;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
        will-change: transform;
        min-height: 44px;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        pointer-events: none;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-success.btn-modern {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .btn-primary.btn-modern {
        background: linear-gradient(135deg, var(--primary-blue), #5dade2);
        color: white;
    }

    .btn-danger.btn-modern {
        background: linear-gradient(135deg, var(--primary-red), #ec7063);
        color: white;
    }

    .btn-sm.btn-modern {
        padding: 6px 12px;
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        min-height: 36px;
    }

    /* Tabela moderna responsiva */
    .table-modern-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        transition: var(--transition);
    }

    .table-modern-container:hover {
        box-shadow: var(--shadow-medium);
    }

    .table-modern {
        margin: 0;
        border: none;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-modern thead {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
        color: white;
    }

    .table-modern thead th {
        border: none;
        font-weight: 700;
        font-size: clamp(0.75rem, 2vw, 0.9rem);
        padding: var(--spacing-md) var(--spacing-sm);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table-modern tbody tr {
        border: none;
        transition: var(--transition);
        position: relative;
    }

    .table-modern tbody tr::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: var(--primary-green);
        transition: var(--transition);
    }

    .table-modern tbody tr:hover {
        background: rgba(39, 174, 96, 0.05);
        transform: translateX(4px);
    }

    .table-modern tbody tr:hover::before {
        width: 4px;
    }

    .table-modern tbody td {
        border: none;
        padding: var(--spacing-md) var(--spacing-sm);
        vertical-align: middle;
        font-weight: 500;
        color: var(--primary-dark);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
    }

    /* Cards para mobile */
    .tariff-card-mobile {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: var(--spacing-sm);
        overflow: hidden;
        position: relative;
        display: none;
        transition: var(--transition);
    }

    .tariff-card-mobile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--status-color), var(--status-color-dark));
    }

    .tariff-card-mobile.active {
        --status-color: #27ae60;
        --status-color-dark: #229954;
    }

    .tariff-card-mobile.inactive {
        --status-color: #95a5a6;
        --status-color-dark: #7f8c8d;
    }

    .tariff-card-mobile:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .tariff-card-body {
        padding: var(--spacing-md);
    }

    .tariff-card-title {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-xs);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tariff-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-md);
    }

    .tariff-card-meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .tariff-card-meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .tariff-card-meta-value {
        font-size: 0.9rem;
        color: var(--primary-dark);
        font-weight: 500;
    }

    .tariff-card-actions {
        display: flex;
        gap: var(--spacing-xs);
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Badge de status responsivo */
    .badge-status {
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
        white-space: nowrap;
    }

    .badge-active {
        --badge-color: #27ae60;
        --badge-color-dark: #229954;
    }

    .badge-inactive {
        --badge-color: #95a5a6;
        --badge-color-dark: #7f8c8d;
    }

    .badge-status i {
        font-size: 0.7rem;
        flex-shrink: 0;
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
        opacity: 0.6;
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
        margin-bottom: var(--spacing-md);
    }

    .empty-state-action {
        margin-top: var(--spacing-md);
    }

    /* Action group responsivo */
    .action-group {
        display: flex;
        gap: 4px;
        align-items: center;
        justify-content: center;
    }

    /* Stats cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-md);
    }

    .stat-card {
        background: linear-gradient(135deg, var(--stat-color), var(--stat-color-dark));
        color: white;
        border-radius: var(--border-radius-small);
        padding: var(--spacing-md);
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .stat-card.total {
        --stat-color: #2c3e50;
        --stat-color-dark: #34495e;
    }

    .stat-card.active {
        --stat-color: #27ae60;
        --stat-color-dark: #229954;
    }

    .stat-card.inactive {
        --stat-color: #95a5a6;
        --stat-color-dark: #7f8c8d;
    }

    .stat-number {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .stat-label {
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        opacity: 0.9;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    /* Media Queries - Mobile First */

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-md);
        }

        .header-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .tariff-card-actions {
            justify-content: flex-start;
        }

        .action-group {
            justify-content: flex-start;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        /* Mostrar tabela, ocultar cards */
        .table-modern-container {
            display: block !important;
        }

        .tariff-card-mobile {
            display: none !important;
        }

        .table-modern tbody tr:hover {
            transform: translateX(4px);
        }

        .modern-card {
            padding: var(--spacing-lg);
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .main-container {
            max-width: 1200px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 24vw;
            max-width: 70vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 20vw;
            max-width: 75vw;
        }
    }

    /* Mobile específico */
    @media (max-width: 767.98px) {
        .table-modern-container {
            display: none !important;
        }

        .tariff-card-mobile {
            display: block !important;
        }

        .header-content {
            text-align: center;
        }

        .btn-modern {
            width: 100%;
            max-width: 280px;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Reduce motion para acessibilidade */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Print styles */
    @media print {
        .main-container {
            margin: 0 !important;
            max-width: 100% !important;
            padding: var(--spacing-sm) !important;
        }

        .modern-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .btn-modern {
            display: none !important;
        }
    }
</style>

<div class="main-container">
    <!-- Header responsivo -->
    <div class="header-section animate-fade-in">
        <div class="header-content">
            <h1 class="modern-title">
                <i class="bi bi-receipt"></i>
                Tarifas de Energia
            </h1>
            <a href="{{ route('tariffs.create') }}" class="btn btn-success btn-modern">
                <i class="bi bi-plus-circle"></i>
                <span>Nova Tarifa</span>
            </a>
        </div>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="modern-card success animate-fade-in" style="animation-delay: 0.1s;">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($tariffs->count())
        <!-- Stats cards -->
        @php
            $totalTariffs = $tariffs->total() ?? $tariffs->count();
            $activeTariffs = $tariffs->where('is_active', true)->count();
            $inactiveTariffs = $totalTariffs - $activeTariffs;
        @endphp

        <div class="stats-container animate-fade-in" style="animation-delay: 0.2s;">
            <div class="stat-card total">
                <h3 class="stat-number">{{ $totalTariffs }}</h3>
                <p class="stat-label">Total</p>
            </div>
            <div class="stat-card active">
                <h3 class="stat-number">{{ $activeTariffs }}</h3>
                <p class="stat-label">Ativas</p>
            </div>
            <div class="stat-card inactive">
                <h3 class="stat-number">{{ $inactiveTariffs }}</h3>
                <p class="stat-label">Inativas</p>
            </div>
        </div>

        <!-- Tabela Desktop -->
        <div class="table-modern-container animate-fade-in" style="animation-delay: 0.3s;">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th></th>
                            <th><i class="bi bi-tag me-2"></i>Nome</th>
                            <th><i class="bi bi-building me-2"></i>Provedor</th>
                            <th><i class="bi bi-list-ul me-2"></i>Tipo</th>
                            <th><i class="bi bi-check-circle me-2"></i>Status</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tariffs as $tariff)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-receipt text-primary me-2"></i>
                                    <strong>{{ $tariff->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-building text-info me-2"></i>
                                    {{ $tariff->provider ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-collection text-secondary me-2"></i>
                                    {{ $tariff->tariff_type ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-status {{ $tariff->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    <i class="bi bi-{{ $tariff->is_active ? 'check-circle' : 'x-circle' }}"></i>
                                    {{ $tariff->is_active ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">

                                    <a href="{{ route('tariffs.edit', $tariff) }}" 
                                       class="btn btn-primary btn-sm btn-modern" 
                                       title="Editar tarifa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tariffs.destroy', $tariff) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta tarifa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-modern" 
                                                type="submit" title="Excluir tarifa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cards Mobile -->
        @foreach($tariffs as $index => $tariff)
        <div class="tariff-card-mobile {{ $tariff->is_active ? 'active' : 'inactive' }} animate-fade-in" 
             style="animation-delay: {{ 0.4 + ($index * 0.1) }}s;">
            <div class="tariff-card-body">
                <div class="tariff-card-title">
                    <i class="bi bi-receipt text-primary"></i>
                    {{ $tariff->name }}
                </div>
                
                <div class="tariff-card-meta">
                    <div class="tariff-card-meta-item">
                        <div class="tariff-card-meta-label">Provedor</div>
                        <div class="tariff-card-meta-value">{{ $tariff->provider ?? 'Não informado' }}</div>
                    </div>
                    <div class="tariff-card-meta-item">
                        <div class="tariff-card-meta-label">Tipo</div>
                        <div class="tariff-card-meta-value">{{ $tariff->tariff_type ?? 'Não informado' }}</div>
                    </div>
                    <div class="tariff-card-meta-item">
                        <div class="tariff-card-meta-label">Status</div>
                        <div class="tariff-card-meta-value">
                            <span class="badge-status {{ $tariff->is_active ? 'badge-active' : 'badge-inactive' }}">
                                <i class="bi bi-{{ $tariff->is_active ? 'check-circle' : 'x-circle' }}"></i>
                                {{ $tariff->is_active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </div>
                    </div>
                    <div class="tariff-card-meta-item">
                        <div class="tariff-card-meta-label">Faixas</div>
                        <div class="tariff-card-meta-value">
                            @php
                                $brackets = 0;
                                if($tariff->bracket1_rate) $brackets++;
                                if($tariff->bracket2_rate) $brackets++;
                                if($tariff->bracket3_rate) $brackets++;
                            @endphp
                            {{ $brackets }} configurada{{ $brackets != 1 ? 's' : '' }}
                        </div>
                    </div>
                </div>

                <div class="tariff-card-actions">

                    <a href="{{ route('tariffs.edit', $tariff) }}" class="btn btn-primary btn-sm btn-modern flex-fill">
                        <i class="bi bi-pencil"></i>
                        Editar
                    </a>
                    <form action="{{ route('tariffs.destroy', $tariff) }}" method="POST" class="flex-fill">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-sm btn-modern w-100" 
                                onclick="return confirm('Tem certeza que deseja excluir esta tarifa?')">
                            <i class="bi bi-trash"></i>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Paginação -->
        @if(method_exists($tariffs, 'links'))
        <div class="d-flex justify-content-center mt-4 animate-fade-in" style="animation-delay: 0.6s;">
            {{ $tariffs->links() }}
        </div>
        @endif
    @else
        <!-- Estado vazio -->
        <div class="empty-state animate-fade-in" style="animation-delay: 0.2s;">
            <div class="empty-state-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <h3 class="empty-state-title">Nenhuma tarifa cadastrada</h3>
            <p class="empty-state-message">
                Cadastre tarifas de energia para calcular custos precisos de consumo em seus relatórios.
            </p>
            <div class="empty-state-action">
                <a href="{{ route('tariffs.create') }}" class="btn btn-success btn-modern">
                    <i class="bi bi-plus-circle"></i>
                    Cadastrar Primeira Tarifa
                </a>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmação melhorada para exclusão
    document.addEventListener('click', function(e) {
        if (e.target.closest('button[type="submit"]')?.textContent.includes('Excluir') ||
            e.target.closest('button[type="submit"]')?.querySelector('.bi-trash')) {
            e.preventDefault();
            
            const tariffName = e.target.closest('tr')?.querySelector('strong')?.textContent || 
                              e.target.closest('.tariff-card-mobile')?.querySelector('.tariff-card-title')?.textContent.trim();
            
            if (confirm(`Tem certeza que deseja excluir a tarifa "${tariffName}"?\n\nEsta ação não pode ser desfeita e pode afetar cálculos existentes.`)) {
                e.target.closest('form').submit();
            }
        }
    });

    // Feedback visual para ações
    document.addEventListener('click', function(e) {
        if (e.target.closest('a[href*="edit"]') || e.target.closest('a[href*="show"]')) {
            const btn = e.target.closest('a');
            const originalContent = btn.innerHTML;
            
            btn.style.opacity = '0.7';
            setTimeout(() => {
                btn.style.opacity = '1';
            }, 200);
        }
    });

    // Auto-refresh para mudanças de status (se necessário)
    const statusBadges = document.querySelectorAll('.badge-status');
    if (statusBadges.length > 0) {
        // Implementar lógica de refresh se necessário
        console.log(`${statusBadges.length} tarifas carregadas`);
    }

    // Inicializar tooltips se não for mobile
    if (window.innerWidth >= 768) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Animação das estatísticas
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach((stat, index) => {
        const finalValue = parseInt(stat.textContent);
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 20);
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            stat.textContent = currentValue;
        }, 50 + (index * 20));
    });
});
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
