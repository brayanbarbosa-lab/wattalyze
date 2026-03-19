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

    /* Helper text */
    .form-text {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
        display: block;
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
        <h1 class="form-title">Editar Ambiente</h1>

        <form action="{{ route('environments.update', $environment->id) }}" method="POST" novalidate class="needs-validation">
            @csrf
            @method('PATCH')

            {{-- Seção: Informações Básicas --}}
            <div class="form-section">
                <div class="mb-4">
                    <label for="name" class="form-label">
                        Nome <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $environment->name) }}" 
                        required
                        autocomplete="name"
                        placeholder="Digite o nome do ambiente"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="valid-feedback">Nome válido!</div>
                    @enderror
                    <small class="form-text">Escolha um nome descritivo para o ambiente</small>
                </div>

                <div class="mb-4">
                    <label for="type" class="form-label">
                        Tipo <span class="text-danger">*</span>
                    </label>
                    <select 
                        name="type" 
                        id="type" 
                        class="form-select @error('type') is-invalid @enderror" 
                        required
                    >
                        <option value="">-- Selecione o tipo --</option>
                        <option value="residential" {{ old('type', $environment->type) == 'residential' ? 'selected' : '' }}>
                            🏠 Residencial
                        </option>
                        <option value="commercial" {{ old('type', $environment->type) == 'commercial' ? 'selected' : '' }}>
                            🏢 Comercial
                        </option>
                        <option value="industrial" {{ old('type', $environment->type) == 'industrial' ? 'selected' : '' }}>
                            🏭 Industrial
                        </option>
                        <option value="public" {{ old('type', $environment->type) == 'public' ? 'selected' : '' }}>
                            🏛️ Público
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="valid-feedback">Tipo selecionado!</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-control @error('description') is-invalid @enderror" 
                        rows="4"
                        placeholder="Descreva as características do ambiente..."
                    >{{ old('description', $environment->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Informações adicionais sobre o ambiente (opcional)</small>
                </div>
            </div>

            {{-- Seção: Especificações Técnicas --}}
            <div class="form-section">
                <div class="form-grid">
                    <div class="mb-4">
                        <label for="size_sqm" class="form-label">Tamanho (m²)</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            name="size_sqm" 
                            id="size_sqm" 
                            class="form-control @error('size_sqm') is-invalid @enderror" 
                            value="{{ old('size_sqm', $environment->size_sqm) }}"
                            placeholder="0.00"
                        >
                        @error('size_sqm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="occupancy" class="form-label">Ocupação (pessoas)</label>
                        <input 
                            type="number" 
                            min="0" 
                            name="occupancy" 
                            id="occupancy" 
                            class="form-control @error('occupancy') is-invalid @enderror" 
                            value="{{ old('occupancy', $environment->occupancy) }}"
                            placeholder="0"
                        >
                        @error('occupancy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="voltage_standard" class="form-label">Padrão de Voltagem</label>
                        <input 
                            type="text" 
                            name="voltage_standard" 
                            id="voltage_standard" 
                            class="form-control @error('voltage_standard') is-invalid @enderror" 
                            value="{{ old('voltage_standard', $environment->voltage_standard) }}"
                            placeholder="Ex: 220V, 110V"
                        >
                        @error('voltage_standard')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="mb-4 col-2">
                        <label for="tariff_type" class="form-label">Tipo de Tarifa</label>
                        <input 
                            type="text" 
                            name="tariff_type" 
                            id="tariff_type" 
                            class="form-control @error('tariff_type') is-invalid @enderror" 
                            value="{{ old('tariff_type', $environment->tariff_type) }}"
                            placeholder="Ex: Residencial, Comercial, Industrial"
                        >
                        @error('tariff_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="energy_provider" class="form-label">Fornecedor de Energia</label>
                        <input 
                            type="text" 
                            name="energy_provider" 
                            id="energy_provider" 
                            class="form-control @error('energy_provider') is-invalid @enderror" 
                            value="{{ old('energy_provider', $environment->energy_provider) }}"
                            placeholder="Ex: Copel, Light, Cemig"
                        >
                        @error('energy_provider')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="installation_date" class="form-label">Data de Instalação</label>
                    <input 
                        type="date" 
                        name="installation_date" 
                        id="installation_date" 
                        class="form-control @error('installation_date') is-invalid @enderror" 
                        value="{{ old('installation_date', optional($environment->installation_date)->format('Y-m-d')) }}"
                        max="{{ date('Y-m-d') }}"
                    >
                    @error('installation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Data quando o sistema foi instalado</small>
                </div>
            </div>

            {{-- Seção: Configurações --}}
            <div class="form-section">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="is_default" 
                        name="is_default" 
                        value="1" 
                        {{ old('is_default', $environment->is_default) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="is_default">
                        Definir como ambiente padrão
                        <small class="d-block text-muted mt-1">
                            Este ambiente será usado como padrão para novos dispositivos
                        </small>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-check-circle me-2"></i>
                    Salvar Alterações
                </button>
                <a href="{{ route('environments.show', $environment->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuração de validação Bootstrap personalizada
        const forms = document.querySelectorAll('.needs-validation');
        
        // Aplicar validação customizada
        Array.from(forms).forEach(form => {
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
                }
                
                form.classList.add('was-validated');
            }, false);
        });

        // Validação em tempo real
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
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
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.style.color = 'var(--primary-green)';
                } else {
                    label.style.color = '';
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

        // Formatação automática de campos numéricos
        const numericInputs = document.querySelectorAll('input[type="number"]');
        numericInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Remove caracteres não numéricos (exceto ponto e vírgula)
                if (this.step && this.step !== "1") {
                    // Campo decimal
                    this.value = this.value.replace(/[^0-9.,]/g, '');
                } else {
                    // Campo inteiro
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });
        });

        // Melhorar UX do date input
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

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Enter para salvar
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('submitBtn').click();
            }
            
            // Escape para cancelar
            if (e.key === 'Escape') {
                const cancelBtn = document.querySelector('.btn-secondary');
                if (cancelBtn && confirm('Deseja cancelar as alterações?')) {
                    window.location.href = cancelBtn.href;
                }
            }
        });
    });
</script>
