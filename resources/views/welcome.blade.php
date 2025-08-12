<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Rating System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { 
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            'from': { opacity: '0' },
                            'to': { opacity: '1' }
                        },
                        slideUp: {
                            'from': { 
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            'to': { 
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-slate-900 dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col">
    <!-- Dark mode toggle -->
    <div class="absolute top-6 right-6">
        <button id="theme-toggle" class="p-2 rounded-full bg-white/80 dark:bg-slate-700/80 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-110">
            <svg id="theme-icon-light" class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
            </svg>
            <svg id="theme-icon-dark" class="w-5 h-5 text-blue-400 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
        </button>
    </div>

    <main class="flex-grow flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <!-- Logo with animation -->
            <div class="flex justify-center animate-fade-in">
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 dark:from-blue-700 dark:to-blue-600 text-white p-5 rounded-xl shadow-lg hover:rotate-6 hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            
            <!-- Headline with animation -->
            <div class="animate-slide-up" style="animation-delay: 0.2s;">
                <h1 class="text-4xl font-bold sm:text-5xl bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400 dark:from-blue-400 dark:to-blue-300">
                    Welcome to Lecturer Rating System
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300 opacity-0 animate-[fadeIn_0.8s_ease-in-out_0.4s_forwards]">
                    Evaluate lecturers, give feedback, and improve learning outcomes.
                </p>
            </div>
            
            <!-- Login button with animation -->
            <div class="opacity-0 animate-[fadeIn_0.8s_ease-in-out_0.6s_forwards]">
                <a href="/login" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 dark:from-blue-700 dark:to-blue-600 dark:hover:from-blue-600 dark:hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-6 w-6 text-blue-200 group-hover:text-blue-100 dark:text-blue-300 dark:group-hover:text-blue-200 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Login to Your Account
                </a>
            </div>
            
            <!-- Info card with animation -->
            <div class="mt-8 bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm p-6 rounded-xl shadow-sm border border-white/80 dark:border-slate-700/80 opacity-0 animate-[fadeIn_0.8s_ease-in-out_0.8s_forwards]">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-blue-500 dark:text-blue-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-left text-blue-700 dark:text-blue-300">
                        Help enhance education quality by providing constructive feedback about your lecturers.
                    </p>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer with animation -->
    <footer class="py-6 opacity-0 animate-[fadeIn_1s_ease-in-out_1s_forwards]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                © 2025 Lecturer Rating System. Developed by Ulwan.
            </p>
        </div>
    </footer>

    <script>
        // Dark mode toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeIconLight = document.getElementById('theme-icon-light');
        const themeIconDark = document.getElementById('theme-icon-dark');
        const html = document.documentElement;

        // Check for saved theme preference or use system preference
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeIconLight.classList.add('hidden');
            themeIconDark.classList.remove('hidden');
        } else {
            html.classList.remove('dark');
            themeIconLight.classList.remove('hidden');
            themeIconDark.classList.add('hidden');
        }

        // Toggle theme on button click
        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                themeIconLight.classList.add('hidden');
                themeIconDark.classList.remove('hidden');
            } else {
                localStorage.setItem('theme', 'light');
                themeIconLight.classList.remove('hidden');
                themeIconDark.classList.add('hidden');
            }
        });
    </script>
</body>
</html>