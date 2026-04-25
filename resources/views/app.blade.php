<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <style>
            #global-loader {
                position: fixed;
                inset: 0;
                z-index: 9999;
                background-color: #000000;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: opacity 0.5s ease-in-out;
                font-family: 'Inter', sans-serif;
                overflow: hidden;
            }

            .bg-grid-pattern {
                position: absolute;
                inset: 0;
                background-size: 40px 40px;
                background-image: linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            }

            @keyframes pulse-ring {
                0% { transform: scale(0.8); opacity: 0.5; }
                50% { transform: scale(1); opacity: 1; }
                100% { transform: scale(0.8); opacity: 0.5; }
            }

            .pulse-animation {
                animation: pulse-ring 2s infinite ease-in-out;
            }

            @keyframes spin-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .spin-slow-animation {
                animation: spin-slow 8s linear infinite;
            }

            @keyframes blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.3; }
            }

            .blink-animation {
                animation: blink 1.5s infinite;
            }

            .loader-content {
                position: relative;
                z-index: 10;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .loader-logo-container {
                position: relative;
                width: 144px;
                height: 144px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 24px;
            }

            @media (min-width: 768px) {
                .loader-logo-container {
                    width: 192px;
                    height: 192px;
                }
            }

            .loader-ring {
                position: absolute;
                inset: 0;
                border-radius: 9999px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .loader-ring-dashed {
                position: absolute;
                inset: 12px;
                border-radius: 9999px;
                border: 1px dashed rgba(255, 255, 255, 0.1);
                animation: spin-slow 12s linear infinite reverse;
            }

            .loader-glow {
                position: absolute;
                width: 72px;
                height: 72px;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 9999px;
                filter: blur(20px);
            }

            @media (min-width: 768px) {
                .loader-glow {
                    width: 96px;
                    height: 96px;
                    filter: blur(24px);
                }
            }

            .loader-icon {
                position: relative;
                z-index: 20;
                font-size: 48px;
                color: white;
                filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.8));
            }

            @media (min-width: 768px) {
                .loader-icon {
                    font-size: 64px;
                    filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.8));
                }
            }

            .loader-dot {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 8px;
                height: 8px;
                background-color: white;
                border-radius: 9999px;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
            }

            .loader-text-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
                margin-top: 48px;
            }

            .loader-status {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .loader-indicator {
                width: 6px;
                height: 6px;
                background-color: white;
                border-radius: 9999px;
                box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
            }

            .loader-label {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 12px;
                font-weight: 600;
                color: white;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }

            .loader-progress {
                width: 200px;
                max-width: 80vw;
                height: 1px;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 9999px;
                overflow: hidden;
                margin-top: 12px;
                position: relative;
            }

            @media (min-width: 768px) {
                .loader-progress {
                    width: 256px;
                }
            }

            .loader-progress-bar {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 33.333333%;
                background: linear-gradient(to right, rgba(255, 255, 255, 0.5), white);
                border-radius: 9999px;
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: .5; }
            }

            .loader-terminal {
                position: absolute;
                bottom: 48px;
                left: 48px;
                font-family: 'Space Grotesk', sans-serif;
                font-size: 10px;
                color: #cfc2d6;
                text-align: left;
                line-height: 1.6;
                display: none;
            }

            @media (min-width: 768px) {
                .loader-terminal {
                    display: block;
                }
            }

            .terminal-dim { color: rgba(255, 255, 255, 0.4); }
            .terminal-pulse { animation: blink 1.5s infinite; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Static Loader -->
        <div id="global-loader">
            <div class="bg-grid-pattern"></div>
            
            <div class="loader-content">
                <div class="loader-logo-container">
                    <div class="loader-ring spin-slow-animation"></div>
                    <div class="loader-ring-dashed"></div>
                    <div class="loader-glow pulse-animation"></div>
                    <span class="material-symbols-outlined loader-icon">hub</span>
                    <div class="loader-ring spin-slow-animation" style="border: none;">
                        <div class="loader-dot"></div>
                    </div>
                </div>

                <div class="loader-text-container">
                    <div class="loader-status">
                        <div class="loader-indicator blink-animation"></div>
                        <span class="loader-label">Initializing Data Pipelines...</span>
                    </div>
                    <div class="loader-progress">
                        <div class="loader-progress-bar"></div>
                    </div>
                </div>
            </div>

            <div class="loader-terminal">
                <div class="terminal-dim">&gt; SYSTEM_BOOT_SEQUENCE_INITIATED</div>
                <div class="terminal-dim">&gt; LOADING_CORE_MODULES_100%</div>
                <div class="terminal-dim">&gt; ALLOCATING_MEMORY_SEGMENTS...</div>
                <div class="terminal-pulse">&gt; ESTABLISHING_SECURE_CONNECTION</div>
            </div>
        </div>

        @inertia
    </body>
</html>

