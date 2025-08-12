<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <div class="flex min-h-screen">
        <!-- Sidebar removed -->
        
        <!-- Main content -->
        <div class="flex-1 overflow-auto w-full">
            <div class="p-4 md:p-6">
                <!-- Header -->
                <header class="flex justify-between items-center mb-8 relative">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Welcome, <span class="text-blue-600 dark:text-blue-400">Ts. Anwar</span>!</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Admin Dashboard</p>
                    </div>
                    <div class="absolute right-0 top-0 flex items-center space-x-4">
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

                <!-- Mobile menu button and menu removed -->

                <!-- Student Management Section -->
                <section id="student-management" class="mb-10">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Student Accounts</h2>
                        <div class="flex gap-2">
                            <button onclick="openModal('addStudentModal')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Add Student</button>
                            <label class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 cursor-pointer">
                                Import Excel
                                <input type="file" id="studentsImportInput" accept=".xlsx,.xls,.csv" class="hidden" onchange="importStudents(this)">
                            </label>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                                <div class="relative w-full md:w-64">
                                    <input id="studentsSearchInput" type="text" placeholder="Search students..." class="w-full pl-10 pr-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex space-x-2">
                                    <select id="studentsSemesterFilter" class="px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                        <option value="all">All Semesters</option>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="studentsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IC Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Semester</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- JavaScript will populate this -->
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-600">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p id="studentsCountText" class="text-sm text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <nav id="studentsPagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination"></nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Lecturer Management Section -->
                <section id="lecturer-management" class="mb-10">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Lecturer Accounts</h2>
                        <div class="flex gap-2">
                            <button onclick="openModal('addLecturerModal')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Add Lecturer</button>
                            <label class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 cursor-pointer">
                                Import Excel
                                <input type="file" id="lecturersImportInput" accept=".xlsx,.xls,.csv" class="hidden" onchange="importLecturers(this)">
                            </label>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                                <div class="relative w-full md:w-64">
                                    <input id="lecturersSearchInput" type="text" placeholder="Search lecturers..." class="w-full pl-10 pr-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="lecturersTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IC Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Salary Number</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4"></td>
                                        <td class="px-6 py-4"></td>
                                        <td class="px-6 py-4"></td>
                                        <td class="px-6 py-4 text-right">
                                            <button onclick="editLecturer(1)" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 mr-3">Edit</button>
                                            <button onclick="deleteLecturer(1)" class="text-red-600 dark:text-red-400 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-600">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p id="lecturersCountText" class="text-sm text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <nav id="lecturersPagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination"></nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Analytics Overview Section -->
                <section id="analytics" class="mb-10">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Analytics Overview</h2>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                                <div class="flex space-x-2">
                                    <select class="px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                        <option>All Lecturers</option>
                                        <option>Dr. Ahmad Faisal</option>
                                        <option>Prof. Siti Nurhaliza</option>
                                        <option>Dr. Rajesh Kumar</option>
                                    </select>
                                    <select class="px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                        <option>All Courses</option>
                                        <option>DFD40153 - Internet of Things I</option>
                                        <option>DFC50123 - Cloud Computing</option>
                                    </select>
                                    <select class="px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                        <option>All Semesters</option>
                                        <option>Semester 1</option>
                                        <option>Semester 2</option>
                                        <option>Semester 3</option>
                                        <option>Semester 4</option>
                                        <option>Semester 5</option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                        Apply Filters
                                    </button>
                                    <button class="px-3 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lecturer</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Semester</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Evaluation Avg</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Survey Avg</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Responses</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">Dr. Ahmad Faisal</td>
                                            <td class="px-6 py-4 whitespace-nowrap">DFD40153</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Semester 1</td>
                                            <td class="px-6 py-4 whitespace-nowrap">4.3/5.0</td>
                                            <td class="px-6 py-4 whitespace-nowrap">88%</td>
                                            <td class="px-6 py-4 whitespace-nowrap">32</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">Dr. Ahmad Faisal</td>
                                            <td class="px-6 py-4 whitespace-nowrap">DFD40153</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Semester 4</td>
                                            <td class="px-6 py-4 whitespace-nowrap">4.1/5.0</td>
                                            <td class="px-6 py-4 whitespace-nowrap">85%</td>
                                            <td class="px-6 py-4 whitespace-nowrap">28</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">Dr. Ahmad Faisal</td>
                                            <td class="px-6 py-4 whitespace-nowrap">DFC50123</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Semester 3</td>
                                            <td class="px-6 py-4 whitespace-nowrap">4.5/5.0</td>
                                            <td class="px-6 py-4 whitespace-nowrap">92%</td>
                                            <td class="px-6 py-4 whitespace-nowrap">35</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Add New Student</h3>
                    <button onclick="closeModal('addStudentModal')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form onsubmit="addStudent(event)" id="addStudentForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="student_name" class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" id="student_name" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="ic_number" class="block text-sm font-medium mb-1">IC Number</label>
                        <input type="text" id="ic_number" required placeholder="e.g. 050221030621" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium mb-1">Semester</label>
                        <select id="semester" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" onclick="closeModal('addStudentModal')" class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    <!-- Add Lecturer Modal -->
    <div id="addLecturerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Add New Lecturer</h3>
                    <button onclick="closeModal('addLecturerModal')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form onsubmit="addLecturer(event)" id="addLecturerForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="lecturer_name" class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" id="lecturer_name" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="lecturer_ic_number" class="block text-sm font-medium mb-1">IC Number</label>
                        <input type="text" id="lecturer_ic_number" required placeholder="e.g. 050221030621" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="salary_number" class="block text-sm font-medium mb-1">Salary Number</label>
                        <input type="text" id="salary_number" required placeholder="e.g. EMP12345" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" onclick="closeModal('addLecturerModal')" class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Lecturer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editStudentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Edit Student</h3>
                    <button onclick="closeModal('editStudentModal')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" value="Ahmad bin Ali" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Matrix Number</label>
                        <input type="text" value="01DDT20F1001" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">IC Number</label>
                        <input type="text" value="010101-01-0101" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Will be used as password</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Semester</label>
                        <select class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <option selected>Semester 1</option>
                            <option>Semester 2</option>
                            <option>Semester 3</option>
                            <option>Semester 4</option>
                            <option>Semester 5</option>
                        </select>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button onclick="closeModal('editStudentModal')" class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Lecturer Modal -->
    <div id="editLecturerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Edit Lecturer</h3>
                    <button onclick="closeModal('editLecturerModal')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" value="Dr. Ahmad Faisal" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">IC Number</label>
                        <input type="text" value="700101-01-1234" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Will be used as password</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Salary Number</label>
                        <input type="text" value="EMP12345" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button onclick="closeModal('editLecturerModal')" class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
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

        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                document.querySelectorAll('.fixed').forEach(modal => {
                    modal.classList.add('hidden');
                });
            }
        }

        // Pagination settings
        const PAGE_SIZE = 5; // Changed from 10 to 5
        let studentsData = [];
        let studentsCurrentPage = 1;
        let lecturersData = [];
        let lecturersCurrentPage = 1;
    
        function studentsGoPrev() {
            if (studentsCurrentPage > 1) {
                studentsCurrentPage--;
                renderStudents();
            }
        }
    
        function studentsGoNext() {
            const totalPages = Math.max(1, Math.ceil(studentsData.length / PAGE_SIZE));
            if (studentsCurrentPage < totalPages) {
                studentsCurrentPage++;
                renderStudents();
            }
        }
    
        function renderStudents() {
            const tbody = document.querySelector('#studentsTable tbody');
            const countText = document.getElementById('studentsCountText');
            const pagination = document.querySelector('#student-management nav[aria-label="Pagination"]');
            tbody.innerHTML = '';
            if (pagination) pagination.innerHTML = '';
    
            // Apply client-side filters
            const search = (document.getElementById('studentsSearchInput')?.value || '').toLowerCase();
            const semVal = document.getElementById('studentsSemesterFilter')?.value || 'all';
            const filtered = studentsData.filter(s => {
                const matchSearch = !search || (s.name?.toLowerCase().includes(search) || s.ic_number?.toLowerCase().includes(search));
                const matchSem = semVal === 'all' || String(s.semester) === semVal;
                return matchSearch && matchSem;
            });

            const total = filtered.length;
            if (total === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No students found</td>
                    </tr>
                `;
                if (countText) countText.textContent = 'Showing 0 results';
                return;
            }
    
            const totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
            if (studentsCurrentPage > totalPages) studentsCurrentPage = totalPages;
    
            const startIndex = (studentsCurrentPage - 1) * PAGE_SIZE;
            const endIndex = Math.min(total, studentsCurrentPage * PAGE_SIZE);
            const pageItems = filtered.slice(startIndex, endIndex);
    
            pageItems.forEach(student => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">${student.name}</td>
                        <td class="px-6 py-4">${student.ic_number}</td>
                        <td class="px-6 py-4">Semester ${student.semester}</td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="editStudent(${student.id})" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 mr-3">Edit</button>
                            <button onclick="deleteStudent(${student.id})" class="text-red-600 dark:text-red-400 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                `;
            });
    
            if (countText) {
                countText.innerHTML = `Showing <span class="font-medium">${startIndex + 1}</span> to <span class="font-medium">${endIndex}</span> of <span class="font-medium">${total}</span> results`;
            }
    
            if (pagination) {
                const prevDisabled = studentsCurrentPage === 1 ? 'opacity-50 cursor-not-allowed' : '';
                const nextDisabled = studentsCurrentPage === totalPages ? 'opacity-50 cursor-not-allowed' : '';
                pagination.innerHTML = `
                    <a class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 ${prevDisabled}" onclick="studentsGoPrev()">
                        <span class="sr-only">Previous</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                    <span class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">${studentsCurrentPage} / ${totalPages}</span>
                    <a class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 ${nextDisabled}" onclick="studentsGoNext()">
                        <span class="sr-only">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                `;
            }
        }
    
        function lecturersGoPrev() {
            if (lecturersCurrentPage > 1) {
                lecturersCurrentPage--;
                renderLecturers();
            }
        }
    
        function lecturersGoNext() {
            const totalPages = Math.max(1, Math.ceil(lecturersData.length / PAGE_SIZE));
            if (lecturersCurrentPage < totalPages) {
                lecturersCurrentPage++;
                renderLecturers();
            }
        }
    
        function renderLecturers() {
            const tbody = document.querySelector('#lecturersTable tbody');
            const countText = document.getElementById('lecturersCountText');
            const pagination = document.querySelector('#lecturer-management nav[aria-label="Pagination"]');
            tbody.innerHTML = '';
            if (pagination) pagination.innerHTML = '';
    
            const search = (document.getElementById('lecturersSearchInput')?.value || '').toLowerCase();
            const filtered = lecturersData.filter(l => {
                return !search || (l.name?.toLowerCase().includes(search) || l.ic_number?.toLowerCase().includes(search) || l.salary_number?.toLowerCase().includes(search));
            });

            const total = filtered.length;
            if (total === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No lecturers found</td>
                    </tr>
                `;
                if (countText) countText.textContent = 'Showing 0 results';
                return;
            }
    
            const totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
            if (lecturersCurrentPage > totalPages) lecturersCurrentPage = totalPages;
    
            const startIndex = (lecturersCurrentPage - 1) * PAGE_SIZE;
            const endIndex = Math.min(total, lecturersCurrentPage * PAGE_SIZE);
            const pageItems = filtered.slice(startIndex, endIndex);
    
            pageItems.forEach(lecturer => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">${lecturer.name}</td>
                        <td class="px-6 py-4">${lecturer.ic_number}</td>
                        <td class="px-6 py-4">${lecturer.salary_number}</td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="editLecturer(${lecturer.id})" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 mr-3">Edit</button>
                            <button onclick="deleteLecturer(${lecturer.id})" class="text-red-600 dark:text-red-400 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                `;
            });
    
            if (countText) {
                countText.innerHTML = `Showing <span class="font-medium">${startIndex + 1}</span> to <span class="font-medium">${endIndex}</span> of <span class="font-medium">${total}</span> results`;
            }
    
            if (pagination) {
                const prevDisabled = lecturersCurrentPage === 1 ? 'opacity-50 cursor-not-allowed' : '';
                const nextDisabled = lecturersCurrentPage === totalPages ? 'opacity-50 cursor-not-allowed' : '';
                pagination.innerHTML = `
                    <a class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 ${prevDisabled}" onclick="lecturersGoPrev()">
                        <span class="sr-only">Previous</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                    <span class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">${lecturersCurrentPage} / ${totalPages}</span>
                    <a class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 ${nextDisabled}" onclick="lecturersGoNext()">
                        <span class="sr-only">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                `;
            }
        }

