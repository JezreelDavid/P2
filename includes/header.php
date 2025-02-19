<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Diocese Of Pasig</title>
    <link rel="icon" href="/img/Coat_of_arms_of_the_Diocese_of_Pasig.svg (1).png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-md fixed w-full top-0 z-50">
        <nav class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center space-x-3">
                        <img src="assets/img/Coat_of_arms_of_the_Diocese_of_Pasig.svg (1).png" 
                             alt="Diocese Logo" 
                             class="h-12 w-auto">
                        <h1 class="text-lg font-bold text-gray-800 hidden md:block">
                            ROMAN CATHOLIC DIOCESAN PASIG
                        </h1>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" class="hamburger p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex md:items-center md:space-x-6">
                    <a href="#DIOCESE" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">THE DIOCESE</a>
                    <a href="#NEWS" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">NEWS</a>
                    <a href="#SERVICES" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">SERVICES</a>
                    <a href="#CERTIFICATES" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">CERTIFICATES</a>
                    <a href="#STORE" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">STORE</a>
                    <a href="#CHANCERY" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">CHANCERY</a>

                    <!-- User Authentication Section -->
                    <?php if (isset($_SESSION['auth_user'])) : ?>
                    <div class="relative ml-3">
                        <button type="button" 
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 focus:outline-none"
                                id="user-menu-button"
                                aria-expanded="false">
                            <span class="sr-only">Open user menu</span>
                            <span><?= $_SESSION['auth_user']['user_name']; ?></span>
                            <svg class="ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu"
                             id="user-menu-dropdown">
                            <a href="/profile.php" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
                            <form action="allcode.php" method="POST">
                                <button type="submit" 
                                        name="logout_btn"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php else : ?>
                    <div class="flex items-center space-x-4">
                        <a href="../register.php" 
                           class="text-blue-600 hover:text-blue-700 px-4 py-2 text-sm font-medium border border-blue-600 rounded-md hover:bg-blue-50">
                            Register
                        </a>
                        <a href="../login.php" 
                           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 text-sm font-medium rounded-md">
                            Login
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="hidden mobile-menu md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="#DIOCESE" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">THE DIOCESE</a>
                    <a href="#NEWS" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">NEWS</a>
                    <a href="#SERVICES" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">SERVICES</a>
                    <a href="#CERTIFICATES" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">CERTIFICATES</a>
                    <a href="#STORE" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">STORE</a>
                    <a href="#CHANCERY" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">CHANCERY</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Add necessary spacing for fixed header -->
    <div class="h-20"></div>

    <script>
        // Toggle mobile menu
        document.querySelector('.hamburger').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });

        // Toggle user dropdown
        document.querySelector('#user-menu-button')?.addEventListener('click', function() {
            document.querySelector('#user-menu-dropdown').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#user-menu-button')) {
                document.querySelector('#user-menu-dropdown')?.classList.add('hidden');
            }
        });
    </script>
</body>
</html>