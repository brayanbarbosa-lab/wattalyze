<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wattalyze - Suporte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow-x: hidden;
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

        .support-card {
            transition: all 0.3s ease;
        }

        .support-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.2);
        }

        .faq-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-item.active .faq-content {
            max-height: 500px;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-icon {
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="font-sans bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">


    @include('components.Header')
    <!-- Hero Section -->
    <section class="relative px-4 md:px-8 lg:px-16 py-24 md:py-32 mt-20 overflow-hidden">
        <div class="blob w-96 h-96 bg-green-400 top-10 -left-48"></div>
        <div class="blob w-96 h-96 bg-blue-400 bottom-10 -right-48"></div>

        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-block mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                🛟 Atendimento 24/7
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                Central de <span class="gradient-text">Suporte</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-12">
                Encontre respostas rápidas ou fale diretamente com nossa equipe especializada
            </p>

        </div>
    </section>

    <!-- Support Options -->
    <section class="px-4 md:px-8 lg:px-16 py-16">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-12">
                Como Podemos <span class="gradient-text">Ajudar?</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                <!-- Email Support -->
                <div class="support-card bg-white rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Email</h3>
                    <p class="text-gray-600 mb-6">Resposta em até 24 horas</p>
                    <a href="mailto:wattalyze@gmail.com">
                    <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                        Enviar Email
                    </button>
                    </a>
                </div>

                <!-- Phone Support -->
                <div class="support-card bg-white rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Telefone</h3>
                    <p class="text-gray-600 mb-6">Atendimento humanizado</p>
                    <button class="w-full py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all">
                        Ligar Agora
                    </button>
                </div>

                <!-- Documentation -->
                <div class="support-card bg-white rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Documentação</h3>
                    <p class="text-gray-600 mb-6">Nossos Termos</p>
                    <a href="{{ asset('storage/documentos/termos_wattalyze.pdf') }}">
                    <button class="w-full py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 transition-all">
                        Ver Docs
                    </button>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="px-4 md:px-8 lg:px-16 py-16 bg-white">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-4">
                Perguntas <span class="gradient-text">Frequentes</span>
            </h2>
            <p class="text-xl text-gray-600 text-center mb-12">As dúvidas mais comuns de nossos clientes</p>

            <div class="space-y-4">

                <!-- FAQ 1 -->
                <div class="faq-item bg-gray-50 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-6 hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Como instalar a Tomada Inteligente?</h3>
                        </div>
                        <svg class="faq-icon w-6 h-6 text-gray-500 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div class="faq-content px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            A instalação é muito simples e não requer conhecimento técnico. Basta conectar a tomada inteligente em uma tomada comum, baixar o aplicativo Wattalyze, criar sua conta e seguir o processo de pareamento via WiFi. Todo o processo leva menos de 5 minutos!
                        </p>
                        <div class="mt-4 flex gap-3">
                            <a href="{{ asset('storage/documentos/tomada.pdf') }}">
                            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                Baixar Manual PDF
                            </button>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item bg-gray-50 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-6 hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Os sensores precisam de bateria?</h3>
                        </div>
                        <svg class="faq-icon w-6 h-6 text-gray-500 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div class="faq-content px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Não, os sensores de temperatura e umidade funcionam com energia elétrica.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item bg-gray-50 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-6 hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Posso controlar os dispositivos fora de casa?</h3>
                        </div>
                        <svg class="faq-icon w-6 h-6 text-gray-500 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div class="faq-content px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Sim! Desde que seus dispositivos estejam conectados à internet, você pode controlá-los de qualquer lugar do mundo através do aplicativo. Monitore o consumo e receba alertas em tempo real, não importa onde você esteja.
                        </p>
                    </div>
                </div>


                <!-- FAQ 5 -->
                <div class="faq-item bg-gray-50 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-6 hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Como funciona a garantia?</h3>
                        </div>
                        <svg class="faq-icon w-6 h-6 text-gray-500 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div class="faq-content px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Todos os produtos Wattalyze têm garantia de 12 meses contra defeitos de fabricação. Se você tiver qualquer problema dentro deste período, entre em contato com nosso suporte e faremos a troca ou reparo do produto sem custo adicional. A garantia cobre defeitos de fabricação, mas não danos causados por mau uso ou acidentes.
                        </p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item bg-gray-50 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-6 hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Quanto posso economizar na conta de luz?</h3>
                        </div>
                        <svg class="faq-icon w-6 h-6 text-gray-500 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div class="faq-content px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            A economia varia de acordo com o uso, mas nossos clientes relatam economia média de 20% a 40% na conta de luz. Com o monitoramento em tempo real, você identifica quais equipamentos consomem mais energia e pode otimizar seu uso. As automações também ajudam a evitar desperdício, desligando aparelhos automaticamente quando não estão em uso.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- CTA Section -->
    <section class="px-4 md:px-8 lg:px-16 py-20 bg-gradient-to-br from-gray-900 to-gray-800">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Ainda precisa de ajuda?
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Nossa equipe está disponível 24/7 para te atender
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="px-20 py-8 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-2xl hover:scale-105">
                    Falar com Suporte
                </button>
            </div>
        </div>
    </section>

    <script>
        // FAQ Accordion
        document.addEventListener('DOMContentLoaded', () => {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const header = item.querySelector('.flex');

                header.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');

                    // Close all items
                    faqItems.forEach(i => i.classList.remove('active'));

                    // Open clicked item if it wasn't active
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });
        });
    </script>
    @include('components.Footer')
</body>

</html>