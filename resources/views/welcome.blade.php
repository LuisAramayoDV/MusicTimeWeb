<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reproductor Musical</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Fuente elegante para el texto neón -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Hover.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css">

    <!-- Estilos personalizados -->
    <style>
        @keyframes wave-move {
            0% { transform: translateX(0); }
            50% { transform: translateX(50px); }
            100% { transform: translateX(0); }
        }

        @keyframes note-float {
            0% { transform: translateY(0) rotate(0deg); opacity: 0.5; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 0.8; }
            100% { transform: translateY(0) rotate(360deg); opacity: 0.5; }
        }

        @keyframes logo-beat {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes beat {
            0% { transform: scale(1); }
            20% { transform: scale(1.05); }
            40% { transform: scale(1); }
            60% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .animate-wave { animation: wave-move 8s ease-in-out infinite; }
        .animate-note-float { animation: note-float 5s ease-in-out infinite; }
        .animate-logo-beat { animation: logo-beat 2s ease-in-out infinite; }
        .animate-beat { animation: beat 1s ease-in-out infinite; }

        /* Estilo del reproductor central - Aumentado el tamaño */
        .player {
            background: linear-gradient(to bottom,rgb(0, 0, 0), #1e779e);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            width: 600px; /* Aumentado de 400px a 600px */
            padding: 40px; /* Aumentado de 20px a 40px */
            text-align: center;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        .logo {
            font-size: 3rem; /* Aumentado de 2.5rem a 3rem */
            font-weight: 800;
            color: #ffcc00;
            text-shadow: 0 0 10px rgba(255, 204, 0, 0.8);
            margin-bottom: 30px;
        }

        .progress-bar {
            width: 100%;
            height: 8px; /* Aumentado de 5px a 8px */
            background: linear-gradient(to right, #00ffcc, #ff69b4);
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .visualizer {
            display: flex;
            justify-content: center;
            gap: 4px; /* Aumentado de 2px a 4px */
            margin-top: 30px;
        }

        .bar {
            width: 8px; /* Aumentado de 5px a 8px */
            height: 30px; /* Aumentado de 20px a 30px */
            background: #ffcc00;
            border-radius: 3px;
            animation: beat 1s ease-in-out infinite;
        }

        .bar:nth-child(2) { animation-delay: 0.1s; }
        .bar:nth-child(3) { animation-delay: 0.2s; }
        .bar:nth-child(4) { animation-delay: 0.3s; }
        .bar:nth-child(5) { animation-delay: 0.4s; }

        .wave-container {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .wave {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, rgba(0, 255, 204, 0.3), rgba(255, 105, 180, 0.3));
            animation: wave-move 8s ease-in-out infinite;
        }

        .wave-note {
            position: absolute;
            width: 30px;
            height: 30px;
            color: #00ffcc;
            filter: drop-shadow(0 0 10px rgba(0, 255, 204, 0.5));
            animation: note-float 5s ease-in-out infinite;
        }

        /* Estilo para el texto neón - Más elegante y animado */
        .neon-text {
            font-family: 'Dancing Script', cursive; /* Fuente elegante */
            font-weight: 700;
            text-align: center;
            color: #012d2a;
            text-shadow:
                0 0 5px #0ff,
                0 0 10px #0ff,
                0 0 20px #0ff,
                0 0 40px #0ff,
                0 0 60px rgba(0, 27, 228, 0.94);
        }

        /* Ajuste de tamaños para las frases */
        .neon-text-large {
            font-size: 3.5rem; /* Aumentado de 3xl (3rem) a 3.5rem */
        }

        .neon-text-medium {
            font-size: 2.5rem; /* Aumentado de 2xl (2rem) a 2.5rem */
        }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-b from-[#000000] via-[#1a3c5e] to-[#1e779e">

    <!-- Fondo de partículas -->
    <div id="particles-js" class="absolute inset-0 z-0"></div>

    <!-- Líneas onduladas con notas musicales -->
    <div class="wave-container">
        <div class="wave" style="top: 20%;">
            <div class="wave-note" style="left: 10%; top: -15px;">
                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55A4 4 0 108 17V7h4V3h-4z" />
                </svg>
            </div>
            <div class="wave-note" style="left: 50%; top: -15px;">
                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55A4 4 0 108 17V7h4V3h-4z" />
                </svg>
            </div>
        </div>
        <div class="wave" style="top: 40%;">
            <div class="wave-note" style="left: 30%; top: -15px;">
                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55A4 4 0 108 17V7h4V3h-4z" />
                </svg>
            </div>
            <div class="wave-note" style="left: 70%; top: -15px;">
                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55A4 4 0 108 17V7h4V3h-4z" />
                </svg>
            </div>
        </div>
        <div class="wave" style="top: 60%;">
            <div class="wave-note" style="left: 20%; top: -15px;">
                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55A4 4 0 108 17V7h4V3h-4z" />
                </svg>
            </div>
            <div class="wave-note" style="left: 60%; top: -15px;">
                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55A4 4 0 108 17V7h4V3h-4z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="relative z-30 player text-center">
        <!-- Logo grande -->
        <div class="logo animate-logo-beat mb-6">
            <img src="/images/logo3.png" alt="Logo MusicTime" style="height: 280px;"> <!-- Aumentado de 240px a 280px -->
        </div>

        <!-- Frases con efecto neón -->
        <div class="neon-text neon-text-large mb-6">Descubre el ritmo que mueve tu mundo.</div>
        <div class="neon-text neon-text-medium mb-10">Tu música, sin límites, en cualquier momento.</div>

        <!-- Botones grandes -->
        <div class="flex justify-center space-x-8 text-xl"> <!-- Aumentado el espacio entre botones -->
            <a href="/login" class="btn bg-gradient-to-r from-[#33f00d] to-[#33f00d] text-black px-8 py-4 rounded-full font-bold hvr-grow shadow-lg">Iniciar sesión</a> <!-- Aumentado el padding -->
            <a href="/register" class="btn bg-gradient-to-r from-[#33f00d] to-[#33f00d] text-black px-8 py-4 rounded-full font-bold hvr-grow shadow-lg">Registrarse</a> <!-- Aumentado el padding -->
        </div>

        <!-- Visualizador de barras -->
        <div class="visualizer mt-12">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.8.49/Tone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>

    <script>
        // Configuración de partículas con Particles.js
        particlesJS("particles-js", {
            particles: {
                number: { value: 100 },
                color: { value: ["#00ffcc", "#ff69b4", "#00ff00"] },
                size: { value: 3, random: true },
                move: { speed: 2 },
                opacity: { value: 0.5, random: true },
            },
            interactivity: {
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" },
                },
            },
        });

        // Animaciones con GSAP para las notas musicales
        gsap.to(".wave-note", {
            y: -30,
            rotation: 360,
            opacity: 0.8,
            repeat: -1,
            yoyo: true,
            duration: 5,
            stagger: 0.5
        });

        // Animación avanzada con GSAP para el texto neón
        gsap.to(".neon-text", {
            opacity: 0.85,
            repeat: -1,
            yoyo: true,
            duration: 2,
            ease: "sine.inOut",
            onRepeat: function() {
                gsap.to(this.targets(), {
                    textShadow: "0 0 5px #0ff, 0 0 15px #0ff, 0 0 30px #0ff, 0 0 50px #0ff, 0 0 70px rgba(0, 255, 255, 0.7)",
                    duration: 1,
                    ease: "power1.inOut"
                });
            }
        });

       

        // Animación con Lottie (opcional)
        lottie.loadAnimation({
            container: document.createElement("div"),
            path: "https://assets.lottiefiles.com/packages/lf20_V9t1B9.json",
            renderer: "svg",
            loop: true,
            autoplay: true,
        });
    </script>
</body>
</html>