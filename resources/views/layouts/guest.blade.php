<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --color-primary: #e74c3c;
                --color-primary-dark: #c0392b;
                --color-secondary: #2c3e50;
                --color-secondary-light: #34495e;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #e74c3c 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            /* Animated background particles */
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: 
                    radial-gradient(circle at 20% 30%, rgba(231, 76, 60, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(231, 76, 60, 0.08) 0%, transparent 50%);
                animation: float 20s ease-in-out infinite;
                pointer-events: none;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
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

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.8s ease-out forwards;
            }

            .animate-fade-in-down {
                animation: fadeInDown 0.8s ease-out forwards;
            }

            /* Container */
            .auth-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem 1rem;
                position: relative;
                z-index: 1;
            }

            /* Brand Logo */
            .brand-section {
                text-align: center;
                margin-bottom: 2.5rem;
                opacity: 0;
            }

            .brand-logo {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
                border-radius: 20px;
                margin-bottom: 1rem;
                box-shadow: 0 10px 30px rgba(231, 76, 60, 0.3);
                transition: transform 0.3s ease;
            }

            .brand-logo:hover {
                transform: translateY(-5px) scale(1.05);
            }

            .brand-logo i {
                font-size: 2.5rem;
                color: white;
            }

            .brand-title {
                font-size: 3rem;
                font-weight: 800;
                color: white;
                letter-spacing: -1px;
                margin-bottom: 0.5rem;
                text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
            }

            .brand-subtitle {
                color: rgba(255, 255, 255, 0.9);
                font-size: 0.95rem;
                font-weight: 400;
            }

            /* Auth Card */
            .auth-card {
                width: 100%;
                max-width: 440px;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 24px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                padding: 2.5rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
                opacity: 0;
            }

            @media (max-width: 640px) {
                .auth-card {
                    padding: 2rem 1.5rem;
                }
            }

            /* Card Header */
            .card-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .card-title {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--color-secondary);
                margin-bottom: 0.5rem;
            }

            .card-title i {
                color: var(--color-primary);
            }

            .card-description {
                color: #6b7280;
                font-size: 0.875rem;
            }

            /* Footer */
            .auth-footer {
                margin-top: 2rem;
                text-align: center;
                opacity: 0;
            }

            .auth-footer p {
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.875rem;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
            }

            ::-webkit-scrollbar-thumb {
                background: var(--color-primary);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: var(--color-primary-dark);
            }

            /* Animation delays */
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            
            <!-- Brand Section -->
            <div class="brand-section animate-fade-in-down">
                <div class="brand-logo">
                    <i class="fas fa-car"></i>
                </div>
                <h1 class="brand-title">RentKu</h1>
                <p class="brand-subtitle">Solusi Perjalanan Anda</p>
            </div>

            <!-- Auth Card -->
            <div class="auth-card animate-fade-in-up delay-200">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="auth-footer animate-fade-in-up delay-300">
                <p>&copy; {{ date('Y') }} RentKu. All rights reserved.</p>
            </div>

        </div>
    </body>
</html>