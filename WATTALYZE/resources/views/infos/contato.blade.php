<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wattalyze - Contato</title>
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

        .contact-card {
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.2);
        }

        .form-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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
                💬 Estamos Aqui para Ajudar
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                Entre em <span class="gradient-text">Contato</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto">
                Tem dúvidas? Nossa equipe está pronta para responder todas as suas perguntas
            </p>
        </div>
    </section>

    <!-- Contact Cards -->
    <section class="px-4 md:px-8 lg:px-16 py-16">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

                <!-- Email Card -->
                <div class="contact-card bg-white rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Email</h3>
                    <p class="text-gray-600 mb-4">Envie-nos uma mensagem</p>
                    <a href="mailto:wattalyze@gmail.com" class="text-green-600 font-semibold hover:text-green-700 transition-colors text-lg">
                        wattalyze@gmail.com
                    </a>
                </div>

                <!-- Phone Card -->
                <div class="contact-card bg-white rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Telefone</h3>
                    <p class="text-gray-600 mb-4">Ligue para nós</p>
                    <a href="tel:+5511999999999" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors text-lg">
                        +55 (11) 9999-9999
                    </a>
                </div>

                <!-- Location Card -->
                <div class="contact-card bg-white rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Localização</h3>
                    <p class="text-gray-600 mb-4">Visite-nos</p>
                    <p class="text-purple-600 font-semibold text-lg">
                        São Paulo, Brasil
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="px-4 md:px-8 lg:px-16 py-16">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- Form Side -->
                    <div class="p-8 md:p-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Envie sua Mensagem</h2>
                        <p class="text-gray-600 mb-8 text-lg">Responderemos em até 24 horas</p>

                        <form class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
                                <input
                                    type="text"
                                    class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl transition-all"
                                    placeholder="Seu nome"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input
                                    type="email"
                                    class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl transition-all"
                                    placeholder="seu@email.com"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                                <input
                                    type="tel"
                                    class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl transition-all"
                                    placeholder="(11) 99999-9999">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Assunto</label>
                                <select class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl transition-all">
                                    <option>Dúvidas sobre Produtos</option>
                                    <option>Suporte Técnico</option>
                                    <option>Vendas e Orçamentos</option>
                                    <option>Parcerias</option>
                                    <option>Outros</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Mensagem</label>
                                <textarea
                                    class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl transition-all resize-none"
                                    rows="5"
                                    placeholder="Como podemos ajudar?"
                                    required></textarea>
                            </div>

                            <button type="submit" class="w-full py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl hover:scale-105 text-lg">
                                Enviar Mensagem
                            </button>
                        </form>
                    </div>

                    <!-- Info Side -->
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 p-8 md:p-12 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-3xl font-bold mb-8">Informações de Contato</h3>

                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-1 text-lg">Email</p>
                                        <p class="text-gray-300">wattalyze@gmail.com</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-1 text-lg">Telefone</p>
                                        <p class="text-gray-300">+55 (11) 9999-9999</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-1 text-lg">Horário de Atendimento</p>
                                        <p class="text-gray-300">Seg - Sex: 9h às 18h</p>
                                        <p class="text-gray-300">Sáb: 9h às 13h</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-1 text-lg">Endereço</p>
                                        <p class="text-gray-300">São Paulo, SP</p>
                                        <p class="text-gray-300">Brasil</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12">
                            <p class="text-sm text-gray-400 mb-4">Siga-nos nas redes sociais</p>
                            <div class="flex gap-3">
                                <a href="#" class="w-12 h-12 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-all hover:-translate-y-1">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-all hover:-translate-y-1">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-all hover:-translate-y-1">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('components.Footer')
</body>

</html>