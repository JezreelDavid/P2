<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate ticket code
    $ticketCode = generateTicketCode();
    
    // Get form data
    $paymentDetails = [
        'user_id' => $_SESSION['user_id'],
        'payment_method' => $_POST['payment_method'],
        'amount' => $_POST['amount'],
        'service' => $_POST['service'],
        'email' => $_POST['email']
    ];
    
    // Save to database
    if (savePayment(
        $paymentDetails['user_id'],
        $ticketCode,
        $paymentDetails['payment_method'],
        $paymentDetails['amount'],
        $paymentDetails['service']
    )) {
        // Send email
        sendTicketEmail($paymentDetails['email'], $ticketCode, $paymentDetails);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'ticket_code' => $ticketCode
        ]);
        exit;
    }
    
    // Return error response if save failed
    echo json_encode(['success' => false]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Animation library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
         x-data="{ step: 1, payment_method: '' }">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <!-- Progress Bar -->
            <div class="relative pt-1">
                <div class="flex mb-2 items-center justify-between">
                    <div class="flex items-center">
                        <span :class="{ 'bg-green-600': step >= 1, 'bg-gray-200': step < 1 }"
                              class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold transition-all duration-300">
                            1
                        </span>
                        <div class="ml-2">
                            <span class="text-sm font-medium" :class="{ 'text-green-600': step >= 1 }">Payment Method</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span :class="{ 'bg-green-600': step >= 2, 'bg-gray-200': step < 2 }"
                              class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold transition-all duration-300">
                            2
                        </span>
                        <div class="ml-2">
                            <span class="text-sm font-medium" :class="{ 'text-green-600': step >= 2 }">Details</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span :class="{ 'bg-green-600': step >= 3, 'bg-gray-200': step < 3 }"
                              class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold transition-all duration-300">
                            3
                        </span>
                        <div class="ml-2">
                            <span class="text-sm font-medium" :class="{ 'text-green-600': step >= 3 }">Review</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-green-600 transition-all duration-500"
                         :style="{ width: (step === 1) ? '33%' : (step === 2) ? '66%' : '100%' }"></div>
                </div>
            </div>

            <!-- Step 1: Payment Method -->
            <div x-show="step === 1" 
                 class="animate__animated animate__fadeIn">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Select Payment Method
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Choose your preferred payment option
                    </p>
                </div>
                
                <div class="mt-8 space-y-4">
                    <!-- GCash Option -->
                    <div class="transform transition-all duration-300 hover:scale-[1.02]">
                        <div class="flex items-center p-4 border rounded-lg hover:bg-gray-50 hover:border-green-500 cursor-pointer">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="gcash" 
                                   id="gcash" 
                                   x-model="payment_method"
                                   class="h-4 w-4 text-green-600">
                            <label for="gcash" class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-gray-900">GCash</span>
                                <span class="block text-sm text-gray-500">Pay using your GCash wallet</span>
                            </label>
                        </div>
                    </div>

                    <!-- Cash on Hand Option -->
                    <div class="transform transition-all duration-300 hover:scale-[1.02]">
                        <div class="flex items-center p-4 border rounded-lg hover:bg-gray-50 hover:border-green-500 cursor-pointer">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="cash" 
                                   id="cash" 
                                   x-model="payment_method"
                                   class="h-4 w-4 text-green-600">
                            <label for="cash" class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-gray-900">Cash on Hand</span>
                                <span class="block text-sm text-gray-500">Pay with cash upon delivery/transaction</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button @click="step = 2" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02]">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 2: Payment Details -->
            <div x-show="step === 2"
                 class="animate__animated animate__fadeIn">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Payment Details
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please fill in your payment information
                    </p>
                </div>

                <form class="mt-8 space-y-6" action="#" method="POST" id="paymentForm">
                    <!-- Add hidden input for service_type -->
                    <input type="hidden" name="service_type" value="wedding">
                    
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <!-- GCash-specific fields -->
                        <template x-if="payment_method === 'gcash'">
                            <div class="space-y-4">
                                <div>
                                    <label for="gcash_number" class="block text-sm font-medium text-gray-700">GCash Number</label>
                                    <input type="tel" id="gcash_number" name="gcash_number" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="gcash_message" class="block text-sm font-medium text-gray-700">Message/Note (Optional)</label>
                                    <textarea id="gcash_message" name="gcash_message" rows="3"
                                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                              placeholder="Add any additional information or special instructions"></textarea>
                                </div>
                            </div>
                        </template>

                        <!-- Cash on Hand-specific fields -->
                        <template x-if="payment_method === 'cash'">
                            <div class="space-y-4">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Complete Address</label>
                                    <input type="text" id="address" name="address" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                                    <input type="text" id="barangay" name="barangay" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="landmark" class="block text-sm font-medium text-gray-700">Landmark</label>
                                    <input type="text" id="landmark" name="landmark" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>
                        </template>

                        <!-- Service Selection -->
                        <div>
                            <label for="service" class="block text-sm font-medium text-gray-700">Select Service</label>
                            <select id="service" name="service" required
                                    onchange="updateAmount(this.value)"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                <option value="">Choose a service</option>
                                <optgroup label="Baptismal">
                                    <option value="StIgnatiusOfLoyolaParish">St. Ignatius of Loyola Parish (Ususan, Taguig)</option>
                                    <option value="StMichaelTheArchangelParish">St. Michael the Archangel Parish (BGC, Taguig)</option>
                                    <option value="StoRosarioDePasigParish">Sto. Rosario de Pasig Parish (Rosario, Pasig)</option>
                                    <option value="StaRosaDeLimaParish">Sta. Rosa de Lima Parish (Bagong Ilog, Pasig)</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- Amount Input -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <!-- Currency Symbol -->
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm font-medium">₱</span>
                                </div>
                                
                                <!-- Amount Input -->
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       required
                                       min="0"
                                       class="focus:ring-green-500 focus:border-green-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md
                                              transition-all duration-300 ease-in-out
                                              hover:border-green-300
                                              focus:shadow-lg
                                              placeholder-gray-400"
                                       placeholder="0.00" 
                                       step="0.01">

                                <!-- Currency Code -->
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 sm:text-sm">PHP</span>
                                </div>
                            </div>
                            
                            <!-- Optional: Amount Validation Message -->
                            <p class="mt-1 text-xs text-gray-500">Please enter amount greater than ₱0.00</p>
                            
                            <!-- Optional: Quick Amount Buttons -->
                            <div class="mt-2 flex space-x-2">
                                <button type="button" 
                                        onclick="document.getElementById('amount').value='100'"
                                        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                    ₱100
                                </button>
                                <button type="button"
                                        onclick="document.getElementById('amount').value='500'"
                                        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                    ₱500
                                </button>
                                <button type="button"
                                        onclick="document.getElementById('amount').value='1000'"
                                        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                    ₱1,000
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex space-x-4">
                        <button type="button" @click="step = 1"
                                class="flex-1 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02]">
                            Back
                        </button>
                        <button type="button" @click="step = 3"
                                class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02]">
                            Review Payment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Review Payment -->
            <div x-show="step === 3"
                 class="animate__animated animate__fadeIn">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Review Your Payment
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please review your payment details before proceeding
                    </p>
                </div>

                <div class="mt-8 space-y-6">
                    <!-- Personal Information Review -->
                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Full Name</p>
                                <p class="mt-1 personal-info-name"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 personal-info-email"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Phone</p>
                                <p class="mt-1 personal-info-phone"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Review -->
                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Payment Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Payment Method</p>
                                <p class="mt-1 capitalize payment-method"></p>
                            </div>
                            <template x-if="payment_method === 'gcash'">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">GCash Number</p>
                                    <p class="mt-1 gcash-number"></p>
                                </div>
                            </template>
                            <template x-if="payment_method === 'cash'">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Delivery Address</p>
                                    <p class="mt-1 delivery-address"></p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Service and Amount Review -->
                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Service Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Selected Service</p>
                                <p class="mt-1 selected-service"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Amount</p>
                                <p class="mt-1">₱<span class="amount-value"></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex space-x-4">
                        <button type="button" @click="step = 2"
                                class="flex-1 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02]">
                            Back
                        </button>
                        <button type="submit"
                                class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02]">
                            Confirm Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script before closing body tag -->
    <script>
        function updateAmount(service) {
            const amounts = {
                'StIgnatiusOfLoyolaParish': 20000,
                'StMichaelTheArchangelParish': 20000,
                'StoRosarioDePasigParish': 20000,
                'StaRosaDeLimaParish': 20000
            };
            
            if (service in amounts) {
                document.getElementById('amount').value = amounts[service];
            }
        }

        // Add this function to update review details
        function updateReviewDetails() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const service = document.getElementById('service');
            const serviceName = service.options[service.selectedIndex].text;
            const amount = document.getElementById('amount').value;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            // Update personal information
            document.querySelector('[x-show="step === 3"] .personal-info-name').textContent = name;
            document.querySelector('[x-show="step === 3"] .personal-info-email').textContent = email;
            document.querySelector('[x-show="step === 3"] .personal-info-phone').textContent = phone;

            // Update payment details
            document.querySelector('[x-show="step === 3"] .payment-method').textContent = paymentMethod;
            if (paymentMethod === 'gcash') {
                document.querySelector('[x-show="step === 3"] .gcash-number').textContent = 
                    document.getElementById('gcash_number').value;
            } else {
                document.querySelector('[x-show="step === 3"] .delivery-address').textContent = 
                    `${document.getElementById('address').value}, ${document.getElementById('barangay').value}`;
            }

            // Update service details
            document.querySelector('[x-show="step === 3"] .selected-service').textContent = serviceName;
            document.querySelector('[x-show="step === 3"] .amount-value').textContent = amount;
        }

        // Modify the existing submit handler
        document.getElementById('paymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            updateReviewDetails();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('process_payment.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Show success message and ticket code
                    const ticketCodeHtml = `
                        <div class="bg-green-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-medium text-green-900">Payment Successful</h3>
                            <p class="mt-2 text-sm text-green-600">
                                Your ticket code: <strong>${result.ticket_code}</strong>
                            </p>
                            <p class="mt-1 text-sm text-green-500">
                                A confirmation email has been sent to your email address.
                            </p>
                        </div>
                    `;
                    
                    document.querySelector('[x-show="step === 3"]')
                        .insertAdjacentHTML('afterbegin', ticketCodeHtml);
                        
                    // Disable the confirm payment button
                    document.querySelector('button[type="submit"]').disabled = true;
                } else {
                    alert('There was an error processing your payment. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('There was an error processing your payment. Please try again.');
            }
        });
    </script>
</body>
</html>