<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verificar Email - Sistema de Monitoramento Energético</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c3e50 0%, #27ae60 100%);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #2c3e50;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
        }

        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            border-color: #27ae60;
            color: #1e7e34;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4">

    <div class="max-w-md w-full space-y-6">
        <!-- Header -->
        <div class="text-center">
            <a href="{{ route('welcome') }}">
                <div class="mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4" 
                     style="background: linear-gradient(135deg, #27ae60, #2c3e50);">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </a>
            <h2 class="text-4xl font-bold text-white mb-2">Wattalyze</h2>
            <p class="text-xl text-white/90 mb-1">Verificar Email</p>
            <p class="text-sm text-white/70">
                Confirme seu endereço de email para ativar sua conta
            </p>
        </div>

        <!-- Mensagens -->
        @if (session('message'))
        <div class="glass-card alert-success border rounded-2xl p-4 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('message') }}</span>
        </div>
        @endif

        @if (session('status'))
        <div class="glass-card alert-success border rounded-2xl p-4 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        <!-- Informações -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-full p-3">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-3">
                Obrigado por se registrar!
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed text-center">
                Antes de começar, você poderia verificar seu endereço de email clicando no link que acabamos de enviar para você? 
                Se você não recebeu o email, ficaremos felizes em enviar outro.
            </p>
        </div>

        <!-- Botões de Ação -->
        <div class="glass-card rounded-2xl p-8 space-y-4">

            <!-- Botão Reenviar Email -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full flex justify-center items-center gap-3 text-white font-semibold py-4 px-6 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reenviar Email de Verificação</span>
                </button>
            </form>

            <a href="{{ route('sair.agora') }}" class="btn-secondary w-full flex justify-center items-center gap-3 font-semibold py-4 px-6 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Sair</span>
            </a>
        </div>



        <!-- Dicas -->
        <div class="glass-card rounded-2xl p-6">
            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dicas Úteis
            </h4>
            <ul class="text-sm text-gray-600 space-y-2">
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Verifique sua caixa de spam ou lixo eletrônico
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    O link de verificação expira em 60 minutos
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">•</span>
                    Certifique-se de que o endereço de email está correto
                </li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-white/70">
            <p>&copy; 2025 Wattalyze. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        // Função para fazer logout via Fetch
        function logoutViaFetch() {
            console.log('🔵 Iniciando logout via Fetch...');

            fetch('{{ route("logout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                redirect: 'follow'
            })
            .then(response => {
                console.log('📥 Resposta recebida:', response.status, response.statusText);
                if (response.redirected) {
                    console.log('↪️ Redirecionando para:', response.url);
                    window.location.href = response.url;
                } else if (response.ok) {
                    console.log('✅ Logout bem-sucedido, redirecionando...');
                    window.location.href = '/';
                } else {
                    console.error('❌ Erro na resposta:', response);
                    alert('Erro ao fazer logout. Status: ' + response.status);
                }
            })
            .catch(error => {
                console.error('❌ Erro no fetch:', error);
                alert('Erro ao fazer logout: ' + error.message);
            });
        }

        // Debug do formulário POST
        document.getElementById('logout-form-post').addEventListener('submit', function(e) {
            console.log('📤 Formulário POST sendo enviado...');
            console.log('Action:', this.action);
            console.log('Method:', this.method);
            console.log('CSRF Token presente:', !!this.querySelector('[name="_token"]'));
        });
    </script>
</body>
</html>