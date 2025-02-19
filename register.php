<?php
session_start();

if(isset($_SESSION['auth']))
{
    $_SESSION['message'] = "You are already logged In";
    header("Location: index.php");
    exit(0);
}

include "includes/header.php";
?>

<!-- Add Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen py-12 bg-cover bg-center bg-no-repeat" style="background-image: url('assets/img/pasig.png');">
    <div class="container mx-auto px-4">
        <?php include('message.php'); ?>

        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Register</h2>
                <div class="w-full h-px bg-gray-200 mb-8"></div>

                <form action="registercode.php" method="POST" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 items-center">
                                    <label class="text-gray-700 font-medium">First Name*</label>
                                    <div class="col-span-2">
                                        <input type="text" name="first_name" placeholder="Enter First Name" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 items-center">
                                    <label class="text-gray-700 font-medium">Middle Name*</label>
                                    <div class="col-span-2">
                                        <input type="text" name="middle_name" placeholder="Enter Middle Name" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 items-center">
                                    <label class="text-gray-700 font-medium">Surname*</label>
                                    <div class="col-span-2">
                                        <input required type="text" name="surname" placeholder="Enter Surname" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 items-center">
                                    <label class="text-gray-700 font-medium">Suffix</label>
                                    <div class="col-span-2">
                                        <input type="text" name="suffix" placeholder="Enter Suffix" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <!-- Sex Selection -->
                                <div class="grid grid-cols-3 items-center">
                                    <label class="text-gray-700 font-medium">Sex*</label>
                                    <div class="col-span-2 flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="sex" value="0" class="w-5 h-5 text-blue-600 rounded">
                                            <span class="ml-2">Male</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="sex" value="1" class="w-5 h-5 text-blue-600 rounded">
                                            <span class="ml-2">Female</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="space-y-4">
                                    <div class="grid grid-cols-3 items-center">
                                        <label class="text-gray-700 font-medium">Username*</label>
                                        <div class="col-span-2">
                                            <input required type="text" name="username" placeholder="Enter Username" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 items-center">
                                        <label class="text-gray-700 font-medium">Email*</label>
                                        <div class="col-span-2">
                                            <input required type="email" name="email" placeholder="Enter Email Address" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 items-center">
                                        <label class="text-gray-700 font-medium">Phone*</label>
                                        <div class="col-span-2">
                                            <input required type="text" name="mobile_no" placeholder="Enter Phone Number" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>

                                    <!-- Parish Selection -->
                                    <div class="grid grid-cols-3 items-center">
                                        <label class="text-gray-700 font-medium">Parish*</label>
                                        <div class="col-span-2">
                                            <select name="parish" required 
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">--Select Parish--</option>
                                                <option value="0">St. Ignatius of Loyola Parish (Ususan, Taguig)</option>
                                                <option value="1">St. Michael the Archangel Parish (BGC, Taguig)</option>
                                                <option value="2">Sto. Rosario de Pasig Parish (Rosario, Pasig)</option>
                                                <option value="3">Sta. Rosa de Lima Parish (Bagong Ilog, Pasig)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-700">Address Information</h3>
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Left Address Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Region *</label>
                                        <select name="region" id="region" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                        <input type="hidden" name="region_text" id="region-text" required>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Province *</label>
                                        <select name="province" id="province" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                        <input type="hidden" name="province_text" id="province-text" required>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Street *</label>
                                        <input type="text" name="street_text" id="street-text" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <!-- Right Address Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">City / Municipality *</label>
                                        <select name="city" id="city" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                        <input type="hidden" name="city_text" id="city-text" required>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Barangay *</label>
                                        <select name="barangay" id="barangay" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </select>
                                        <input type="hidden" name="barangay_text" id="barangay-text" required>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Zip Code *</label>
                                        <input required type="text" name="zip" placeholder="Enter Zip Code" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Password *</label>
                                    <input required type="password" name="password" placeholder="Enter Password" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Confirm Password *</label>
                                    <input required type="password" name="confirm_password" placeholder="Confirm Password" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-center space-x-4 mt-8">
                        <button type="submit" name="register_btn" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Register
                        </button>
                        <a href="index.html" 
                           class="px-6 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Keep the original populate function
    function populate(s1,s2) {
        // ... (keep existing JavaScript code)
    }
</script>

<?php include "includes/footer.php"; ?>