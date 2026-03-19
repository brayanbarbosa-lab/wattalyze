<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wattalyze - Produtos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow-x: hidden;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-16px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.2;
            animation: blob 7s infinite;
        }

        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-icon {
            transition: all 0.3s ease;
        }

        .feature-icon:hover {
            transform: rotate(10deg) scale(1.1);
        }
    </style>
</head>

<body class="font-sans bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">


    @include('components.Header')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('menuToggle');
            const nav = document.getElementById('navLinks');

            toggle.addEventListener('click', () => {
                if (nav.classList.contains('max-h-0')) {
                    nav.classList.remove('max-h-0', 'opacity-0');
                    nav.classList.add('max-h-96', 'opacity-100');
                } else {
                    nav.classList.remove('max-h-96', 'opacity-100');
                    nav.classList.add('max-h-0', 'opacity-0');
                }
            });
        });
    </script>

    <!-- Hero Section -->
    <section class="relative px-4 md:px-8 lg:px-16 py-24 md:py-32 mt-20 overflow-hidden">
        <div class="blob w-96 h-96 bg-green-400 top-10 -left-48"></div>
        <div class="blob w-96 h-96 bg-blue-400 bottom-10 -right-48"></div>

        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-block mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                🌟 Linha Completa de Produtos IoT
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                Nossos <span class="gradient-text">Produtos</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-12">
                Tecnologia inteligente para transformar sua casa ou empresa em um ambiente conectado e eficiente
            </p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="px-4 md:px-8 lg:px-16 py-16 md:py-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">

                <!-- Product 1: Tomada Inteligente -->
                <div class="product-card bg-white rounded-3xl overflow-hidden shadow-lg">
                    <div class="relative h-72 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black/5"></div>
                        <div class="relative text-white text-9xl">🔌</div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">BEST SELLER</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">IoT</span>
                        </div>

                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Tomada Com Medição de Consumo</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                            Controle qualquer dispositivo remotamente. Monitore consumo em tempo real e automatize sua rotina com inteligência.
                        </p>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base">Relatórios Personalizados</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base">Monitoramento de Energia</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base">Precisão de ±2%</span>
                            </div>
                        </div>

                        <button class="w-full py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl hover:scale-105 text-lg">
                            Fale com Nossos Atendentes
                        </button>
                    </div>
                </div>

                <!-- Product 2: Sensor de Umidade e Temperatura -->
                <div class="product-card bg-white rounded-3xl overflow-hidden shadow-lg">
                    <div class="relative h-72 bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black/5"></div>
                        <div class="relative text-white text-9xl">🌡️💧</div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold rounded-full">POPULAR</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">IoT</span>
                        </div>

                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Sensor de Umidade e Temperatura</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                            Monitore temperatura e umidade com precisão. Crie ambientes mais saudáveis e previna mofo e problemas respiratórios.
                        </p>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-gray-700">
                                <div class="w-6 h-6 bg-cyan-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base">Precisão de ±2%</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-700">
                                <div class="w-6 h-6 bg-cyan-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base">Monitoramento 24/7</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-700">
                                <div class="w-6 h-6 bg-cyan-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base">Relatórios Detalhados</span>
                            </div>
                            
                        </div>

                        <button class="w-full py-4 bg-gradient-to-r from-blue-500 to-cyan-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-cyan-700 transition-all shadow-lg hover:shadow-xl hover:scale-105 text-lg">
                            Fale com Nossos Atendentes
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="px-4 md:px-8 lg:px-16 py-16 md:py-20 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Compare os <span class="gradient-text">Produtos</span>
                </h2>
                <p class="text-xl text-gray-600">Escolha a solução ideal para suas necessidades</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-6 px-8 text-gray-900 font-bold text-lg">Característica</th>
                                <th class="text-center py-6 px-8 text-gray-900 font-bold text-lg">Tomada Inteligente</th>
                                <th class="text-center py-6 px-8 text-gray-900 font-bold text-lg">Sensor Temperatura/Umidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                                <td class="py-5 px-8 text-gray-700 font-medium">Controle Remoto</td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                                <td class="py-5 px-8 text-gray-700 font-medium">Automação</td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                                <td class="py-5 px-8 text-gray-700 font-medium">Histórico de Dados</td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                                <td class="py-5 px-8 text-gray-700 font-medium">Monitoramento de Energia</td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                                <td class="text-center py-5 px-8">
                                    <span class="text-gray-400 text-2xl font-light">—</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="py-5 px-8 text-gray-700 font-medium">Monitoramento Ambiental</td>
                                <td class="text-center py-5 px-8">
                                    <span class="text-gray-400 text-2xl font-light">—</span>
                                </td>
                                <td class="text-center py-5 px-8">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-4 md:px-8 lg:px-16 py-20 bg-gradient-to-br from-gray-900 to-gray-800">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Pronto para começar?
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Entre em contato com nossa equipe e descubra a solução ideal para você
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="">
                <button class="px-10 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-2xl hover:scale-105">
                    Falar com Atendente
                </button>
                </a>
                <a href="{{ asset('storage/documentos/termos_wattalyze.pdf') }}">
                <button class="px-10 py-4 bg-white text-gray-900 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-lg hover:shadow-2xl hover:scale-105">
                    Ver Documentação
                </button>
                </a>
            </div>
        </div>
    </section>


    @include('components.Footer')

</body>

</html>