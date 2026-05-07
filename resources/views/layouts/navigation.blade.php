<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                    NestBrew
                </a>
            </div>

            <!-- Nav Links -->
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}"
                   class="text-sm text-gray-600 hover:text-gray-900">
                    Home
                </a>
                <a href="{{ route('menu') }}"
                   class="text-sm text-gray-600 hover:text-gray-900">
                    Menu
                </a>
                <a href="#info"
                   class="text-sm text-gray-600 hover:text-gray-900">
                    Visit Us
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-3">
                @auth
                    <!-- Logged in — show user name and logout -->
                    <span class="text-sm text-gray-600">
                        {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm text-gray-600 hover:text-gray-900 border px-4 py-1.5 rounded-full">
                            Sign Out
                        </button>
                    </form>
                @else
                    <!-- Not logged in — show sign in and sign up -->
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 border px-4 py-1.5 rounded-full">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-sm text-white bg-gray-800 hover:bg-gray-700 px-4 py-1.5 rounded-full">
                        Sign Up
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>