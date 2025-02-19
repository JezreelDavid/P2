<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csv_db 10";

// Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// At the top of your file, after database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verify table exists
$checkTable = $conn->query("SHOW TABLES LIKE 'bookings'");
if ($checkTable->num_rows == 0) {
    // Create table if it doesn't exist
    $createTable = "CREATE TABLE IF NOT EXISTS bookings (
        id INT PRIMARY KEY AUTO_INCREMENT,
        church_id INT NOT NULL,
        service_type VARCHAR(50) NOT NULL,
        date DATE NOT NULL,
        time_slot TIME NOT NULL,
        status VARCHAR(20) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (church_id, service_type, date, time_slot)
    )";
    
    if (!$conn->query($createTable)) {
        die("Error creating table: " . $conn->error);
    }
}

// Make sure required variables are defined
$firstDayOfMonth = date('Y-m-01'); // First day of current month
$lastDayOfMonth = date('Y-m-t');   // Last day of current month
$selectedChurch = isset($_GET['church']) ? (int)$_GET['church'] : 1; // Changed from church_id to church

// Get URL Parameters
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Calculate Date Range
$firstDayOfMonth = date("Y-m-01", strtotime("$year-$month-01"));
$lastDayOfMonth = date("Y-m-t", strtotime("$year-$month-01"));
$selectedDate = date('Y-m-d'); // Today's date as default

// Add unavailable date calculation (7 days from today)
$unavailableUntilDate = date('Y-m-d', strtotime('+7 days'));

// Add these calendar calculations
$daysInMonth = date('t', strtotime("$year-$month-01")); // Number of days in the month
$dayOfWeek = date('w', strtotime($firstDayOfMonth)); // 0 (Sunday) through 6 (Saturday)

// Calculate Navigation Dates
$prevMonth = $month - 1;
$nextMonth = $month + 1;
$prevYear = $year;
$nextYear = $year;
if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;
}
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;
}

// Define Philippine Public Holidays for the selected year
$publicHolidays = [
    "01-01" => "New Year's Day",
    "04-06" => "Good Friday",
    "04-07" => "Black Saturday",
    "05-01" => "Labor Day",
    "06-12" => "Independence Day",
    "08-21" => "Ninoy Aquino Day",
    "11-01" => "All Saints' Day",
    "11-02" => "All Souls' Day",
    "12-25" => "Christmas Day",
    "12-30" => "Rizal Day",
    "12-31" => "New Year's Eve",
    "11-30" => "Bonifacio Day",
    "12-08" => "Immaculate Conception",
    "12-24" => "Christmas Eve",

];

// Fetch available time slots from database based on service type
function getServiceTimeSlots($conn, $service_type) {
    // Add error logging
    error_log("Getting time slots for service: " . $service_type . " and church: " . $_GET['church']);
    
    $sql = "SELECT time_slot, max_slots 
            FROM service_time_slots 
            WHERE service_type = ? 
            AND church_id = ?
            AND is_active = 1 
            ORDER BY time_slot";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $service_type, $_GET['church']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $timeSlots = [];
    while ($row = $result->fetch_assoc()) {
        // Convert database time to 12-hour format for display
        $timeObj = DateTime::createFromFormat('H:i:s', $row['time_slot']);
        $displayTime = $timeObj ? $timeObj->format('g:i A') : $row['time_slot'];
        
        $timeSlots[$row['time_slot']] = [
            'max_slots' => $row['max_slots'],
            'available_slots' => $row['max_slots']  // Default to max_slots
        ];
        
        error_log("Added time slot: " . $displayTime . " with max slots: " . $row['max_slots']);
    }
    
    if (empty($timeSlots)) {
        error_log("No time slots found for service: " . $service_type . " and church: " . $_GET['church']);
    }
    
    return $timeSlots;
}

