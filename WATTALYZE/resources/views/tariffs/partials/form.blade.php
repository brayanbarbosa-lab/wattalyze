<style>
    /* ===== VARIÁVEIS CSS PREMIUM ===== */
    :root {
        --primary-dark: #1a2332;
        --primary-green: #27ae60;
        --primary-green-light: #2ecc71;
        --primary-red: #e74c3c;
        --primary-blue: #3498db;
        --primary-purple: #9b59b6;
        --accent-orange: #e67e22;
        --bg-gradient-1: #f5f7fa;
        --bg-gradient-2: #e8eef2;
        --text-dark: #2c3e50;
        --text-muted: #7f8c8d;
        --border-color: #ecf0f1;
        --success: #27ae60;
        --error: #e74c3c;
        --warning: #f39c12;
        /* Spacing */
        --spacing-xs: 0.5rem;
        --spacing-sm: 1rem;
        --spacing-md: 1.5rem;
        --spacing-lg: 2rem;
        --spacing-xl: 3rem;
        --spacing-xxl: 4rem;
        /* Border Radius */
        --radius-xs: 4px;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        /* Shadows */
        --shadow-xs: 0 1px 3px rgba(0, 0, 0, 0.05);
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.15);
        --shadow-xl: 0 12px 48px rgba(0, 0, 0, 0.2);
        /* Transitions */
        --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-normal: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== RESET E BASE ===== */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        min-height: 100vh;
        overflow-y: auto;
    }

    /* ===== CONTAINER PRINCIPAL ===== */
    .main-container {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: var(--spacing-md);
        min-height: 100vh;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== CARD DO FORMULÁRIO ===== */
    .form-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.95) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(39, 174, 96, 0.02) 0%, rgba(52, 152, 219, 0.02) 100%);
        pointer-events: none;
        z-index: 1;
    }

    .form-card>* {
        position: relative;
        z-index: 2;
    }

    /* ===== HEADER DO FORMULÁRIO ===== */
    .form-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #34495e 100%);
        color: white;
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
        pointer-events: none;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .form-header-content {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
        position: relative;
        z-index: 2;
    }

    .form-header-icon {
        font-size: 3rem;
        opacity: 0.9;
        animation: float 3s ease-in-out infinite;
        flex-shrink: 0;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .form-header-text {
        flex: 1;
    }

    .form-title {
        font-size: clamp(1.5rem, 5vw, 2.2rem);
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-subtitle {
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        opacity: 0.85;
        margin: 0;
        font-weight: 500;
    }

    /* ===== PROGRESS BAR ===== */
    .form-progress {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        height: 6px;
        margin-bottom: var(--spacing-lg);
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-progress-bar {
        background: linear-gradient(90deg, var(--primary-green) 0%, var(--primary-green-light) 100%);
        height: 100%;
        width: 0%;
        transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(39, 174, 96, 0.3);
    }

    /* ===== LABELS ===== */
    .form-label {
        font-weight: 600;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        color: var(--text-dark);
        margin-bottom: 0.625rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        line-height: 1.4;
        text-transform: capitalize;
        letter-spacing: 0.3px;
    }

    .form-label .label-icon {
        color: var(--primary-green);
        font-size: 0.95rem;
        flex-shrink: 0;
        opacity: 0.8;
    }

    .form-label .text-danger {
        color: var(--primary-red) !important;
        font-weight: 700;
        font-size: 1.1em;
    }

    /* ===== INPUTS MODERNOS ===== */
    .form-control {
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 0.875rem 1rem;
        font-size: clamp(0.875rem, 2vw, 1rem);
        font-weight: 500;
        transition: var(--transition-normal);
        background: white;
        min-height: 48px;
        width: 100%;
        color: var(--text-dark);
    }

    .form-control::placeholder {
        color: var(--text-muted);
        opacity: 0.6;
    }

    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.12), 0 0 0 1px var(--primary-green);
        outline: none;
        background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(39, 174, 96, 0.02) 100%);
    }

    .form-control:hover:not(:focus) {
        border-color: rgba(39, 174, 96, 0.5);
    }

    .form-control.is-valid {
        border-color: var(--primary-green);
        background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(39, 174, 96, 0.03) 100%);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2327ae60' d='m2.3 6.73.94-.94 1.48 1.48L7.88 4.12l.94.94L5.66 8.22z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    .form-control.is-invalid {
        border-color: var(--primary-red);
        background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(231, 76, 60, 0.03) 100%);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e74c3c'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4M8.2 4.6l-2.4 2.4' stroke-width='1.5'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    /* ===== FEEDBACK MESSAGES ===== */
    .valid-feedback,
    .invalid-feedback {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: clamp(0.75rem, 1.8vw, 0.85rem);
        font-weight: 600;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .valid-feedback {
        color: var(--primary-green);
    }

    .valid-feedback::before {
        content: '✓';
        font-weight: 700;
    }

    .invalid-feedback {
        color: var(--primary-red);
    }

    .invalid-feedback::before {
        content: '✕';
        font-weight: 700;
    }

    /* ===== FORM TEXT ===== */
    .form-text {
        font-size: clamp(0.7rem, 1.8vw, 0.8rem);
        color: var(--text-muted);
        margin-top: 0.375rem;
        display: block;
        font-weight: 500;
    }

    /* ===== CHECKBOX MODERNO ===== */
    .form-check {
        padding: var(--spacing-md);
        background: linear-gradient(135deg, rgba(248, 249, 250, 0.8) 0%, rgba(240, 244, 248, 0.6) 100%);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        margin-bottom: var(--spacing-md);
        transition: var(--transition-normal);
        cursor: pointer;
    }

    .form-check:hover {
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.08) 0%, rgba(39, 174, 96, 0.04) 100%);
        border-color: rgba(39, 174, 96, 0.3);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.125rem;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        transition: var(--transition-fast);
        cursor: pointer;
        flex-shrink: 0;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.15);
        border-color: var(--primary-green);
    }

    .form-check-input:checked {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-light) 100%);
        border-color: var(--primary-green);
        box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
    }

    .form-check-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-left: 0.75rem;
        cursor: pointer;
    }

    /* ===== GRID RESPONSIVO ===== */
    .form-grid {
        display: grid;
        gap: var(--spacing-md);
        grid-template-columns: 1fr;
    }

    /* ===== SEÇÕES DO FORMULÁRIO ===== */
    .form-section {
        margin-bottom: var(--spacing-xxl);
        position: relative;
        animation: fadeIn 0.6s ease-out;
    }

    .form-section:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: calc(-1 * var(--spacing-lg));
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(233, 236, 239, 0.5) 20%, rgba(233, 236, 239, 0.5) 80%, transparent 100%);
    }

    /* ===== SECTION TITLES ===== */
    .section-title {
        font-size: clamp(1.15rem, 3vw, 1.4rem);
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: var(--spacing-md);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: var(--spacing-sm) 0;
        border-bottom: 3px solid transparent;
        border-image: linear-gradient(90deg, var(--primary-green), rgba(39, 174, 96, 0.3)) 1;
        position: relative;
    }

    .section-title i {
        color: var(--primary-green);
        font-size: 1.3rem;
        opacity: 0.9;
    }

    /* ===== BRACKET SECTIONS ===== */
    .bracket-section {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.05) 0%, rgba(41, 128, 185, 0.02) 100%);
        border: 2px solid rgba(52, 152, 219, 0.15);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        position: relative;
        transition: var(--transition-normal);
        overflow: hidden;
    }

    .bracket-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-blue), #5dade2);
        border-radius: 0 2px 2px 0;
    }

    .bracket-section::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(52, 152, 219, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .bracket-section:hover {
        border-color: rgba(52, 152, 219, 0.3);
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.08) 0%, rgba(41, 128, 185, 0.03) 100%);
        box-shadow: var(--shadow-sm);
        transform: translateY(-2px);
    }

    .bracket-title {
        font-size: clamp(1rem, 2.5vw, 1.15rem);
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: var(--spacing-md);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 2;
    }

    .bracket-title i {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    /* ===== CALCULATOR PREVIEW ===== */
    .calculator-preview {
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1) 0%, rgba(46, 204, 113, 0.05) 100%);
        border: 2px solid rgba(39, 174, 96, 0.25);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin-top: var(--spacing-lg);
        display: none;
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.1);
    }

    .calculator-preview.show {
        display: block;
        animation: slideInUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .calculator-title {
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: var(--spacing-sm);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.05rem;
    }

    .calculator-content {
        font-size: 0.95rem;
        color: var(--text-dark);
        line-height: 1.6;
    }

    .calculator-content ul {
        list-style: none;
        padding: 0;
        margin: var(--spacing-sm) 0;
    }

    .calculator-content li {
        padding: 0.5rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: var(--spacing-md);
        position: relative;
    }

    .calculator-content li::before {
        content: '';
        position: absolute;
        left: 0;
        width: 3px;
        height: 3px;
        background: var(--primary-green);
        border-radius: 50%;
        opacity: 0.8;
    }

    /* ===== ALERT DE ERROS ===== */
    .alert-danger {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(192, 57, 43, 0.04) 100%);
        border: 2px solid rgba(231, 76, 60, 0.25);
        border-left: 4px solid var(--primary-red);
        border-radius: var(--radius-md);
        color: #721c24;
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        box-shadow: 0 2px 8px rgba(231, 76, 60, 0.1);
    }

    .alert-danger ul {
        margin: var(--spacing-sm) 0 0 0;
        padding-left: var(--spacing-lg);
        list-style: circle;
    }

    .alert-danger li {
        margin-bottom: 0.375rem;
        font-weight: 600;
    }

    /* ===== BOTÕES MODERNOS ===== */
    .btn {
        border: none;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: clamp(0.85rem, 2vw, 1rem);
        padding: 0.875rem 1.75rem;
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        text-decoration: none;
        transition: var(--transition-normal);
        will-change: transform, box-shadow;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        font-size: 0.875rem;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #229954 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
        background: linear-gradient(135deg, #229954 0%, var(--primary-green) 100%);
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:active {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
    }

    .btn-secondary {
        background: white;
        border: 2px solid var(--border-color);
        color: var(--text-muted);
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
    }

    .btn-secondary:hover {
        background: var(--bg-gradient-1);
        border-color: var(--primary-green);
        color: var(--text-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary:active {
        transform: translateY(0);
        box-shadow: var(--shadow-sm);
    }

    /* ===== FORM ACTIONS ===== */
    .form-actions {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
        margin-top: var(--spacing-xxl);
        padding-top: var(--spacing-lg);
        border-top: 2px solid rgba(233, 236, 239, 0.5);
    }

    /* ===== LOADING STATE ===== */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* ===== MEDIA QUERIES ===== */
    @media (min-width: 576px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        .form-card {
            padding: var(--spacing-xl);
        }

        .form-actions {
            flex-direction: row;
            justify-content: flex-start;
            gap: var(--spacing-lg);
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-grid.three-cols {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-grid .col-full {
            grid-column: 1 / -1;
        }

        .form-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .form-header-content {
            justify-content: space-between;
        }
    }

    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-xl);
        }

        .bracket-section {
            padding: var(--spacing-lg);
        }

        .form-grid.three-cols {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 992px) {
        .main-container {
            max-width: 1200px;
        }
    }

    @media (min-width: 1200px) {
        .main-container {
            margin-left: 25vw;
            max-width: 70vw;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    @media print {
        .main-container {
            margin: 0 !important;
            max-width: 100% !important;
        }

        .form-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .btn-secondary,
        .form-actions {
            display: none !important;
        }
    }
</style>
<div class="main-container">
    <div class="form-card"> {{-- Header do formulário --}}
        <div class="form-header">
            <div class="form-header-content">
                <div class="form-header-icon"> <i class="bi bi-receipt"></i> </div>
                <div class="form-header-text">
                    <h2 class="form-title">{{ isset($tariff) ? 'Editar' : 'Cadastrar' }} Tarifa</h2>
                    <p class="form-subtitle">Configure as tarifas de energia elétrica com faixas de consumo progressivas</p>
                </div>
            </div>
        </div>
        
        {{-- Progress indicator --}}
        <div class="form-progress">
            <div class="form-progress-bar" id="progressBar"></div>
        </div>

        {{-- Alert de erros --}}
        @if ($errors->any())
        <div class="alert alert-danger" style="animation-delay: 0.1s;">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-2 mt-1 flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <strong>Por favor, corrija os seguintes erros:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ isset($tariff) ? route('tariffs.update', $tariff) : route('tariffs.store') }}"
            novalidate class="needs-validation" id="tariffForm">
            @csrf
            @if(isset($tariff))
            @method('PUT')
            @endif

            {{-- Seção: Informações Básicas --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Informações Básicas
                </h3>

                <div class="form-grid">
                    <div class="mb-4 col-full">
                        <label for="name" class="form-label">
                            <i class="label-icon bi bi-tag"></i>
                            Nome da Tarifa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $tariff->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            required autocomplete="name"
                            placeholder="Ex: Tarifa Residencial B1 - Copel PR">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="valid-feedback">Nome válido!</div>
                        @enderror
                        <small class="form-text">Nome descritivo para identificar a tarifa no sistema</small>
                    </div>

                    <div class="mb-4">
                        <label for="provider" class="form-label">
                            <i class="label-icon bi bi-building"></i>
                            Provedor / Distribuidora
                        </label>
                        <input type="text" name="provider" id="provider"
                            value="{{ old('provider', $tariff->provider ?? '') }}"
                            class="form-control @error('provider') is-invalid @enderror"
                            placeholder="Ex: Copel, Light, Cemig, Equatorial">
                        @error('provider')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Companhia de energia elétrica distribuidora</small>
                    </div>

                    <div class="mb-4">
                        <label for="region" class="form-label">
                            <i class="label-icon bi bi-geo-alt"></i>
                            Região / Estado
                        </label>
                        <input type="text" name="region" id="region"
                            value="{{ old('region', $tariff->region ?? '') }}"
                            class="form-control @error('region') is-invalid @enderror"
                            placeholder="Ex: Paraná (PR), São Paulo (SP)">
                        @error('region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Estado ou região de aplicação da tarifa</small>
                    </div>

                    <div class="mb-4">
                        <label for="tariff_type" class="form-label">
                            <i class="label-icon bi bi-list-ul"></i>
                            Tipo de Tarifa
                        </label>
                        <input type="text" name="tariff_type" id="tariff_type"
                            value="{{ old('tariff_type', $tariff->tariff_type ?? '') }}"
                            class="form-control @error('tariff_type') is-invalid @enderror"
                            placeholder="Ex: Residencial, Comercial, Industrial">
                        @error('tariff_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Classificação ou segmento da tarifa</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Faixas de Consumo --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-bar-chart-steps"></i>
                    Faixas de Consumo Progressivas
                </h3>


                <div class="bracket-section">
                    <div class="bracket-title">
                        <i class="bi bi-1-circle"></i>
                        Faixa 1 — Consumo Básico
                    </div>
                    <div class="form-grid three-cols">
                        <div class="mb-4">
                            <label for="bracket1_min" class="form-label">
                                <i class="label-icon bi bi-arrow-down-circle"></i>
                                Mínimo (kWh) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" name="bracket1_min" id="bracket1_min"
                                value="{{ old('bracket1_min', $tariff->bracket1_min ?? '') }}"
                                class="form-control @error('bracket1_min') is-invalid @enderror"
                                required placeholder="0">
                            @error('bracket1_min')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="valid-feedback">Valor válido!</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bracket1_max" class="form-label">
                                <i class="label-icon bi bi-arrow-up-circle"></i>
                                Máximo (kWh)
                            </label>
                            <input type="number" step="0.01" name="bracket1_max" id="bracket1_max"
                                value="{{ old('bracket1_max', $tariff->bracket1_max ?? '') }}"
                                class="form-control @error('bracket1_max') is-invalid @enderror"
                                placeholder="100">
                            @error('bracket1_max')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Deixe em branco para ilimitado</small>
                        </div>

                        <div class="mb-4">
                            <label for="bracket1_rate" class="form-label">
                                <i class="label-icon bi bi-currency-dollar"></i>
                                Valor por kWh (R$) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.0001" name="bracket1_rate" id="bracket1_rate"
                                value="{{ old('bracket1_rate', $tariff->bracket1_rate ?? '') }}"
                                class="form-control @error('bracket1_rate') is-invalid @enderror"
                                required placeholder="0,00">
                            @error('bracket1_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="valid-feedback">Valor válido!</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="bracket-section">
                    <div class="bracket-title">
                        <i class="bi bi-2-circle"></i>
                        Faixa 2 — Consumo Intermediário
                    </div>
                    <div class="form-grid three-cols">
                        <div class="mb-4">
                            <label for="bracket2_min" class="form-label">
                                <i class="label-icon bi bi-arrow-down-circle"></i>
                                Mínimo (kWh)
                            </label>
                            <input type="number" step="0.01" name="bracket2_min" id="bracket2_min"
                                value="{{ old('bracket2_min', $tariff->bracket2_min ?? '') }}"
                                class="form-control @error('bracket2_min') is-invalid @enderror"
                                placeholder="101">
                            @error('bracket2_min')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bracket2_max" class="form-label">
                                <i class="label-icon bi bi-arrow-up-circle"></i>
                                Máximo (kWh)
                            </label>
                            <input type="number" step="0.01" name="bracket2_max" id="bracket2_max"
                                value="{{ old('bracket2_max', $tariff->bracket2_max ?? '') }}"
                                class="form-control @error('bracket2_max') is-invalid @enderror"
                                placeholder="300">
                            @error('bracket2_max')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bracket2_rate" class="form-label">
                                <i class="label-icon bi bi-currency-dollar"></i>
                                Valor por kWh (R$)
                            </label>
                            <input type="number" step="0.0001" name="bracket2_rate" id="bracket2_rate"
                                value="{{ old('bracket2_rate', $tariff->bracket2_rate ?? '') }}"
                                class="form-control @error('bracket2_rate') is-invalid @enderror"
                                placeholder="0,00">
                            @error('bracket2_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="bracket-section">
                    <div class="bracket-title">
                        <i class="bi bi-3-circle"></i>
                        Faixa 3 — Consumo Alto
                    </div>
                    <div class="form-grid three-cols">
                        <div class="mb-4">
                            <label for="bracket3_min" class="form-label">
                                <i class="label-icon bi bi-arrow-down-circle"></i>
                                Mínimo (kWh)
                            </label>
                            <input type="number" step="0.01" name="bracket3_min" id="bracket3_min"
                                value="{{ old('bracket3_min', $tariff->bracket3_min ?? '') }}"
                                class="form-control @error('bracket3_min') is-invalid @enderror"
                                placeholder="301">
                            @error('bracket3_min')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bracket3_max" class="form-label">
                                <i class="label-icon bi bi-arrow-up-circle"></i>
                                Máximo (kWh)
                            </label>
                            <input type="number" step="0.01" name="bracket3_max" id="bracket3_max"
                                value="{{ old('bracket3_max', $tariff->bracket3_max ?? '') }}"
                                class="form-control @error('bracket3_max') is-invalid @enderror"
                                placeholder="Ilimitado">
                            @error('bracket3_max')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bracket3_rate" class="form-label">
                                <i class="label-icon bi bi-currency-dollar"></i>
                                Valor por kWh (R$)
                            </label>
                            <input type="number" step="0.0001" name="bracket3_rate" id="bracket3_rate"
                                value="{{ old('bracket3_rate', $tariff->bracket3_rate ?? '') }}"
                                class="form-control @error('bracket3_rate') is-invalid @enderror"
                                placeholder="0,00">
                            @error('bracket3_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Seção: Configurações Adicionais --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-gear"></i>
                    Configurações Adicionais
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="tax_rate" class="form-label">
                            <i class="label-icon bi bi-percent"></i>
                            Taxa de Impostos (%)
                        </label>
                        <input type="number" step="0.0001" name="tax_rate" id="tax_rate"
                            value="{{ old('tax_rate', $tariff->tax_rate ?? '') }}"
                            class="form-control @error('tax_rate') is-invalid @enderror"
                            placeholder="0,00">
                        @error('tax_rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Impostos e taxas adicionais aplicadas à tarifa</small>
                    </div>

                    <div class="mb-4">
                        <label for="valid_from" class="form-label">
                            <i class="label-icon bi bi-calendar-event"></i>
                            Válido de
                        </label>
                        <input type="date" name="valid_from" id="valid_from"
                            value="{{ old('valid_from', isset($tariff->valid_from) ? $tariff->valid_from->format('Y-m-d') : '') }}"
                            class="form-control @error('valid_from') is-invalid @enderror">
                        @error('valid_from')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="valid_until" class="form-label">
                            <i class="label-icon bi bi-calendar-check"></i>
                            Válido até
                        </label>
                        <input type="date" name="valid_until" id="valid_until"
                            value="{{ old('valid_until', isset($tariff->valid_until) ? $tariff->valid_until->format('Y-m-d') : '') }}"
                            class="form-control @error('valid_until') is-invalid @enderror">
                        @error('valid_until')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Deixe em branco para validade indefinida</small>
                    </div>
                </div>

                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="form-check-input" {{ old('is_active', $tariff->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">
                        <strong>Tarifa Ativa</strong>
                        <small class="d-block text-muted mt-1">
                            Marque para disponibilizar esta tarifa para uso no sistema de monitoramento
                        </small>
                    </label>
                </div>
            </div>

            {{-- Preview da calculadora --}}
            <div class="calculator-preview" id="calculatorPreview">
                <div class="calculator-title">
                    <i class="bi bi-calculator"></i>
                    Simulação de Cálculo (250 kWh)
                </div>
                <div class="calculator-content" id="calculatorContent">

                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-save"></i>
                    <span>{{ isset($tariff) ? 'Atualizar' : 'Cadastrar' }} Tarifa</span>
                </button>
                <a href="{{ route('tariffs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    <span>Cancelar</span>
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"></script>
<script>
    class ResponsiveTariffForm {
        constructor() {
            this.form = document.getElementById('tariffForm');
            this.progressBar = document.getElementById('progressBar');
            this.requiredFields = ['name', 'bracket1_min', 'bracket1_rate'];
            this.calculatorPreview = document.getElementById('calculatorPreview');
            this.calculatorContent = document.getElementById('calculatorContent');
            this.init();
        }
        init() {
            this.setupEventListeners();
            this.setupValidation();
            this.updateProgress();
            this.setupDateValidation();
            this.generateCalculatorPreview();
        }
        setupEventListeners() {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            this.form.querySelectorAll('input').forEach(field => {
                field.addEventListener('input', () => {
                    this.validateField(field);
                    this.updateProgress();
                    this.generateCalculatorPreview();
                });
                field.addEventListener('change', () => {
                    this.validateField(field);
                    this.updateProgress();
                    this.generateCalculatorPreview();
                });
                field.addEventListener('blur', () => this.validateField(field));
            });
            this.setupBracketAutoFill();
            const checkbox = document.getElementById('is_active');
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    const checkContainer = this.closest('.form-check');
                    if (this.checked) {
                        checkContainer.style.borderColor = 'var(--primary-green)';
                        checkContainer.style.backgroundColor = 'rgba(39, 174, 96, 0.1)';
                    } else {
                        checkContainer.style.borderColor = '';
                        checkContainer.style.backgroundColor = '';
                    }
                });
            }
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    e.preventDefault();
                    this.form.submit();
                }
            });
        }
        setupBracketAutoFill() {
            const bracket1Max = document.getElementById('bracket1_max');
            const bracket2Min = document.getElementById('bracket2_min');
            const bracket2Max = document.getElementById('bracket2_max');
            const bracket3Min = document.getElementById('bracket3_min');
            bracket1Max.addEventListener('input', () => {
                if (bracket1Max.value && !bracket2Min.value) {
                    bracket2Min.value = (parseFloat(bracket1Max.value) + 0.01).toFixed(2);
                    this.validateField(bracket2Min);
                }
            });
            bracket2Max.addEventListener('input', () => {
                if (bracket2Max.value && !bracket3Min.value) {
                    bracket3Min.value = (parseFloat(bracket2Max.value) + 0.01).toFixed(2);
                    this.validateField(bracket3Min);
                }
            });
        }
        setupValidation() {
            const numericFields = this.form.querySelectorAll('input[type="number"]');
            numericFields.forEach(field => {
                field.addEventListener('input', () => {
                    if ((field.name.includes('min') || field.name.includes('max') || field.name.includes('rate')) && parseFloat(field.value) < 0) {
                        field.value = '';
                    }
                });
            });
        }
        setupDateValidation() {
            const validFrom = this.form.querySelector('input[name="valid_from"]');
            const validUntil = this.form.querySelector('input[name="valid_until"]');
            validFrom.addEventListener('change', () => {
                if (validFrom.value) {
                    validUntil.min = validFrom.value;
                }
                this.validateDateRange();
            });
            validUntil.addEventListener('change', () => {
                if (validUntil.value) {
                    validFrom.max = validUntil.value;
                }
                this.validateDateRange();
            });
        }
        validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let message = '';
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                message = 'Este campo é obrigatório';
            }
            if (field.type === 'number' && value) {
                const numValue = parseFloat(value);
                if (isNaN(numValue) || numValue < 0) {
                    isValid = false;
                    message = 'Deve ser um número positivo';
                }
            }
            if (field.name === 'name' && value && value.length < 3) {
                isValid = false;
                message = 'Nome deve ter pelo menos 3 caracteres';
            }
            if (field.name.includes('bracket') && field.name.includes('max')) {
                const bracketNum = field.name.match(/\d+/);
                const minField = document.getElementById(`bracket${bracketNum}_min`);
                if (value && minField.value && parseFloat(value) <= parseFloat(minField.value)) {
                    isValid = false;
                    message = 'Máximo deve ser maior que o mínimo';
                }
            }
            field.classList.toggle('is-invalid', !isValid);
            field.classList.toggle('is-valid', isValid && value);
            const feedback = field.parentNode.querySelector('.invalid-feedback');
            if (feedback && message) {
                feedback.textContent = message;
            }
            return isValid;
        }
        validateDateRange() {
            const validFrom = this.form.querySelector('input[name="valid_from"]');
            const validUntil = this.form.querySelector('input[name="valid_until"]');
            if (validFrom.value && validUntil.value) {
                const from = new Date(validFrom.value);
                const until = new Date(validUntil.value);
                if (from >= until) {
                    validUntil.setCustomValidity('Data final deve ser posterior à data inicial');
                    validUntil.classList.add('is-invalid');
                    validUntil.classList.remove('is-valid');
                    return false;
                } else {
                    validUntil.setCustomValidity('');
                    validUntil.classList.remove('is-invalid');
                    if (validUntil.value) {
                        validUntil.classList.add('is-valid');
                    }
                    return true;
                }
            }
            return true;
        }
        updateProgress() {
            const requiredInputs = this.requiredFields.map(fieldName => this.form.querySelector(`[name="${fieldName}"]`)).filter(field => field !== null);
            const completedInputs = requiredInputs.filter(input => {
                return input.value.trim() !== '';
            });
            const progress = (completedInputs.length / requiredInputs.length) * 100;
            this.progressBar.style.width = progress + '%';
        }
        generateCalculatorPreview() {
            const formData = new FormData(this.form);
            const data = Object.fromEntries(formData);
            if (!data.bracket1_min || !data.bracket1_rate) {
                this.calculatorPreview.classList.remove('show');
                return;
            }
            const consumption = 250;
            let cost = 0;
            let breakdown = [];
            let remainingConsumption = consumption;
            if (data.bracket1_min && data.bracket1_rate) {
                const bracket1Max = data.bracket1_max || Infinity;
                const bracket1Usage = Math.min(remainingConsumption, bracket1Max - parseFloat(data.bracket1_min) + 1);
                if (bracket1Usage > 0) {
                    const bracket1Cost = bracket1Usage * parseFloat(data.bracket1_rate);
                    cost += bracket1Cost;
                    breakdown.push(`Faixa 1: ${bracket1Usage.toFixed(1)} kWh × R$ ${parseFloat(data.bracket1_rate).toFixed(4)} = R$ ${bracket1Cost.toFixed(2)}`);
                    remainingConsumption -= bracket1Usage;
                }
            }
            if (remainingConsumption > 0 && data.bracket2_min && data.bracket2_rate) {
                const bracket2Max = data.bracket2_max || Infinity;
                const bracket2Usage = Math.min(remainingConsumption, bracket2Max - parseFloat(data.bracket2_min) + 1);
                if (bracket2Usage > 0) {
                    const bracket2Cost = bracket2Usage * parseFloat(data.bracket2_rate);
                    cost += bracket2Cost;
                    breakdown.push(`Faixa 2: ${bracket2Usage.toFixed(1)} kWh × R$ ${parseFloat(data.bracket2_rate).toFixed(4)} = R$ ${bracket2Cost.toFixed(2)}`);
                    remainingConsumption -= bracket2Usage;
                }
            }
            if (remainingConsumption > 0 && data.bracket3_min && data.bracket3_rate) {
                const bracket3Cost = remainingConsumption * parseFloat(data.bracket3_rate);
                cost += bracket3Cost;
                breakdown.push(`Faixa 3: ${remainingConsumption.toFixed(1)} kWh × R$ ${parseFloat(data.bracket3_rate).toFixed(4)} = R$ ${bracket3Cost.toFixed(2)}`);
            }
            if (data.tax_rate) {
                const tax = cost * (parseFloat(data.tax_rate) / 100);
                cost += tax;
                breakdown.push(`Impostos (${parseFloat(data.tax_rate).toFixed(2)}%): R$ ${tax.toFixed(2)}`);
            }
            let previewHtml = ` <div style="display: grid; grid-template-columns: 1fr; gap: 0.75rem;"> <div> <strong>Consumo Simulado:</strong> ${consumption} kWh </div> <div> <strong>Detalhamento:</strong> <ul style="list-style: none; padding-left: 1rem; margin: 0.5rem 0;"> ${breakdown.map(item => `<li style="position: relative; padding-left: 0.75rem; margin-bottom: 0.375rem;"> <span style="position: absolute; left: 0; width: 3px; height: 3px; background: var(--primary-green); border-radius: 50%; top: 50%; transform: translateY(-50%);"></span> ${item}</li>`).join('')} </ul> </div> <div style="border-top: 2px solid rgba(39, 174, 96, 0.25); padding-top: 0.75rem; margin-top: 0.75rem;"> <strong>Total a Pagar:</strong> <span style="color: var(--primary-green); font-weight: 700; font-size: 1.1em;">R$ ${cost.toFixed(2)}</span> </div> </div> `;
            this.calculatorContent.innerHTML = previewHtml;
            this.calculatorPreview.classList.add('show');
        }
        handleSubmit(e) {
            let isFormValid = true;
            this.form.querySelectorAll('input[required]').forEach(field => {
                if (!this.validateField(field)) {
                    isFormValid = false;
                }
            });
            if (!this.validateDateRange()) {
                isFormValid = false;
            }
            if (!isFormValid) {
                e.preventDefault();
                const firstError = this.form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    setTimeout(() => firstError.focus(), 500);
                }
                return;
            }
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        new ResponsiveTariffForm();
    });
</script>