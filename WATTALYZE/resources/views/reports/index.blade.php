@include('components.headerDash')
<script src="https://cdn.tailwindcss.com"></script>
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
        margin-left: 4vw;
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
        overflow: hidden;
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
    }

    .modern-card.success::before {
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
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

    .btn-outline-primary.btn-modern {
        background: transparent;
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
    }

    .btn-outline-primary.btn-modern:hover {
        background: var(--primary-blue);
        color: white;
    }

    .btn-success.btn-modern {
        background: linear-gradient(135deg, var(--primary-green), #2ecc71);
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
    .report-card-mobile {
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

    .report-card-mobile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--status-color), var(--status-color-dark));
    }

    .report-card-mobile.completed {
        --status-color: #27ae60;
        --status-color-dark: #229954;
    }

    .report-card-mobile.pending {
        --status-color: #f39c12;
        --status-color-dark: #e67e22;
    }

    .report-card-mobile.failed {
        --status-color: #e74c3c;
        --status-color-dark: #c0392b;
    }

    .report-card-mobile:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .report-card-body {
        padding: var(--spacing-md);
    }

    .report-card-title {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-xs);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .report-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-md);
    }

    .report-card-meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .report-card-meta-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .report-card-meta-value {
        font-size: 0.9rem;
        color: var(--primary-dark);
        font-weight: 500;
    }

    .report-card-actions {
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

    .badge-completed {
        --badge-color: #27ae60;
        --badge-color-dark: #229954;
    }

    .badge-pending {
        --badge-color: #f39c12;
        --badge-color-dark: #e67e22;
        color: var(--primary-dark);
    }

    .badge-failed {
        --badge-color: #e74c3c;
        --badge-color-dark: #c0392b;
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

    /* Success message card */
    .success-message {
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05));
        border-left: 4px solid var(--primary-green);
        color: #155724;
        padding: var(--spacing-md);
        border-radius: var(--border-radius-small);
        margin-bottom: var(--spacing-md);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .success-message i {
        color: var(--primary-green);
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Format badges */
    .format-badge {
        background: rgba(52, 152, 219, 0.1);
        color: var(--primary-blue);
        border: 1px solid rgba(52, 152, 219, 0.3);
        border-radius: 12px;
        padding: 4px 8px;
        font-size: 0.7rem;
        font-weight: 600;
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

        .report-card-actions {
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

        .report-card-mobile {
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
            max-width: 1100px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 10vw;
            max-width: 85vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 8vw;
            max-width: 87vw;
        }
    }

    /* Mobile específico */
    @media (max-width: 767.98px) {
        .table-modern-container {
            display: none !important;
        }

        .report-card-mobile {
            display: block !important;
        }

        .header-content {
            text-align: center;
        }

        .btn-modern {
            width: 100%;
            max-width: 280px;
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
            <h2 class="modern-title">
                <i class="bi bi-file-earmark-text"></i>
                Meus Relatórios
            </h2>
            <a href="{{ route('reports.generate') }}" class="btn btn-outline-primary btn-modern">
                <i class="bi bi-plus-circle"></i>
                <span>Criar Relatório</span>
            </a>
        </div>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="success-message animate-fade-in" style="animation-delay: 0.1s;">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($reports->isEmpty())
        <!-- Estado vazio -->
        <div class="empty-state animate-fade-in" style="animation-delay: 0.2s;">
            <div class="empty-state-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h3 class="empty-state-title">Nenhum relatório encontrado</h3>
            <p class="empty-state-message">
                Você ainda não gerou nenhum relatório. Comece criando seu primeiro relatório de consumo de energia.
            </p>
            <div class="empty-state-action">
                <a href="{{ route('reports.generate') }}" class="btn btn-outline-primary btn-modern">
                    <i class="bi bi-plus-circle"></i>
                    Criar Primeiro Relatório
                </a>
            </div>
        </div>
    @else
        <!-- Tabela Desktop -->
        <div class="table-modern-container animate-fade-in" style="animation-delay: 0.2s;">
            <div class="table-responsive">
                <table class="table table-modern align-middle">
                    <thead>
                        <tr>
                            <th><i class=""></i></th>
                            <th><i class="bi bi-tag me-2"></i>Nome</th>
                            <th><i class="bi bi-info-circle me-2"></i>Status</th>
                            <th><i class="bi bi-calendar-range me-2"></i>Período</th>
                            <th><i class="bi bi-file-type me-2"></i>Formato</th>
                            <th><i class="bi bi-download me-2"></i>Arquivo</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                    <strong>{{ $report->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="badge-status badge-{{ $report->status }}">
                                    <i class="bi bi-{{ $report->status === 'completed' ? 'check-circle' : ($report->status === 'pending' ? 'clock' : 'x-circle') }}"></i>
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">De: {{ $report->period_start->format('d/m/Y') }}</small>
                                    <small class="text-muted">Até: {{ $report->period_end->format('d/m/Y') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="format-badge">{{ strtoupper($report->format) }}</span>
                            </td>
                            <td>
                                @if($report->status === 'completed')
                                    <a href="{{ route('reports.download', $report) }}" class="btn btn-sm btn-success btn-modern">
                                        <i class="bi bi-download"></i>
                                        Baixar
                                    </a>
                                @else
                                    <span class="text-muted d-flex align-items-center">
                                        <i class="bi bi-dash-circle me-1"></i>
                                        Indisponível
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('reports.destroy', $report) }}" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este relatório?')"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-modern" title="Excluir relatório">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cards Mobile -->
        @foreach($reports as $index => $report)
        <div class="report-card-mobile {{ $report->status }} animate-fade-in" 
             style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
            <div class="report-card-body">
                <div class="report-card-title">
                    <i class="bi bi-file-earmark-text text-primary"></i>
                    {{ $report->name }}
                </div>
                
                <div class="report-card-meta">
                    <div class="report-card-meta-item">
                        <div class="report-card-meta-label">Status</div>
                        <div class="report-card-meta-value">
                            <span class="badge-status badge-{{ $report->status }}">
                                <i class="bi bi-{{ $report->status === 'completed' ? 'check-circle' : ($report->status === 'pending' ? 'clock' : 'x-circle') }}"></i>
                                {{ ucfirst($report->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="report-card-meta-item">
                        <div class="report-card-meta-label">Formato</div>
                        <div class="report-card-meta-value">
                            <span class="format-badge">{{ strtoupper($report->format) }}</span>
                        </div>
                    </div>
                    <div class="report-card-meta-item">
                        <div class="report-card-meta-label">Início</div>
                        <div class="report-card-meta-value">{{ $report->period_start->format('d/m/Y') }}</div>
                    </div>
                    <div class="report-card-meta-item">
                        <div class="report-card-meta-label">Fim</div>
                        <div class="report-card-meta-value">{{ $report->period_end->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="report-card-actions">
                    @if($report->status === 'completed')
                        <a href="{{ route('reports.download', $report) }}" class="btn btn-sm btn-success btn-modern flex-fill">
                            <i class="bi bi-download"></i>
                            Baixar
                        </a>
                    @else
                        <div class="btn btn-sm btn-secondary btn-modern flex-fill disabled">
                            <i class="bi bi-dash-circle"></i>
                            Indisponível
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('reports.destroy', $report) }}" class="flex-fill">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm btn-danger btn-modern w-100" 
                                onclick="return confirm('Tem certeza que deseja excluir este relatório?')">
                            <i class="bi bi-trash"></i>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Paginação -->
        @if(method_exists($reports, 'links'))
        <div class="d-flex justify-content-center mt-4 animate-fade-in" style="animation-delay: 0.5s;">
            {{ $reports->links() }}
        </div>
        @endif
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-atualização de status dos relatórios
    const pendingReports = document.querySelectorAll('.badge-pending');
    
    if (pendingReports.length > 0) {
        const refreshInterval = setInterval(() => {
            // Atualizar página a cada 30 segundos se houver relatórios pendentes
            window.location.reload();
        }, 30000);
        
        // Parar refresh quando não houver mais relatórios pendentes
        if (pendingReports.length === 0) {
            clearInterval(refreshInterval);
        }
    }

    // Confirmação melhorada para exclusão
    document.addEventListener('click', function(e) {
        if (e.target.closest('button[type="submit"]')?.textContent.includes('Excluir')) {
            e.preventDefault();
            
            const reportName = e.target.closest('tr')?.querySelector('strong')?.textContent || 
                              e.target.closest('.report-card-mobile')?.querySelector('.report-card-title')?.textContent.trim();
            
            if (confirm(`Tem certeza que deseja excluir o relatório "${reportName}"?\n\nEsta ação não pode ser desfeita.`)) {
                e.target.closest('form').submit();
            }
        }
    });

    // Feedback visual para downloads
    document.addEventListener('click', function(e) {
        if (e.target.closest('a[href*="download"]')) {
            const btn = e.target.closest('a');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="bi bi-arrow-down-circle spin"></i> Baixando...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 2000);
        }
    });

    // Inicializar tooltips se não for mobile
    if (window.innerWidth >= 768) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