// Check available slots for a specific date and service
function getAvailableSlots($conn, $date, $service_type, $time_slot, $church_id) {
    // Special handling for Wedding service
    if ($service_type === 'Wedding') {
        $sql = "SELECT sts.max_slots - COALESCE(COUNT(b.id), 0) as available_slots
                FROM service_time_slots sts
                LEFT JOIN bookings b ON b.service_type = sts.service_type 
                    AND b.time_slot = sts.time_slot 
                    AND b.date = ?
                    AND b.church_id = ?
                    AND b.status != 'cancelled'
                WHERE sts.service_type = 'Wedding'
                    AND sts.time_slot = ?
                    AND sts.church_id = ?
                    AND sts.is_active = 1
                GROUP BY sts.time_slot, sts.max_slots";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $date, $church_id, $time_slot, $church_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row ? $row['available_slots'] : 0;
    }
    
    // For other services
    $sql = "SELECT sts.max_slots - COALESCE(COUNT(b.id), 0) as available_slots
            FROM service_time_slots sts
            LEFT JOIN bookings b ON b.service_type = sts.service_type 
                AND b.time_slot = sts.time_slot 
                AND b.date = ?
                AND b.church_id = ?
                AND b.status != 'cancelled'
            WHERE sts.service_type = ?
                AND sts.time_slot = ?
                AND sts.church_id = ?
            GROUP BY sts.time_slot, sts.max_slots";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $date, $church_id, $service_type, $time_slot, $church_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row ? $row['available_slots'] : 0;
}

