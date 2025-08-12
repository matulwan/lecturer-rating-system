<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="min-h-screen p-4 md:p-6 max-w-4xl mx-auto">
        <!-- Header with theme toggle -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white animate-fade-in">Student Portal</h1>
            <button id="theme-toggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:block"></i>
            </button>
        </div>

        <!-- Welcome message -->
        <div class="mb-8 animate-slide-up">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-700 dark:text-gray-200">Hi, Ulwan!</h2>
            <p class="text-gray-500 dark:text-gray-400">Welcome back to your student dashboard</p>
        </div>

        <!-- Action buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 animate-slide-up">
            <button id="evaluation-btn" class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow flex items-center justify-between border-l-4 border-blue-500">
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-white">Lecturer Evaluation Form</h3>
                    
                </div>
                <span class="text-green-500" id="evaluation-status"><i class="fas fa-check-circle"></i></span>
            </button>

            <button id="survey-btn" class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow flex items-center justify-between border-l-4 border-purple-500">
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-white">End of Course Survey</h3>
                    
                </div>
                <span class="text-red-500" id="survey-status"><i class="fas fa-times-circle"></i></span>
            </button>
        </div>

        <!-- Lecturers by semester -->
        <div class="mb-8 animate-fade-in">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Your Lecturers</h2>
            
            <!-- Semester 1 -->
            <div class="mb-6">
                <div class="flex items-center mb-3">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Semester 1</h3>
                    <span class="ml-2 px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">3 lecturers</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div class="bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-500 dark:text-blue-300"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Dr. Sarah Johnson</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Computer Science</p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow flex items-center">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-green-500 dark:text-green-300"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Prof. Michael Chen</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Mathematics</p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow flex items-center">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-purple-500 dark:text-purple-300"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Dr. Emily Wilson</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Physics</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty semesters (would be hidden if no lecturers) -->
            <div class="mb-6 hidden">
                <div class="flex items-center mb-3">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Semester 3</h3>
                    <span class="ml-2 px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full">No lecturers</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 italic">No lecturers assigned yet for this semester</p>
            </div>
        </div>
    </div>

    <script>
        // Theme toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }

        // Button click handlers with SweetAlert
        document.getElementById('evaluation-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Lecturer Evaluation',
                text: 'Would you like to complete the lecturer evaluation form?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Start Evaluation',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3B82F6',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#000000',
            }).then((result) => {
                if (result.isConfirmed) {
                    // In a real app, this would redirect to the evaluation form
                    document.getElementById('evaluation-status').innerHTML = '<i class="fas fa-check-circle"></i>';
                    document.getElementById('evaluation-status').classList.remove('text-red-500');
                    document.getElementById('evaluation-status').classList.add('text-green-500');
                    
                    Swal.fire({
                        title: 'Evaluation Submitted!',
                        text: 'Thank you for your feedback.',
                        icon: 'success',
                        confirmButtonColor: '#3B82F6',
                        background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                        color: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#000000',
                    });
                }
            });
        });

        document.getElementById('survey-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Course Survey',
                text: 'Would you like to complete the end of course survey?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Start Survey',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#8B5CF6',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#000000',
            }).then((result) => {
                if (result.isConfirmed) {
                    // In a real app, this would redirect to the survey form
                    document.getElementById('survey-status').innerHTML = '<i class="fas fa-check-circle"></i>';
                    document.getElementById('survey-status').classList.remove('text-red-500');
                    document.getElementById('survey-status').classList.add('text-green-500');
                    
                    Swal.fire({
                        title: 'Survey Submitted!',
                        text: 'Your feedback is valuable to us.',
                        icon: 'success',
                        confirmButtonColor: '#8B5CF6',
                        background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                        color: document.documentElement.classList.contains('dark') ? '#FFFFFF' : '#000000',
                    });
                }
            });
        });
    </script>
</body>
</html>