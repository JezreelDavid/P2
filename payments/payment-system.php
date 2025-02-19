<?php
// payment-system.php
session_start();
require 'dbConnection.php';

// Get services
function getServices($conn) {
    $sql = "SELECT * FROM Services";
    $result = $conn->query($sql);
    $services = array();
    while($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
    return $services;
}

// Get parishes 
function getParishes($conn) {
    $sql = "SELECT * FROM Parishes";
    $result = $conn->query($sql);
    $parishes = array();
    while($row = $result->fetch_assoc()) {
        $parishes[] = $row;
    }
    return $parishes;
}

// Get price for selected service and parish
function getPrice($conn, $service_id, $parish_id) {
    $sql = "SELECT amount FROM Prices WHERE service_id = ? AND parish_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $service_id, $parish_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['amount'];
}

$services = getServices($conn);
$parishes = getParishes($conn);
?>

<!DOCTYPE html>
<html data-theme="light">
<head>
    <title>Church Payment System</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Church Service Payment</h2>
                
                <form id="paymentForm" method="POST" action="process-payment.php">
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text">Select Service</span>
                        </label>
                        <select class="select select-bordered" id="service" name="service_id" required>
                            <option value="">Select a service</option>
                            <?php foreach($services as $service): ?>
                                <option value="<?= $service['service_id'] ?>"><?= $service['service_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-control w-full max-w-xs mt-4">
                        <label class="label">
                            <span class="label-text">Select Parish</span>
                        </label>
                        <select class="select select-bordered" id="parish" name="parish_id" required>
                            <option value="">Select a parish</option>
                            <?php foreach($parishes as $parish): ?>
                                <option value="<?= $parish['parish_id'] ?>"><?= $parish['parish_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-control w-full max-w-xs mt-4">
                        <label class="label">
                            <span class="label-text">Amount</span>
                        </label>
                        <input type="text" id="amount" name="amount" class="input input-bordered" readonly>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const serviceSelect = document.getElementById('service');
        const parishSelect = document.getElementById('parish');
        const amountInput = document.getElementById('amount');

        async function updateAmount() {
            const service_id = serviceSelect.value;
            const parish_id = parishSelect.value;

            if(service_id && parish_id) {
                const response = await fetch(`get-price.php?service_id=${service_id}&parish_id=${parish_id}`);
                const data = await response.json();
                amountInput.value = data.amount;
            }
        }

        serviceSelect.addEventListener('change', updateAmount);
        parishSelect.addEventListener('change', updateAmount);
    </script>
</body>
</html>