// Update the booking creation code
function createBooking($conn, $church_id, $date, $time_slot, $service_type) {
    // First check if slots are available
    $available_slots = getAvailableSlots($conn, $date, $service_type, $time_slot, $church_id);
    
    if ($available_slots <= 0) {
        return [
            'success' => false, 
            'message' => 'No slots available for this time'
        ];
    }
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Insert the booking
        $sql = "INSERT INTO bookings (church_id, date, time_slot, service_type) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $church_id, $date, $time_slot, $service_type);
        
        if (!$stmt->execute()) {
            throw new Exception("Error creating booking");
        }
        
        // Commit transaction
        $conn->commit();
        
        return [
            'success' => true, 
            'message' => 'Booking created successfully'
        ];
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        return [
            'success' => false, 
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}

// Update the calendar display to show service-specific availability
function getDateAvailability($conn, $date, $church_id) {
    $sql = "SELECT 
                sts.service_type,
                sts.time_slot,
                sts.max_slots,
                COUNT(b.id) as booked_slots,
                sts.max_slots - COUNT(b.id) as available_slots
            FROM service_time_slots sts
            LEFT JOIN bookings b ON b.service_type = sts.service_type 
                AND b.time_slot = sts.time_slot 
                AND b.date = ?
                AND b.church_id = ?
                AND b.status != 'cancelled'
            WHERE sts.is_active = 1
            GROUP BY sts.service_type, sts.time_slot";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $date, $church_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $availability = [];
    while ($row = $result->fetch_assoc()) {
        $availability[$row['service_type']][$row['time_slot']] = [
            'max' => $row['max_slots'],
            'booked' => $row['booked_slots'],
            'available' => $row['available_slots']
        ];
    }
    
    return $availability;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Booking Calendar</title>
    <link rel="stylesheet" href="calen.css">
    <style>
        /* CSS to mark 7-day unavailable dates as gray */
        .unavailable {
            background-color: lightgray;
            color: darkgray;
            pointer-events: none;
        }
        .booked {
            background-color: lightcoral;
            color: darkred;
            pointer-events: none;
        }
        .available {
            background-color: lightgreen;
            color: darkgreen;
        }
        .closed {
            background-color: lightblue;
            color: darkblue;
            pointer-events: none;
        }
        .time-slot {
            display: block;
            padding: 5px;
            margin: 2px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .time-slot.available {
            background-color: #d4edda;
        }
        .time-slot.booked {
            background-color: #f8d7da;
        }
        .slot-info {
            font-size: 0.8em;
            color: #555;
        }
        .calendar-navigation {
            margin: 20px 0;
            text-align: center;
        }

        .calendar-navigation select {
            padding: 8px;
            margin: 0 5px;
            font-size: 16px;
        }

        .calendar-navigation button {
            padding: 8px 15px;
            font-size: 16px;
            cursor: pointer;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin: 10px 0;
        }

        .nav-link {
            text-decoration: none;
            padding: 8px 15px;
            background-color: #f0f0f0;
            border-radius: 4px;
            color: #333;
        }

        .nav-link:hover {
            background-color: #e0e0e0;
        }

        .date-selector {
            text-align: center;
        }

        .month-year-form {
            display: inline-flex;
            gap: 10px;
        }

        .month-year-form select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            background-color: white;
        }

        .calendar-header span {
            font-size: 1.2em;
            font-weight: bold;
        }

        .time-slot button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .time-slot button:hover {
            background-color: #f0f0f0;
        }

        .slot-info {
            display: block;
            font-size: 0.8em;
            color: #666;
        }

        /* Unavailable dates styling */
        .calendar-day.unavailable {
            background-color: #f0f0f0;  /* light gray */
            color: #999;  /* darker gray for text */
            cursor: not-allowed;
            pointer-events: none;
        }
        
        /* Past dates styling */
        .calendar-day.past {
            background-color: #f0f0f0;
            color: #999;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        /* Holiday styling */
        .calendar-day.holiday {
            background-color: #ffe6e6;  /* light red */
            color: #cc0000;  /* darker red for text */
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- Main Calendar Container -->
    <div id="calendar">
        <!-- Church Selection Form -->
        <form action="calend.php" method="GET">
            <label for="church">Select Church:</label>
            <select name="church" id="church" onchange="this.form.submit()">
                <option value="1" <?php echo ($selectedChurch == 1) ? 'selected' : ''; ?>>St. Ignatius of Loyola Parish (Ususan, Taguig)</option>
                <option value="2" <?php echo ($selectedChurch == 2) ? 'selected' : ''; ?>>St. Michael the Archangel Parish (BGC, Taguig)</option>
                <option value="3" <?php echo ($selectedChurch == 3) ? 'selected' : ''; ?>>Sto. Rosario de Pasig Parish (Rosario, Pasig)</option>
                <option value="4" <?php echo ($selectedChurch == 4) ? 'selected' : ''; ?>>Sta. Rosa de Lima Parish (Bagong Ilog, Pasig)</option>
            </select>
        </form>

        <!-- Month Navigation -->
        <div class="calendar-header">
            <a href="calend.php?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>&church=<?php echo $selectedChurch; ?>" class="nav-link">Previous</a>
            
            <div class="date-selector">
                <form action="calend.php" method="GET" class="month-year-form">
                    <select name="month" onchange="this.form.submit()">
                        <?php
                        $months = [
                            1 => 'January', 2 => 'February', 3 => 'March',
                            4 => 'April', 5 => 'May', 6 => 'June',
                            7 => 'July', 8 => 'August', 9 => 'September',
                            10 => 'October', 11 => 'November', 12 => 'December'
                        ];
                        foreach ($months as $num => $name) {
                            $selected = ($num == $month) ? 'selected' : '';
                            echo "<option value=\"$num\" $selected>$name</option>";
                        }
                        ?>
                    </select>
                    <select name="year" onchange="this.form.submit()">
                        <?php
                        $currentYear = date('Y');
                        $maxYear = $currentYear + 5; // Show 5 years into the future
                        for ($y = $currentYear; $y <= $maxYear; $y++) {
                            $selected = ($y == $year) ? 'selected' : '';
                            echo "<option value=\"$y\" $selected>$y</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="church" value="<?php echo $selectedChurch; ?>">
                </form>
            </div>

            <a href="calend.php?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>&church=<?php echo $selectedChurch; ?>" class="nav-link">Next</a>
        </div>

        <!-- Calendar Grid -->
        <div class="calendar-grid">
            <?php
            // Display Days of Week Headers
            $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($daysOfWeek as $day) {
                echo "<div class='calendar-day-header'>$day</div>";
            }

            // Display Empty Cells for Offset
            for ($i = 0; $i < $dayOfWeek; $i++) {
                echo "<div class='calendar-day empty'></div>";
            }

            // Display Calendar Days
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = date("Y-m-d", strtotime("$year-$month-$day"));
                $displayDate = date("F j, Y", strtotime($currentDate));
                $dayOfWeekNum = date("w", strtotime($currentDate));
                $isPastDate = strtotime($currentDate) < strtotime(date('Y-m-d'));
                $isWithin7Days = strtotime($currentDate) < strtotime($unavailableUntilDate);
                $isClosed = ($dayOfWeekNum == 1);  // Sunday is closed
                $isHoliday = isset($publicHolidays[date("m-d", strtotime($currentDate))]);
                
                // Get availability for the date
                $dateAvailability = getDateAvailability($conn, $currentDate, $selectedChurch);
                $totalAvailable = 0;
                
                foreach ($dateAvailability as $service => $slots) {
                    foreach ($slots as $slot) {
                        $totalAvailable += $slot['available'];
                    }
                }

                // Determine the appropriate class
                if ($isPastDate || $isWithin7Days) {
                    $dayClass = "unavailable";
                } elseif ($isHoliday) {
                    $dayClass = "holiday";
                } elseif ($isClosed) {
                    $dayClass = "closed";
                } elseif ($totalAvailable <= 0) {
                    $dayClass = "booked";
                } else {
                    $dayClass = "available";
                }
                
                echo "<div class='calendar-day $dayClass'";
                if ($dayClass === "available") {
                    echo " onclick='showServiceModal(\"$currentDate\", \"$displayDate\")'";
                }
                echo ">";
                echo "<span class='date-number'>$day</span>";
                
                // Show appropriate status message
                if ($isHoliday) {
                    echo "<span class='slots'>Holiday</span>";
                } elseif ($isPastDate || $isWithin7Days) {
                    echo "<span class='slots'>Unavailable</span>";
                } elseif ($isClosed) {
                    echo "<span class='slots'>Closed</span>";
                } elseif ($totalAvailable <= 0) {
                    echo "<span class='slots'>Fully Booked</span>";
                } else {
                    echo "<span class='slots'>Available<br>($totalAvailable slots)</span>";
                }
                
                echo "</div>";
            }
            ?>
        </div>
    </div>

   <!-- Service Selection Modal -->
   <div id="serviceModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('serviceModal')">&times;</span>
            <h1>Select Service for <span id="selectedDate"></span></h1>
            <button onclick="selectService('Wedding')">Wedding</button>
            <button onclick="selectService('Funeral')">Funeral</button>
            <button onclick="selectService('Confirmation')">Confirmation</button>
            <button onclick="selectService('Baptismal')">Baptismal</button>
        </div>
    </div>

    <!-- Confirmation Popup -->
    <div id="confirmationPopup" class="popup" style="display: none;">
        <p>Sorry! This service is not available. It only opens in December. Thank you!</p>
        <button onclick="closeConfirmationPopup()">Close</button>
    </div>

    <!-- Time Slot Selection Modal -->
    <div id="timeModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('timeModal')">&times;</span>
            <h2>Select Time Slot for <span id="selectedService"></span> on <span id="serviceDate"></span></h2>
            <div id="timeSlotContainer">
                <!-- Time slots will be populated here -->
            </div>
        </div>
    </div>

    <script>
        // Declare these at the top of your script section
        let selectedDate = null;
        let selectedService = null;

        function showServiceModal(date, displayDate) {
            selectedDate = date;  // Keep the database format for backend
            document.getElementById('selectedDate').innerText = displayDate;  // Show formatted date
            document.getElementById('serviceModal').style.display = 'block';
        }

        function selectService(service) {
            selectedService = service;
            if (service === 'Confirmation') {
                document.getElementById('confirmationPopup').style.display = 'block';
                closeModal('serviceModal');
            } else {
                document.getElementById('selectedService').innerText = service;
                // Use the stored selectedDate for the backend call
                document.getElementById('serviceDate').innerText = document.getElementById('selectedDate').innerText;
                closeModal('serviceModal');
                document.getElementById('timeModal').style.display = 'block';
                populateTimeSlots(service);
            }
        }

        function populateTimeSlots(service) {
            var container = document.getElementById('timeSlotContainer');
            container.innerHTML = '<p>Loading available time slots...</p>';
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_time_slots.php?service=' + encodeURIComponent(service) + 
                '&date=' + encodeURIComponent(selectedDate) + 
                '&church=' + <?php echo $selectedChurch; ?>, true);
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var timeSlots = JSON.parse(xhr.responseText);
                        container.innerHTML = '';
                        
                        if (!timeSlots || Object.keys(timeSlots).length === 0) {
                            container.innerHTML = '<p>No time slots available for this service.</p>';
                            return;
                        }
                        
                        for (var time in timeSlots) {
                            if (timeSlots.hasOwnProperty(time)) {
                                var data = timeSlots[time];
                                // Fix time display by ensuring correct format
                                var [hours, minutes] = time.split(':');
                                var timeDisplay = new Date(2000, 0, 1, hours, minutes).toLocaleTimeString('en-US', {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    hour12: true
                                });
                                
                                var button = document.createElement('div');
                                button.className = 'time-slot ' + (data.available_slots > 0 ? 'available' : 'booked');
                                
                                button.innerHTML = `
                                    <button 
                                        onclick="redirectToForm('${time}', '${timeDisplay}')"
                                        ${data.available_slots <= 0 ? 'disabled' : ''}>
                                        ${timeDisplay}
                                        <span class="slot-info">(${data.available_slots} slots available)</span>
                                    </button>`;
                                
                                container.appendChild(button);
                            }
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        container.innerHTML = '<p>Error loading time slots. Please try again.</p>';
                    }
                }
            };
            
            xhr.send();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function closeConfirmationPopup() {
            document.getElementById('confirmationPopup').style.display = 'none';
        }

        function redirectToForm(timeSlot, timeDisplay) {
            console.group('Debugging Redirect');
            console.log('Selected Date:', selectedDate);
            console.log('Selected Service:', selectedService);
            console.log('Time Slot:', timeSlot);
            console.log('Time Display:', timeDisplay);
            
            let formLink;
            switch (selectedService) {
                case 'Baptismal':
                    formLink = 'Baptism.php';
                    break;
                case 'Wedding':
                    formLink = 'Marriage.php';
                    break;
                case 'Funeral':
                    formLink = 'Burial.php';
                    break;
                default:
                    console.error('Invalid service:', selectedService);
                    console.groupEnd();
                    alert("Unknown service selected!");
                    return;
            }

            const churchId = <?php echo $selectedChurch; ?>;
            // Ensure all parameters are properly encoded
            const url = `${formLink}?` + new URLSearchParams({
                church: churchId,
                date: selectedDate,
                time: timeSlot,
                service: selectedService,
                displayTime: timeDisplay
            }).toString();
            
            console.log('Final URL:', url);
            console.groupEnd();
            
            window.location.href = url;
        }

        function checkAvailability(date, service, timeSlot) {
            return fetch(`check_availability.php?date=${date}&service=${service}&time=${timeSlot}`)
                .then(response => response.json())
                .then(data => {
                    return data.available_slots;
                });
        }
    </script>
</body>
</html>
<?php
// Close the connection only after everything is done
$conn->close();
?>
