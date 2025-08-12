<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    transitionProperty: {
                        'width': 'width',
                        'height': 'height'
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <div class="min-h-screen p-4 md:p-6">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">Welcome, <span class="text-blue-600 dark:text-blue-400">Dr. Ahmad Faisal</span>!</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Lecturer Dashboard</p>
            </div>
            <div class="flex items-center space-x-4">
                <button id="print-btn" class="hidden md:flex items-center px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                    Print
                </button>
                <button id="theme-toggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:hidden" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Analytics Cards Section -->
        <section class="mb-10">
            <h2 class="text-xl font-semibold mb-4">Evaluation Analytics</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Lecturer Evaluation Card -->
                <a href="/lecturer-evaluation" class="group">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all hover:shadow-lg hover:-translate-y-1 h-full">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4 group-hover:rotate-6 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium">Lecturer Evaluation</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Student feedback on teaching and learning</p>
                        <div class="flex justify-between text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Average Rating</p>
                                <p class="text-xl font-bold">4.3<span class="text-sm text-gray-500">/5.0</span></p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Responses</p>
                                <p class="text-xl font-bold">48</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Last Updated</p>
                                <p class="text-xl font-bold">2d</p>
                            </div>
                        </div>
                    </div>
                </a>
                
                <!-- End of Course Survey Card -->
                <a href="/course-survey" class="group">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all hover:shadow-lg hover:-translate-y-1 h-full">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4 group-hover:rotate-6 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium">End of Course Survey</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Student feedback on course completion</p>
                        <div class="flex justify-between text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Satisfaction</p>
                                <p class="text-xl font-bold">89<span class="text-sm text-gray-500">%</span></p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Responses</p>
                                <p class="text-xl font-bold">42</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Last Updated</p>
                                <p class="text-xl font-bold">1w</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Course Management Section -->
        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Course Management</h2>
                <button id="mobile-print-btn" class="md:hidden px-3 py-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                    Print
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Course Card 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-medium">DFD40153 - Internet of Things I</h3>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">Semester 1</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Diploma in Digital Technology</p>
                        <div class="flex justify-between text-sm mb-4">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Students</p>
                                <p>32</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Evaluations</p>
                                <p>28</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Status</p>
                                <p class="text-green-600 dark:text-green-400">Active</p>
                            </div>
                        </div>
                        <a href="/course/DFD40153-s1" class="block w-full py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition-colors">
                            Manage Course
                        </a>
                    </div>
                </div>
                
                <!-- Course Card 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-medium">DFD40153 - Internet of Things I</h3>
                            <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs rounded-full">Semester 4</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Diploma in Digital Technology</p>
                        <div class="flex justify-between text-sm mb-4">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Students</p>
                                <p>28</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Evaluations</p>
                                <p>25</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Status</p>
                                <p class="text-green-600 dark:text-green-400">Active</p>
                            </div>
                        </div>
                        <a href="/course/DFD40153-s4" class="block w-full py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition-colors">
                            Manage Course
                        </a>
                    </div>
                </div>
                
                <!-- Course Card 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-medium">DFC50123 - Cloud Computing</h3>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">Semester 3</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Diploma in Computer Science</p>
                        <div class="flex justify-between text-sm mb-4">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Students</p>
                                <p>35</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Evaluations</p>
                                <p>30</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Status</p>
                                <p class="text-yellow-600 dark:text-yellow-400">Completed</p>
                            </div>
                        </div>
                        <a href="/course/DFC50123-s3" class="block w-full py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition-colors">
                            Manage Course
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        // Print functionality
        const printButtons = [document.getElementById('print-btn'), document.getElementById('mobile-print-btn')];
        
        printButtons.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', () => {
                    window.print();
                });
            }
        });
    </script>
</body>
</html>