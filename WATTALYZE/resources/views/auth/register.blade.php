<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            overflow-y: auto !important;
            min-height: 100vh;
            overflow-x: hidden !important;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
            position: relative;
            min-height: 100vh;
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
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
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

        .input-error {
            border-color: #e74c3c !important;
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1) !important;
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
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

        .error-message {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-message {
            color: #27ae60;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 640px) {
            .glass-card {
                padding: 1.5rem !important;
            }
            
            .input-glass {
                padding: 0.875rem !important;
            }
        }
    </style>
</head>
<body class="gradient-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Header -->
        <div class="text-center">
            <a href="{{ route('welcome') }}">
                <div class="logo-gradient mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #27ae60, #2c3e50);">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </a>
            <h2 class="text-3xl font-bold text-white">Criar Nova Conta</h2>
            <p class="mt-2 text-sm text-white/70">Preencha os dados abaixo para começar</p>
        </div>

        <!-- Formulário Principal -->
        <div class="glass-card rounded-2xl p-8 space-y-6">
            
            <!-- Mensagem de Sucesso -->
            @if(session('success'))
            <div class="success-message bg-green-50 p-4 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <!-- Nome -->
                <div class="group">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nome Completo <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div class="feature-icon w-5 h-5">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="input-glass w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none @error('name') input-error @enderror"
                               placeholder="Digite seu nome completo"
                               required>
                    </div>
                    @error('name')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="group">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div class="feature-icon w-5 h-5">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                        </div>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="input-glass w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none @error('email') input-error @enderror"
                               placeholder="Digite seu email"
                               required>
                    </div>
                    @error('email')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Senha -->
                <div class="group">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Senha <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Mínimo 8 caracteres, incluindo pelo menos uma letra e um número</p>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div class="feature-icon w-5 h-5">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="input-glass w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none @error('password') input-error @enderror"
                               placeholder="Digite sua senha"
                               required>
                    </div>
                    <!-- Indicador de força da senha -->
                    <div class="mt-2 h-1 bg-gray-200 rounded overflow-hidden">
                        <div id="password-strength-bar" class="h-full transition-all duration-300 rounded" style="width: 0%"></div>
                    </div>
                    <p id="password-requirements" class="text-xs text-gray-500 mt-1"></p>
                    @error('password')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Confirmar Senha -->
                <div class="group">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmar Senha <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <div class="feature-icon w-5 h-5">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="input-glass w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none"
                               placeholder="Digite a senha novamente"
                               required>
                    </div>
                    <p id="password-match-message" class="text-xs mt-1"></p>
                </div>

                <!-- Termos -->
                <div class="flex items-start">
                    <div class="flex items-center h-5 mt-1">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               class="h-4 w-4 focus:ring-2 border-gray-300 rounded transition-all duration-200"
                               style="accent-color: #27ae60;"
                               required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            Eu concordo com os 
                            <a href="{{ asset('storage/documentos/termos_wattalyze.pdf') }}" class="text-green-600 font-medium hover:underline transition-all duration-200">Termos de Uso</a>
                        </label>
                    </div>
                </div>

                <!-- Botão de Submit -->
                <button type="submit" 
                        class="btn-primary w-full flex justify-center items-center gap-3 text-white font-semibold py-4 px-6 rounded-xl relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Criar Conta
                </button>

                <!-- Link para Login -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Já tem uma conta?</span>
                    <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline transition-colors duration-200 ml-1">
                        Fazer login
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-white/70">
            <p>&copy; 2025 Wattalyze. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        // Validação de força de senha
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength-bar');
            const requirements = document.getElementById('password-requirements');
            let strength = 0;
            
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const minLength = password.length >= 8;
            
            if (minLength) strength += 33;
            if (hasLetter) strength += 33;
            if (hasNumber) strength += 34;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.background = 'linear-gradient(to right, #e74c3c, #f39c12)';
                requirements.textContent = 'Senha fraca';
                requirements.style.color = '#e74c3c';
            } else if (strength < 100) {
                strengthBar.style.background = 'linear-gradient(to right, #f39c12, #f1c40f)';
                requirements.textContent = 'Senha média';
                requirements.style.color = '#f39c12';
            } else {
                strengthBar.style.background = 'linear-gradient(to right, #27ae60, #2ecc71)';
                requirements.textContent = 'Senha forte! ✓';
                requirements.style.color = '#27ae60';
            }
            
            if (!hasLetter || !hasNumber) {
                requirements.textContent = 'Precisa de pelo menos uma letra e um número';
                requirements.style.color = '#e74c3c';
            }
        });

        // Validação de confirmação de senha
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const message = document.getElementById('password-match-message');
            
            if (confirmPassword.length === 0) {
                message.textContent = '';
                this.style.borderColor = '';
            } else if (password === confirmPassword) {
                message.textContent = 'Senhas coincidem ✓';
                message.style.color = '#27ae60';
                this.style.borderColor = '#27ae60';
            } else {
                message.textContent = 'Senhas não coincidem';
                message.style.color = '#e74c3c';
                this.style.borderColor = '#e74c3c';
            }
        });
    </script>
</body>
</html>