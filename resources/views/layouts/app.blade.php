<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Howler.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.4/howler.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-inter">
    <div id="app">
        <nav class="bg-gray-800/90 backdrop-blur-md shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo or Brand -->
                    <img src="{{ asset('images/logo3.png') }}" alt="Logo MusicTime" style="height: 100px;">

                    <div></div>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md p-2" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#navbarSupportedContent" 
                            aria-controls="navbarSupportedContent" 
                            aria-expanded="false" 
                            aria-label="{{ __('Toggle navigation') }}">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Navbar Content -->
               <div class="hidden md:flex md:items-center md:w-full" id="navbarSupportedContent">
                        @php
                            use App\Models\Genre;
                            $genres = Genre::all();
                        @endphp

                        <!-- Left Side -->
                        <ul class="flex items-center space-x-6">
                            <li>
                                <a href="{{ url('home') }}" 
                                   class="text-gray-300 hover:text-indigo-400 transition-colors font-medium">
                                    Inicio
                                </a>
                            </li>
                            <li class="relative group">
                                <a href="#" 
                                   class="text-gray-300 hover:text-indigo-400 transition-colors font-medium flex items-center"
                                   id="navbarDropdownGenres"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false">
                                    Géneros
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>
                                <div class="absolute left-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-xl hidden group-hover:block dropdown-menu"
                                     aria-labelledby="navbarDropdownGenres">
                                    @foreach ($genres as $genre)
                                        <a href="{{ route('genres.show', $genre->id) }}"
                                           class="block px-4 py-2 text-sm text-gray-300 hover:bg-indigo-600 hover:text-white rounded-lg">
                                            {{ $genre->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('songs.mostPlayed') }}" 
                                   class="text-gray-300 hover:text-indigo-400 transition-colors font-medium">
                                    Más Escuchadas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('songs.create') }}" 
                                   class="text-gray-300 hover:text-indigo-400 transition-colors font-medium">
                                    Añadir Música
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('playlists.index') }}" 
                                   class="text-gray-300 hover:text-indigo-400 transition-colors font-medium">
                                    Playlist
                                </a>
                            </li>
                        </ul>
                        <!-- Right Side -->
                        <ul class="ml-auto flex items-center space-x-6">
                            @guest
                                <li>
                                    <a href="{{ route('login') }}"
                                       class="text-gray-300 hover:text-indigo-400 transition-colors font-medium">
                                        Iniciar Sesión
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}"
                                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                                        Registrarse
                                    </a>
                                </li>
                            @else
                                <li class="relative group">
                                    <a href="#" 
                                       class="text-gray-300 hover:text-indigo-400 transition-colors font-medium flex items-center"
                                       id="navbarDropdown"
                                       role="button"
                                       data-bs-toggle="dropdown"
                                       aria-haspopup="true"
                                       aria-expanded="false">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                    <div class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-xl hidden group-hover:block dropdown-menu">
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                           class="block px-4 py-2 text-sm text-gray-300 hover:bg-indigo-600 hover:text-white rounded-lg">
                                            Cerrar Sesión
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <!-- Reproductor global -->
        <div id="player" class="hidden fixed bottom-0 left-0 right-0 bg-gray-800/95 backdrop-blur-md shadow-lg p-4 z-50">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Información de la canción -->
                <div class="flex items-center space-x-4">
                    <!-- Corrección: Usar secure_asset para la imagen por defecto -->
                    <img id="player-cover" src="{{ secure_asset('storage/covers/default-cover.png') }}" alt="Portada" class="w-12 h-12 rounded">
                    <div>
                        <p id="player-title" class="text-white font-medium">Selecciona una canción</p>
                        <p id="player-artist" class="text-gray-400 text-sm">Artista</p>
                    </div>
                </div>

                <!-- Controles del reproductor -->
                <div class="flex items-center space-x-4">
                    <button id="player-prev" class="text-gray-300 hover:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button id="player-play" class="text-gray-300 hover:text-indigo-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button id="player-next" class="text-gray-300 hover:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m-8 0h16" />
                        </svg>
                    </button>
                </div>

                <!-- Barra de progreso -->
                <div class="flex-1 mx-4">
                    <div class="flex items-center space-x-2">
                        <span id="player-current-time" class="text-gray-400 text-sm">0:00</span>
                        <input type="range" id="player-progress" class="w-full accent-indigo-500" min="0" max="100" value="0">
                        <span id="player-duration" class="text-gray-400 text-sm">0:00</span>
                    </div>
                </div>

                <!-- Volumen -->
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                    <input type="range" id="player-volume" class="w-20 accent-indigo-500" min="0" max="1" step="0.01" value="1">
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>