// Student functions
        function importStudents(input) {
            const file = input.files && input.files[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('file', file);

            fetch('/admin/students/import', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (!res.success) {
                    alert(res.message || 'Import failed');
                    return;
                }
                const s = res.summary || {};
                alert(`Students import completed.\nTotal: ${s.total_rows || 0}\nCreated: ${s.created || 0}\nSkipped: ${s.skipped || 0}\nErrors: ${(s.errors || []).length}`);
                loadStudents();
                input.value = '';
            })
            .catch(err => {
                console.error(err);
                alert('Import failed');
                input.value = '';
            });
        }
function addStudent(event) {
    event.preventDefault();
    
    const submitBtn = event.target.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding...';
    
    const formData = {
        name: document.getElementById('student_name').value,
        ic_number: document.getElementById('ic_number').value,
        semester: document.getElementById('semester').value,
    };

    fetch('/admin/students', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
                credentials: 'same-origin',
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        alert('Student added successfully!');
        loadStudents();
        document.getElementById('addStudentForm').reset();
        closeModal('addStudentModal');
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            let errorMessage = 'Validation errors:\n';
            Object.keys(error.errors).forEach(key => {
                errorMessage += `${key}: ${error.errors[key].join(', ')}\n`;
            });
            alert(errorMessage);
        } else {
            alert('Error adding student: ' + (error.message || 'Unknown error'));
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Add Student';
    });
}

