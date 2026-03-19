<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wattalyze - A Ponte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow-x: hidden;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

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

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.3;
            animation: blob 7s infinite;
        }

        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .faq-item {
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            transform: translateX(10px);
            background: linear-gradient(to right, #f9fafb, transparent);
        }
    </style>
</head>
@include('components.Header')
<body class="font-sans bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">
    
    <!-- Hero Section -->
    <section class="relative px-4 md:px-8 lg:px-16 py-12 md:py-20 overflow-hidden">
        <!-- Background Blobs -->
        <div class="blob w-96 h-96 bg-green-400 top-10 -left-48"></div>
        <div class="blob w-96 h-96 bg-blue-400 bottom-10 -right-48"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Conteúdo -->
                <div class="text-center lg:text-left fade-in-up">
                    <div class="inline-block mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                        🚀 Tecnologia IoT Avançada
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                        A Ponte <span class="gradient-text">Wattalyze</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed max-w-xl">
                        Revolucione seu gerenciamento de energia. Conecte, monitore e otimize seus equipamentos com inteligência artificial e análise em tempo real.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}">

                        <button class="group px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-2xl hover:scale-105">
                            Começar Agora
                            <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                        </button>
                        </a>
                        <a href="{{ route('produtos') }}">
                        <button class="px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-xl font-bold hover:border-gray-900 hover:text-gray-900 hover:bg-white transition-all duration-300 shadow-sm hover:shadow-md">
                            Produtos
                        </button>
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 max-w-md mx-auto lg:mx-0">
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-gray-900">98%</div>
                            <div class="text-sm text-gray-600">Precisão</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-gray-900">24/7</div>
                            <div class="text-sm text-gray-600">Suporte</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-gray-900">5min</div>
                            <div class="text-sm text-gray-600">Instalação</div>
                        </div>
                    </div>
                </div>

                <!-- Imagem -->
                <div class="flex justify-center lg:justify-end">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-3xl blur-3xl opacity-20"></div>
                        <img src="{{ asset('images/wa1.png') }}" alt="Imagem da Ponte Wattalyze" class="relative float-animation w-full max-w-md lg:max-w-lg drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2 -->
    <section class="px-4 md:px-8 lg:px-16 py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-6">
                    Além do <span class="gradient-text">Gateway Comum</span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto">
                    Tecnologia de ponta para coleta e análise de dados com segurança total
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Imagem -->
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-green-400 to-blue-500 rounded-3xl opacity-20 blur-2xl"></div>
                    <img src="{{ asset('images/wa3.png') }}" alt="" class="relative w-full max-w-md mx-auto rounded-3xl shadow-2xl">
                </div>

                <!-- Texto com Features -->
                <div>
                    <p class="text-xl md:text-2xl text-gray-700 leading-relaxed mb-8">
                        No gerenciamento inteligente de consumo e automação, um gateway comum não é suficiente.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-green-50 transition-all">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                                ⚡
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Processamento Avançado</h4>
                                <p class="text-gray-600">Análise de dados em tempo real com IA integrada</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-blue-50 transition-all">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                                🔒
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Segurança Total</h4>
                                <p class="text-gray-600">Criptografia de ponta a ponta para seus dados</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-purple-50 transition-all">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                                📊
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Otimização Inteligente</h4>
                                <p class="text-gray-600">Economia de até 40% no consumo de energia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-green-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 md:px-8 lg:px-16 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4">
                    Comprometidos com <span class="gradient-text">Você</span>
                </h2>
                <p class="text-xl text-gray-400">Tudo que você precisa em uma solução completa</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="card-hover bg-white rounded-3xl p-8 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <img src="{{ asset('images/icons/cabo.png') }}" class="w-12 h-12" alt="">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Instalação Rápida</h3>
                    <p class="text-gray-600">Configure em menos de 5 minutos</p>
                </div>

                <!-- Feature 2 -->
                <div class="card-hover bg-white rounded-3xl p-8 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <img src="{{ asset('images/icons/headset.png') }}" class="w-12 h-12" alt="">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Suporte 24/7</h3>
                    <p class="text-gray-600">Equipe especializada sempre disponível</p>
                </div>

                <!-- Feature 3 -->
                <div class="card-hover bg-white rounded-3xl p-8 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <img src="{{ asset('images/icons/ondas.png') }}" class="w-12 h-12" alt="">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Updates OTA</h3>
                    <p class="text-gray-600">Sempre atualizado automaticamente</p>
                </div>

                <!-- Feature 4 -->
                <div class="card-hover bg-white rounded-3xl p-8 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <img src="{{ asset('images/icons/brasil.png') }}" class="w-12 h-12" alt="">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">100% Nacional</h3>
                    <p class="text-gray-600">Desenvolvido e produzido no Brasil</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-gradient-to-b from-white to-gray-50 py-20 md:py-28">
        <div class="max-w-4xl mx-auto px-4 md:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Perguntas <span class="gradient-text">Frequentes</span>
                </h2>
                <p class="text-xl text-gray-600">Tudo que você precisa saber</p>
            </div>

            <div class="space-y-6">
                <!-- FAQ 1 -->
                <div class="faq-item bg-white rounded-2xl p-8 shadow-md hover:shadow-xl border-l-4 border-green-500">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 flex items-start gap-3">
                        <span class="text-green-600 flex-shrink-0">❓</span>
                        Como funciona um equipamento IoT para controle de energia?
                    </h3>
                    <p class="text-lg text-gray-600 leading-relaxed pl-9">
                        O dispositivo se conecta aos eletrodomésticos e mede o consumo de energia em tempo real. Ele transmite essas informações para um aplicativo, permitindo que o usuário monitore, analise e otimize o uso de energia de forma inteligente.
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item bg-white rounded-2xl p-8 shadow-md hover:shadow-xl border-l-4 border-blue-500">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 flex items-start gap-3">
                        <span class="text-blue-600 flex-shrink-0">📱</span>
                        Como posso acessar os dados de consumo de energia?
                    </h3>
                    <p class="text-lg text-gray-600 leading-relaxed pl-9">
                        Os dados são acessíveis por meio de um aplicativo móvel ou plataforma web, onde o usuário pode visualizar gráficos detalhados, receber alertas personalizados e acompanhar o histórico completo de consumo.
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item bg-white rounded-2xl p-8 shadow-md hover:shadow-xl border-l-4 border-purple-500">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 flex items-start gap-3">
                        <span class="text-purple-600 flex-shrink-0">🔧</span>
                        Preciso de um profissional para instalar o equipamento IoT?
                    </h3>
                    <p class="text-lg text-gray-600 leading-relaxed pl-9">
                        Não! Nosso dispositivo é plug and play e pode ser instalado facilmente em menos de 5 minutos. Para casos mais complexos, oferecemos suporte técnico especializado gratuito.
                    </p>
                </div>
            </div>

           
        </div>
    </section>

</body>
@include('components.Footer')
</html>