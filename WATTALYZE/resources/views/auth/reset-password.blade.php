<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Sistema de Monitoramento Energético</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
            position: relative;

        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(39, 174, 96, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(44, 62, 80, 0.2) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(1deg);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-glass:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: #27ae60;
            box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -12px rgba(39, 174, 96, 0.4);
        }

        .feature-icon {
            background: linear-gradient(135deg, #2c3e50, #27ae60);
            color: white;
            border-radius: 12px;
            padding: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s infinite;
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float-elements 8s ease-in-out infinite;
        }

        .floating-elements::before {
            width: 80px;
            height: 80px;
            top: 15%;
            left: 15%;
            animation-delay: 0s;
        }

        .floating-elements::after {
            width: 50px;
            height: 50px;
            top: 65%;
            right: 15%;
            animation-delay: 4s;
        }

        @keyframes float-elements {

            0%,
            100% {
                transform: translateY(0px) scale(1);
                opacity: 0.7;
            }

            50% {
                transform: translateY(-30px) scale(1.1);
                opacity: 0.3;
            }
        }

        .link-green {
            color: #27ae60;
        }

        .link-green:hover {
            color: #219a52;
        }

        .logo-gradient {
            background: linear-gradient(135deg, #27ae60, #2c3e50);
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.1);
            border-color: #e74c3c;
            color: #721c24;
        }

        .slide-in {
            animation: slideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .password-strength {
            transition: all 0.3s ease;
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
        }

        .weak {
            background: #e74c3c;
        }

        .medium {
            background: #f39c12;
        }

        .strong {
            background: #27ae60;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    <div class="floating-elements"></div>

    <div class="max-w-md w-full space-y-6 relative z-10">
        <!-- Header com animação -->
        <a href="{{ route('welcome') }}">
            <div class="text-center">
                <div class="relative inline-block">
                    <div class="pulse-ring absolute inset-0 bg-white rounded-full opacity-20"></div>
                    <div class="logo-gradient mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4 animate-bounce-slow">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        <h2 class="text-4xl font-bold text-white mb-2">Wattalyze</h2>
        <p class="text-xl text-white/90 mb-1">Redefinir Senha</p>
        <p class="text-sm text-white/70">
            Digite sua nova senha para completar o processo de recuperação
        </p>

        <!-- Mensagens de Status -->
        <div id="alerts-container">
            @if ($errors->any())
            <div class="glass-card alert-error border rounded-2xl p-4 mb-4 slide-in">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="font-medium mb-2">Erro ao redefinir senha</h4>
                        <ul class="text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Formulário -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6 glass-card rounded-2xl p-8">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="group">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('E-Mail') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <div class="feature-icon w-5 h-5">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                    </div>
                    <input type="email"
                        name="email"
                        id="email"
                        class="input-glass w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none @error('email') border-red-500 @enderror"
                        placeholder="Digite seu email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email">
                </div>
            </div>

            <!-- Senha -->
            <div class="group">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('Nova Senha') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <div class="feature-icon w-5 h-5">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <input type="password"
                        name="password"
                        id="password"
                        class="input-glass w-full pl-12 pr-12 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none @error('password') border-red-500 @enderror"
                        placeholder="Digite sua nova senha"
                        required
                        autocomplete="new-password">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                        <svg class="h-5 w-5 text-gray-400" id="eye-icon-password" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <div class="password-strength mt-2" id="password-strength"></div>
                <div class="text-xs text-gray-500 mt-1" id="password-feedback"></div>
            </div>

            <!-- Confirmar Senha -->
            <div class="group">
                <label for="password-confirm" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('Confirmar Nova Senha') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <div class="feature-icon w-5 h-5">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <input type="password"
                        name="password_confirmation"
                        id="password-confirm"
                        class="input-glass w-full pl-12 pr-12 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none"
                        placeholder="Confirme sua nova senha"
                        required
                        autocomplete="new-password">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password-confirm')">
                        <svg class="h-5 w-5 text-gray-400" id="eye-icon-password-confirm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <div class="text-xs text-gray-500 mt-1" id="password-match-feedback"></div>
            </div>

            <!-- Botão de Submit -->
            <button type="submit"
                class="btn-primary w-full flex justify-center items-center gap-3 text-white font-semibold py-4 px-6 rounded-xl relative">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ __('Redefinir Senha') }}</span>
            </button>

            <!-- Link para Login -->
            <div class="text-center">
                <span class="text-sm text-gray-600">Lembrou da senha?</span>
                <a href="{{ route('login') }}" class="link-green font-semibold hover:underline transition-colors duration-200 ml-1">
                    Fazer login
                </a>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center text-sm text-white/70">
            <p>&copy; 2025 Wattalyze. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon-' + fieldId);

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength');
            const feedback = document.getElementById('password-feedback');

            let score = 0;
            let feedbackText = '';

            if (password.length >= 8) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;

            strengthBar.style.opacity = password.length > 0 ? '1' : '0';

            if (score < 3) {
                strengthBar.className = 'password-strength weak';
                feedbackText = 'Senha fraca - Use pelo menos 8 caracteres com letras e números';
            } else if (score < 5) {
                strengthBar.className = 'password-strength medium';
                feedbackText = 'Senha média - Adicione caracteres especiais para maior segurança';
            } else {
                strengthBar.className = 'password-strength strong';
                feedbackText = 'Senha forte - Perfeita!';
            }

            feedback.textContent = password.length > 0 ? feedbackText : '';
        });

        // Password confirmation check
        document.getElementById('password-confirm').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            const feedback = document.getElementById('password-match-feedback');

            if (confirmation.length > 0) {
                if (password === confirmation) {
                    feedback.textContent = '✓ Senhas coincidem';
                    feedback.style.color = '#27ae60';
                } else {
                    feedback.textContent = '✗ Senhas não coincidem';
                    feedback.style.color = '#e74c3c';
                }
            } else {
                feedback.textContent = '';
            }
        });

        // Animação de entrada dos elementos
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.glass-card');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 150 + 200);
            });
        });

        // Validação visual em tempo real
        document.getElementById('email').addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && emailRegex.test(this.value)) {
                this.style.borderColor = '#27ae60';
            } else if (this.value) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</body>

</html>