function editStudent(id) {
            fetch(`/admin/students/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const student = data.data;
                
                // Create a new edit modal content with the student data
                const modal = document.getElementById('editStudentModal');
                const form = modal.querySelector('.space-y-4');
                
                form.innerHTML = `
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" id="edit_student_name" value="${student.name}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">IC Number</label>
                        <input type="text" id="edit_ic_number" value="${student.ic_number}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Will be used as password</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Semester</label>
                        <select id="edit_semester" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            <option value="1" ${student.semester == 1 ? 'selected' : ''}>Semester 1</option>
                            <option value="2" ${student.semester == 2 ? 'selected' : ''}>Semester 2</option>
                            <option value="3" ${student.semester == 3 ? 'selected' : ''}>Semester 3</option>
                            <option value="4" ${student.semester == 4 ? 'selected' : ''}>Semester 4</option>
                            <option value="5" ${student.semester == 5 ? 'selected' : ''}>Semester 5</option>
                        </select>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button onclick="closeModal('editStudentModal')" type="button" class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button onclick="updateStudent(${id})" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Save Changes
                        </button>
                    </div>
                `;
                
                openModal('editStudentModal');
            }
        })
        .catch(error => {
            console.error('Error fetching student data:', error);
            alert('Error loading student data');
        });
}

function updateStudent(id) {
    const formData = {
        name: document.getElementById('edit_student_name').value,
        ic_number: document.getElementById('edit_ic_number').value,
        semester: document.getElementById('edit_semester').value
    };

    fetch(`/admin/students/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
                credentials: 'same-origin',
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        alert('Student updated successfully!');
        loadStudents();
        closeModal('editStudentModal');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating student');
    });
}

