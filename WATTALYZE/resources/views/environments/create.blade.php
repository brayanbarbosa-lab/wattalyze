@include('components.headerDash')

<style>
    /* Variáveis CSS para consistência */
    :root {
        --primary-dark: #2c3e50;
        --primary-green: #27ae60;
        --primary-red: #e74c3c;
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
        max-width: 800px;
        margin: 0 auto;
        padding: var(--spacing-sm);
        min-height: 100vh;
    }

    /* Card do formulário moderno */
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
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
        background: linear-gradient(45deg, rgba(39, 174, 96, 0.03) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Título do formulário */
    .form-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-lg);
        position: relative;
        text-align: center;
        line-height: 1.2;
    }

    .form-title::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--primary-dark));
        border-radius: 2px;
    }

    /* Subtitle explicativo */
    .form-subtitle {
        text-align: center;
        color: var(--text-muted);
        font-size: 1.1rem;
        margin: -var(--spacing-md) 0 var(--spacing-xl) 0;
        font-weight: 400;
    }

    /* Labels modernos */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
        display: block;
        position: relative;
    }

    .form-label .text-danger {
        color: var(--primary-red) !important;
        font-weight: 700;
    }

    /* Inputs e selects modernos */
    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        padding: 12px 16px;
        font-size: 1rem;
        font-weight: 500;
        transition: var(--transition);
        background: white;
        min-height: 48px;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15);
        outline: none;
        background: white;
    }

    /* Placeholder styling */
    .form-control::placeholder {
        color: #adb5bd;
        font-style: italic;
        opacity: 1;
    }

    /* Estados de validação */
    .form-control.is-valid,
    .form-select.is-valid {
        border-color: var(--primary-green);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2327ae60' d='m2.3 6.73.94-.94 1.48 1.48L7.88 4.12l.94.94L5.66 8.22z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--primary-red);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e74c3c'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4M8.2 4.6l-2.4 2.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    /* Feedback de validação */
    .valid-feedback,
    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        padding-left: 8px;
    }

    .valid-feedback {
        color: var(--primary-green);
    }

    .invalid-feedback {
        color: var(--primary-red);
    }

    /* Textarea responsiva */
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Checkbox moderno */
    .form-check {
        padding: var(--spacing-md);
        background: rgba(248, 249, 250, 0.8);
        border-radius: var(--border-radius-small);
        border: 1px solid rgba(233, 236, 239, 0.5);
        margin-bottom: var(--spacing-md);
        transition: var(--transition);
    }

    .form-check:hover {
        background: rgba(39, 174, 96, 0.05);
        border-color: rgba(39, 174, 96, 0.2);
    }

    .form-check-input {
        width: 1.25em;
        height: 1.25em;
        margin-top: 0.125em;
        border: 2px solid #dee2e6;
        border-radius: 4px;
        transition: var(--transition);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15);
        border-color: var(--primary-green);
    }

    .form-check-input:checked {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }

    .form-check-label {
        font-weight: 500;
        color: var(--primary-dark);
        margin-left: 0.5rem;
        cursor: pointer;
    }

    /* Botões modernos */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #229954 100%);
        border: none;
        border-radius: var(--border-radius-small);
        color: white;
        padding: 14px 28px;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        will-change: transform;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        background: linear-gradient(135deg, #229954 0%, var(--primary-green) 100%);
        color: white;
    }

    .btn-secondary {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-small);
        color: var(--text-muted);
        padding: 12px 24px;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        will-change: transform;
    }

    .btn-secondary:hover {
        background: var(--bg-light);
        border-color: var(--text-muted);
        color: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* Actions container */
    .form-actions {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
        margin-top: var(--spacing-xl);
        padding-top: var(--spacing-lg);
        border-top: 2px solid #f8f9fa;
    }

    /* Grid responsivo para inputs relacionados */
    .form-grid {
        display: grid;
        gap: var(--spacing-md);
        grid-template-columns: 1fr;
    }

    /* Seções do formulário */
    .form-section {
        margin-bottom: var(--spacing-xl);
        position: relative;
    }

    .form-section:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: calc(-1 * var(--spacing-lg));
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #e9ecef 20%, #e9ecef 80%, transparent 100%);
    }

    /* Section titles */
    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: var(--spacing-md);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    /* Helper text */
    .form-text {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
        display: block;
    }

    /* Progress indicator */
    .form-progress {
        background: #f8f9fa;
        border-radius: 20px;
        height: 6px;
        margin-bottom: var(--spacing-lg);
        overflow: hidden;
    }

    .form-progress-bar {
        background: linear-gradient(90deg, var(--primary-green), #2ecc71);
        height: 100%;
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 20px;
    }

    /* Loading state */
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
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Animações */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
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

        .form-card {
            padding: var(--spacing-xl);
        }

        .form-actions {
            flex-direction: row;
            justify-content: flex-start;
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-grid .col-full {
            grid-column: 1 / -1;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .main-container {
            padding: var(--spacing-lg);
        }

        .form-title {
            text-align: left;
        }

        .form-title::after {
            left: 0;
            transform: none;
        }

        .form-subtitle {
            text-align: left;
        }

        .form-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-grid .col-2 {
            grid-column: span 2;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .main-container {
            max-width: 900px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .main-container {
            margin-left: 30vw;
            max-width: 60vw;
        }
    }

    /* Very large screens (1400px and up) */
    @media (min-width: 1400px) {
        .main-container {
            margin-left: 25vw;
            max-width: 50vw;
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

        .form-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .btn-secondary {
            display: none !important;
        }
    }
</style>

<div class="main-container">
    <div class="form-card animate-fade-in">
        <h1 class="form-title">Criar Novo Ambiente</h1>
        <p class="form-subtitle">Configure um novo ambiente para monitoramento de energia</p>

        {{-- Progress indicator --}}
        <div class="form-progress">
            <div class="form-progress-bar" id="progressBar"></div>
        </div>

        <form action="{{ route('environments.store') }}" method="POST" novalidate class="needs-validation" id="environmentForm">
            @csrf

            {{-- Seção: Informações Básicas --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Informações Básicas
                </h3>

                <div class="mb-4">
                    <label for="name" class="form-label">
                        Nome do Ambiente <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name') }}" 
                        required
                        autocomplete="name"
                        placeholder="Ex: Sala de Estar, Escritório Principal..."
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="valid-feedback">Nome disponível!</div>
                    @enderror
                    <small class="form-text">Escolha um nome descritivo e único para o ambiente</small>
                </div>

                <div class="mb-4">
                    <label for="type" class="form-label">
                        Tipo de Ambiente <span class="text-danger">*</span>
                    </label>
                    <select 
                        name="type" 
                        id="type" 
                        class="form-select @error('type') is-invalid @enderror" 
                        required
                    >
                        <option value="">-- Selecione o tipo de ambiente --</option>
                        <option value="residential" {{ old('type') == 'residential' ? 'selected' : '' }}>
                            🏠 Residencial
                        </option>
                        <option value="commercial" {{ old('type') == 'commercial' ? 'selected' : '' }}>
                            🏢 Comercial
                        </option>
                        <option value="industrial" {{ old('type') == 'industrial' ? 'selected' : '' }}>
                            🏭 Industrial
                        </option>
                        <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>
                            🏛️ Público
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="valid-feedback">Tipo selecionado!</div>
                    @enderror
                    <small class="form-text">Isso ajudará a definir configurações apropriadas</small>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-control @error('description') is-invalid @enderror" 
                        rows="4"
                        placeholder="Descreva as características do ambiente, localização, finalidade..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Informações adicionais sobre o ambiente (opcional)</small>
                </div>
            </div>

            {{-- Seção: Especificações Técnicas --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-tools"></i>
                    Especificações Técnicas
                </h3>

                <div class="form-grid">
                    <div class="mb-4">
                        <label for="size_sqm" class="form-label">Área (m²)</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            name="size_sqm" 
                            id="size_sqm" 
                            class="form-control @error('size_sqm') is-invalid @enderror" 
                            value="{{ old('size_sqm') }}"
                            placeholder="0.00"
                        >
                        @error('size_sqm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Área total em metros quadrados</small>
                    </div>

                    <div class="mb-4">
                        <label for="occupancy" class="form-label">Capacidade (pessoas)</label>
                        <input 
                            type="number" 
                            min="0" 
                            name="occupancy" 
                            id="occupancy" 
                            class="form-control @error('occupancy') is-invalid @enderror" 
                            value="{{ old('occupancy') }}"
                            placeholder="0"
                        >
                        @error('occupancy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Número máximo de ocupantes</small>
                    </div>

                    <div class="mb-4">
                        <label for="voltage_standard" class="form-label">Voltagem Padrão</label>
                        <input 
                            type="text" 
                            name="voltage_standard" 
                            id="voltage_standard" 
                            class="form-control @error('voltage_standard') is-invalid @enderror" 
                            value="{{ old('voltage_standard') }}"
                            placeholder="Ex: 220V, 110V, 380V"
                            list="voltage_options"
                        >
                        <datalist id="voltage_options">
                            <option value="110V">
                            <option value="220V">
                            <option value="380V">
                            <option value="440V">
                        </datalist>
                        @error('voltage_standard')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Voltagem da instalação elétrica</small>
                    </div>
                </div>
            </div>

            {{-- Seção: Informações de Energia --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-lightning-charge"></i>
                    Informações de Energia
                </h3>

                <div class="form-grid">
                    <div class="mb-4 col-2">
                        <label for="tariff_type" class="form-label">Tipo de Tarifa</label>
                        <input 
                            type="text" 
                            name="tariff_type" 
                            id="tariff_type" 
                            class="form-control @error('tariff_type') is-invalid @enderror" 
                            value="{{ old('tariff_type') }}"
                            placeholder="Ex: Residencial, Comercial B1, Industrial A4"
                            list="tariff_options"
                        >
                        <datalist id="tariff_options">
                            <option value="Residencial">
                            <option value="Comercial B1">
                            <option value="Comercial B3">
                            <option value="Industrial A4">
                            <option value="Industrial A3">
                        </datalist>
                        @error('tariff_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Classificação tarifária da concessionária</small>
                    </div>

                    <div class="mb-4">
                        <label for="energy_provider" class="form-label">Fornecedor de Energia</label>
                        <input 
                            type="text" 
                            name="energy_provider" 
                            id="energy_provider" 
                            class="form-control @error('energy_provider') is-invalid @enderror" 
                            value="{{ old('energy_provider') }}"
                            placeholder="Ex: Copel, Light, Cemig, Elektro"
                            list="provider_options"
                        >
                        <datalist id="provider_options">
                            <option value="Copel">
                            <option value="Light">
                            <option value="Cemig">
                            <option value="Elektro">
                            <option value="Enel">
                            <option value="EDP">
                        </datalist>
                        @error('energy_provider')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Companhia responsável pelo fornecimento</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="installation_date" class="form-label">Data de Instalação</label>
                    <input 
                        type="date" 
                        name="installation_date" 
                        id="installation_date" 
                        class="form-control @error('installation_date') is-invalid @enderror" 
                        value="{{ old('installation_date') }}"
                        max="{{ date('Y-m-d') }}"
                    >
                    @error('installation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Data quando o sistema de monitoramento foi instalado</small>
                </div>
            </div>

            {{-- Seção: Configurações --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-gear"></i>
                    Configurações Especiais
                </h3>

                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="is_default" 
                        name="is_default" 
                        value="1" 
                        {{ old('is_default') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="is_default">
                        <strong>Definir como ambiente padrão</strong>
                        <small class="d-block text-muted mt-1">
                            Este ambiente será usado como padrão para novos dispositivos e será destacado no dashboard
                        </small>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-plus-circle me-2"></i>
                    Criar Ambiente
                </button>
                <a href="{{ route('environments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('environmentForm');
        const progressBar = document.getElementById('progressBar');
        const inputs = form.querySelectorAll('input[required], select[required]');
        const allInputs = form.querySelectorAll('input, select, textarea');

        // Função para atualizar progresso
        function updateProgress() {
            const requiredInputs = Array.from(inputs);
            const completedInputs = requiredInputs.filter(input => {
                if (input.type === 'checkbox') {
                    return true; // Checkbox não é obrigatório para o progresso
                }
                return input.value.trim() !== '';
            });
            
            const progress = (completedInputs.length / requiredInputs.length) * 100;
            progressBar.style.width = progress + '%';
        }

        // Configuração de validação Bootstrap personalizada
        form.addEventListener('submit', event => {
            const submitBtn = document.getElementById('submitBtn');
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Focar no primeiro campo inválido
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    
                    // Scroll suave para o campo
                    firstInvalid.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }
            } else {
                // Mostrar loading no botão
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
                
                // Simular delay para UX
                setTimeout(() => {
                    form.submit();
                }, 500);
                
                event.preventDefault();
            }
            
            form.classList.add('was-validated');
        });

        // Validação em tempo real
        allInputs.forEach(input => {
            input.addEventListener('input', updateProgress);
            
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required')) {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });

        // Melhorar UX do checkbox
        const checkbox = document.getElementById('is_default');
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                const checkContainer = this.closest('.form-check');
                if (this.checked) {
                    checkContainer.style.borderColor = 'var(--primary-green)';
                    checkContainer.style.backgroundColor = 'rgba(39, 174, 96, 0.05)';
                } else {
                    checkContainer.style.borderColor = '';
                    checkContainer.style.backgroundColor = '';
                }
            });
        }

        // Auto-resize textarea
        const textarea = document.getElementById('description');
        if (textarea) {
            function autoResize() {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            }
            
            textarea.addEventListener('input', autoResize);
            autoResize(); // Initial call
        }

        // Sugestões inteligentes baseadas no tipo
        const typeSelect = document.getElementById('type');
        const tariffInput = document.getElementById('tariff_type');
        
        if (typeSelect && tariffInput) {
            typeSelect.addEventListener('change', function() {
                const suggestions = {
                    'residential': 'Residencial',
                    'commercial': 'Comercial B1',
                    'industrial': 'Industrial A4',
                    'public': 'Poder Público'
                };
                
                if (suggestions[this.value] && !tariffInput.value) {
                    tariffInput.value = suggestions[this.value];
                    tariffInput.dispatchEvent(new Event('input'));
                }
            });
        }

        // Formatação automática de campos numéricos
        const numericInputs = document.querySelectorAll('input[type="number"]');
        numericInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.step && this.step !== "1") {
                    // Campo decimal
                    this.value = this.value.replace(/[^0-9.,]/g, '');
                } else {
                    // Campo inteiro
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });
        });

        // Validação customizada para data
        const dateInput = document.getElementById('installation_date');
        if (dateInput) {
            dateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                
                if (selectedDate > today) {
                    this.setCustomValidity('A data não pode ser no futuro');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Shortcuts de teclado
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Enter para salvar
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('submitBtn').click();
            }
            
            // Escape para voltar
            if (e.key === 'Escape') {
                const backBtn = document.querySelector('.btn-secondary');
                if (backBtn && confirm('Deseja cancelar a criação do ambiente?')) {
                    window.location.href = backBtn.href;
                }
            }
        });

        // Inicializar progresso
        updateProgress();

        // Animação dos ícones das seções
        const sectionTitles = document.querySelectorAll('.section-title i');
        sectionTitles.forEach((icon, index) => {
            setTimeout(() => {
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1)';
                }, 200);
            }, index * 200);
        });
    });
</script>
