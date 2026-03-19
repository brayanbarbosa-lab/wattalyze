  <!-- Modern Header -->

      <script src="https://cdn.tailwindcss.com"></script>
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 md:px-8 lg:px-16">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-10 transition-transform group-hover:scale-105">
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('produtos') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                        Produtos
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('contato') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                        Contato
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('suporte') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                        Suporte
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all group-hover:w-full"></span>
                    </a>
                </div>

                <!-- Desktop Buttons -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ route('login') }}">
                        <button class="px-6 py-2.5 text-gray-700 font-semibold hover:text-green-600 transition-colors">
                            Login
                        </button>
                    </a>
                    <a href="{{ route('register') }}">
                        <button class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105">
                            Cadastrar
                        </button>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="menuToggle" class="lg:hidden p-2 text-gray-700 hover:text-green-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="navLinks" class="lg:hidden overflow-hidden transition-all duration-300 max-h-0 opacity-0">
                <div class="py-4 space-y-3 border-t border-gray-200">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg font-medium transition-all">
                        Produtos
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg font-medium transition-all">
                        Contato
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg font-medium transition-all">
                        Suporte
                    </a>
                    <div class="pt-3 border-t border-gray-200 space-y-3">
                        <a href="{{ route('login') }}" class="block">
                            <button class="w-full px-4 py-2.5 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition-all">
                                Login
                            </button>
                        </a>
                        <a href="{{ route('register') }}" class="block">
                            <button class="w-full px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 transition-all shadow-md">
                                Cadastrar
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

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