function deleteStudent(id) {
    if(confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
        fetch(`/admin/students/${id}`, {
            method: 'DELETE',
            headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            alert('Student deleted successfully!');
            loadStudents();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting student');
        });
    }
}

function loadStudents() {
            fetch('/admin/students', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
        .then(response => response.json())
        .then(students => {
                    studentsData = students; // Store the data for pagination
                    renderStudents();
        })
        .catch(error => {
            console.error('Error loading students:', error);
            const tbody = document.querySelector('#studentsTable tbody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-red-500">Error loading students</td>
                </tr>
            `;
                    const countText = document.getElementById('studentsCountText');
                    if (countText) {
                        countText.textContent = 'Error loading results';
                    }
        });
}

// Lecturer functions
        function importLecturers(input) {
            const file = input.files && input.files[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('file', file);

            fetch('/admin/lecturers/import', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (!res.success) {
                    alert(res.message || 'Import failed');
                    return;
                }
                const s = res.summary || {};
                alert(`Lecturers import completed.\nTotal: ${s.total_rows || 0}\nCreated: ${s.created || 0}\nSkipped: ${s.skipped || 0}\nErrors: ${(s.errors || []).length}`);
                loadLecturers();
                input.value = '';
            })
            .catch(err => {
                console.error(err);
                alert('Import failed');
                input.value = '';
            });
        }
function addLecturer(event) {
    event.preventDefault();
    
    const submitBtn = event.target.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding...';
    
    const formData = {
        name: document.getElementById('lecturer_name').value,
        ic_number: document.getElementById('lecturer_ic_number').value,
        salary_number: document.getElementById('salary_number').value,
    };

    fetch('/admin/lecturers', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
                credentials: 'same-origin',
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        alert('Lecturer added successfully!');
        loadLecturers();
        document.getElementById('addLecturerForm').reset();
        closeModal('addLecturerModal');
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            let errorMessage = 'Validation errors:\n';
            Object.keys(error.errors).forEach(key => {
                errorMessage += `${key}: ${error.errors[key].join(', ')}\n`;
            });
            alert(errorMessage);
        } else {
            alert('Error adding lecturer: ' + (error.message || 'Unknown error'));
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Add Lecturer';
    });
}

function editLecturer(id) {
            fetch(`/admin/lecturers/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const lecturer = data.data;
                
                const modal = document.getElementById('editLecturerModal');
                const form = modal.querySelector('.space-y-4');
                
                form.innerHTML = `
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" id="edit_lecturer_name" value="${lecturer.name}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">IC Number</label>
                        <input type="text" id="edit_lecturer_ic_number" value="${lecturer.ic_number}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Will be used as password</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Salary Number</label>
                        <input type="text" id="edit_lecturer_salary_number" value="${lecturer.salary_number}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button onclick="closeModal('editLecturerModal')" type="button" class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button onclick="updateLecturer(${id})" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Save Changes
                        </button>
                    </div>
                `;
                
                openModal('editLecturerModal');
            }
        })
        .catch(error => {
            console.error('Error fetching lecturer data:', error);
            alert('Error loading lecturer data');
        });
}

function updateLecturer(id) {
    const formData = {
        name: document.getElementById('edit_lecturer_name').value,
        ic_number: document.getElementById('edit_lecturer_ic_number').value,
        salary_number: document.getElementById('edit_lecturer_salary_number').value
    };

    fetch(`/admin/lecturers/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
                credentials: 'same-origin',
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        alert('Lecturer updated successfully!');
        loadLecturers();
        closeModal('editLecturerModal');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating lecturer');
    });
}

function deleteLecturer(id) {
    if(confirm('Are you sure you want to delete this lecturer? This action cannot be undone.')) {
        fetch(`/admin/lecturers/${id}`, {
            method: 'DELETE',
            headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            alert('Lecturer deleted successfully!');
            loadLecturers();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting lecturer');
        });
    }
}

function loadLecturers() {
            fetch('/admin/lecturers', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
        .then(response => response.json())
        .then(lecturers => {
                    lecturersData = lecturers; // Store the data for pagination
                    renderLecturers();
        })
        .catch(error => {
            console.error('Error loading lecturers:', error);
            const tbody = document.querySelector('#lecturersTable tbody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-red-500">Error loading lecturers</td>
                </tr>
            `;
                    const countText = document.getElementById('lecturersCountText');
                    if (countText) {
                        countText.textContent = 'Error loading results';
                    }
        });
}

        // Load data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadStudents();
            loadLecturers();

            // Wire up search and filter events (with simple debounce)
            let t1, t2;
            const sSearch = document.getElementById('studentsSearchInput');
            const sSem = document.getElementById('studentsSemesterFilter');
            if (sSearch) sSearch.addEventListener('input', () => { clearTimeout(t1); t1 = setTimeout(() => { studentsCurrentPage = 1; renderStudents(); }, 200); });
            if (sSem) sSem.addEventListener('change', () => { studentsCurrentPage = 1; renderStudents(); });

            const lSearch = document.getElementById('lecturersSearchInput');
            if (lSearch) lSearch.addEventListener('input', () => { clearTimeout(t2); t2 = setTimeout(() => { lecturersCurrentPage = 1; renderLecturers(); }, 200); });
        });
    </script>
</body>
</html>