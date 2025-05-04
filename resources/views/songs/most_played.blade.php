@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-white mb-8">Canciones Más Escuchadas</h1>

    @if ($songs->isEmpty())
        <p class="text-gray-400 text-lg">No hay canciones disponibles.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($songs as $index => $song)
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl">
                    <!-- Portada -->
                    <div class="relative">
                        @if ($song->cover_image && Storage::disk('public')->exists('covers/' . basename($song->cover_image)))
                            <img src="{{ asset('storage/covers/' . basename($song->cover_image)) }}" alt="{{ $song->title ?? 'Sin título' }}" class="w-full h-48 object-cover">
                        @else
                            <img src="{{ asset('storage/covers/default-cover.png') }}" alt="Portada por defecto" class="w-full h-48 object-cover">
                        @endif
                        <!-- Botón de play -->
                        @if ($song->audio_path && Storage::disk('public')->exists('songs/' . basename($song->audio_path)))
                            <button class="play-song absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 hover:opacity-100 transition-opacity" 
                                    data-song-id="{{ $song->id }}"
                                    data-title="{{ e($song->title ?? 'Sin título') }}"
                                    data-artist="{{ e($song->artist->name ?? 'Desconocido') }}"
                                    data-cover="{{ $song->cover_image && Storage::disk('public')->exists('covers/' . basename($song->cover_image)) ? asset('storage/covers/' . basename($song->cover_image)) : asset('storage/covers/default-cover.png') }}"
                                    data-audio="{{ asset('storage/songs/' . basename($song->audio_path)) }}">
                                <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-black/50">
                                <p class="text-red-400 text-sm">Audio no disponible</p>
                            </div>
                        @endif
                    </div>

                    <!-- Información de la canción -->
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-white truncate">
                            {{ $index + 1 }}. {{ $song->title ?? 'Sin título' }}
                        </h2>
                        <p class="text-gray-400 text-sm">{{ $song->artist->name ?? 'Desconocido' }}</p>
                        <p class="text-gray-500 text-sm">Reproducciones: {{ $song->plays_count ?? 0 }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Inicializar Howler.js
    let currentSound = null;
    let currentSongIndex = -1;
    let playlist = [];

    // Función para formatear tiempo (mm:ss)
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
    }

    // Reproducir una canción
    function playSong(songData, index) {
        if (currentSound) {
            currentSound.stop();
            currentSound = null;
        }

        if (!songData.audio) {
            console.error('No hay archivo de audio disponible para:', songData.title);
            alert('No hay archivo de audio disponible para esta canción.');
            return;
        }

        currentSound = new Howl({
            src: [songData.audio],
            html5: true,
            volume: document.getElementById('player-volume')?.value || 0.5,
            onplay: function() {
                document.getElementById('player-play').innerHTML = `
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>`;
                document.getElementById('player').classList.remove('hidden');
                document.getElementById('player-title').textContent = songData.title;
                document.getElementById('player-artist').textContent = songData.artist;
                document.getElementById('player-cover').src = songData.cover;
                currentSongIndex = index;

                // Actualizar duración
                document.getElementById('player-duration').textContent = formatTime(currentSound.duration());

                // Registrar reproducción vía AJAX
                fetch('/reproductions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ song_id: songData.id })
                })
                .then(response => response.json())
                .then(data => console.log(data.message))
                .catch(error => console.error('Error al registrar reproducción:', error));
            },
            onend: function() {
                playNext();
            },
            onerror: function(error) {
                console.error('Error al reproducir:', songData.audio, error);
                alert('Error al reproducir la canción.');
                playNext();
            }
        });

        currentSound.play();
        console.log('Reproduciendo:', songData.audio);

        // Actualizar barra de progreso
        currentSound.on('play', function() {
            setInterval(() => {
                if (currentSound && currentSound.playing()) {
                    const seek = currentSound.seek();
                    const duration = currentSound.duration();
                    document.getElementById('player-progress').value = (seek / duration) * 100;
                    document.getElementById('player-current-time').textContent = formatTime(seek);
                }
            }, 1000);
        });
    }

    // Reproducir siguiente canción
    function playNext() {
        if (currentSongIndex < playlist.length - 1) {
            playSong(playlist[++currentSongIndex], currentSongIndex);
        } else {
            currentSound?.stop();
            document.getElementById('player').classList.add('hidden');
            currentSongIndex = -1;
        }
    }

    // Reproducir canción anterior
    function playPrev() {
        if (currentSongIndex > 0) {
            playSong(playlist[--currentSongIndex], currentSongIndex);
        }
    }

    // Inicializar playlist con canciones válidas
    playlist = [
        @foreach ($songs as $index => $song)
            @if ($song->audio_path && Storage::disk('public')->exists('songs/' . basename($song->audio_path)))
                {
                    id: {{ $song->id }},
                    title: "{{ e($song->title ?? 'Sin título') }}",
                    artist: "{{ e($song->artist->name ?? 'Desconocido') }}",
                    cover: "{{ $song->cover_image && Storage::disk('public')->exists('covers/' . basename($song->cover_image)) ? asset('storage/covers/' . basename($song->cover_image)) : asset('storage/covers/default-cover.png') }}",
                    audio: "{{ asset('storage/songs/' . basename($song->audio_path)) }}"
                },
            @endif
        @endforeach
    ];

    // Evento para reproducir canción
    document.querySelectorAll('.play-song').forEach(button => {
        button.addEventListener('click', () => {
            const songData = {
                id: button.dataset.songId,
                title: button.dataset.title,
                artist: button.dataset.artist,
                cover: button.dataset.cover,
                audio: button.dataset.audio
            };
            console.log('Intentando reproducir:', songData);
            const index = playlist.findIndex(song => song.id == songData.id);
            if (index !== -1) {
                playSong(songData, index);
            } else {
                console.error('Canción no encontrada en la playlist:', songData.id);
                alert('Canción no disponible.');
            }
        });
    });

    // Controles del reproductor
    document.getElementById('player-play')?.addEventListener('click', () => {
        if (currentSound && currentSound.playing()) {
            currentSound.pause();
            document.getElementById('player-play').innerHTML = `
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
        } else if (currentSound) {
            currentSound.play();
            document.getElementById('player-play').innerHTML = `
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
        }
    });

    document.getElementById('player-next')?.addEventListener('click', playNext);
    document.getElementById('player-prev')?.addEventListener('click', playPrev);

    document.getElementById('player-progress')?.addEventListener('input', (e) => {
        if (currentSound) {
            const seek = (e.target.value / 100) * currentSound.duration();
            currentSound.seek(seek);
        }
    });

    document.getElementById('player-volume')?.addEventListener('input', (e) => {
        if (currentSound) {
            currentSound.volume(e.target.value);
        }
    });
</script>
@endsection