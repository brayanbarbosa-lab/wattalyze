<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -12px rgba(39, 174, 96, 0.4);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideIn 0.3s ease-out;
        }

        .success-message {
            color: #27ae60;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                <div class="mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #27ae60, #2c3e50);">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </a>
            <h2 class="text-3xl font-bold text-white">Bem-vindo de Volta</h2>
            <p class="mt-2 text-sm text-white/70">Entre com suas credenciais para continuar</p>
        </div>

        <!-- Formulário Principal -->
        <div class="glass-card rounded-2xl p-8 space-y-6">
            
            <!-- Mensagem de Sucesso -->
            @if(session('success'))
            <div class="success-message">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('status'))
            <div class="success-message">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
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
                    @error('password')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Lembrar e Esqueceu senha -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" 
                               name="remember" 
                               type="checkbox" 
                               class="h-4 w-4 border-gray-300 rounded focus:ring-2"
                               style="accent-color: #27ae60;">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Lembrar-me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500 hover:underline">
                            Esqueceu a senha?
                        </a>
                    </div>
                </div>

                <!-- Botão de Submit -->
                <button type="submit" 
                        class="btn-primary w-full flex justify-center items-center gap-3 text-white font-semibold py-4 px-6 rounded-xl relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Entrar
                </button>

                <!-- Link para Registro -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Não tem uma conta?</span>
                    <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline transition-colors duration-200 ml-1">
                        Criar conta
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
        // Simulação de login (para demonstração)
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const btn = document.getElementById('login-btn');
            const btnText = document.getElementById('btn-text');

            // Loading state
            btn.disabled = true;
            btnText.textContent = 'Entrando...';
            btn.style.opacity = '0.7';

            // Simular requisição
            setTimeout(() => {
                if (email === 'demo@wattalyze.com' && password === '123456') {
                    // Sucesso
                    showAlert('success', 'Login realizado com sucesso! Redirecionando...');
                    setTimeout(() => {
                        window.location.href = '/dashboard'; // Redirecionar para dashboard
                    }, 1500);
                } else {
                    // Erro
                    showAlert('error', ['Email ou senha incorretos.']);
                    btn.disabled = false;
                    btnText.textContent = 'Entrar';
                    btn.style.opacity = '1';
                }
            }, 1000);
        });

        // Função para mostrar alertas
        function showAlert(type, message) {
            hideAllAlerts();

            if (type === 'success') {
                const alert = document.getElementById('success-alert');
                document.getElementById('success-text').textContent = message;
                alert.style.display = 'flex';

                // Auto-hide após 5 segundos
                setTimeout(() => {
                    hideAlert(alert);
                }, 5000);
            } else if (type === 'error') {
                const alert = document.getElementById('error-alert');
                const errorList = document.getElementById('error-list');
                errorList.innerHTML = '';

                if (Array.isArray(message)) {
                    message.forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });
                } else {
                    const li = document.createElement('li');
                    li.textContent = message;
                    errorList.appendChild(li);
                }

                alert.style.display = 'block';
            }
        }

        function hideAllAlerts() {
            document.getElementById('success-alert').style.display = 'none';
            document.getElementById('error-alert').style.display = 'none';
        }

        function hideAlert(alert) {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
                alert.style.opacity = '1';
            }, 300);
        }

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

        document.getElementById('password').addEventListener('input', function() {
            if (this.value.length >= 6) {
                this.style.borderColor = '#27ae60';
            } else if (this.value.length > 0) {
                this.style.borderColor = '#f39c12';
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</body>

</html>