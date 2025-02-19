// Open modal to select service
function openServiceModal(date) {
    document.getElementById("selectedDate").innerText = date;
    document.getElementById("serviceModal").style.display = "block";
}

// Open time slot modal after service selection
function selectService(service) {
    document.getElementById("selectedService").innerText = service;
    document.getElementById("serviceDate").innerText = document.getElementById("selectedDate").innerText;
    closeModal(); // Close service selection modal
    document.getElementById("timeModal").style.display = "block"; // Open time slot modal
}

// Confirm booking with selected time slot
function confirmBooking(timeSlot) {
    const service = document.getElementById("selectedService").innerText;
    const date = document.getElementById("serviceDate").innerText;

    alert(`Booking confirmed for ${service} on ${date} at ${timeSlot}`);
    closeModal();
}

// Close modal
function closeModal() {
    document.getElementById("serviceModal").style.display = "none";
    document.getElementById("timeModal").style.display = "none";
}

// Assume dates are clickable
document.querySelectorAll('.calendar-day').forEach(day => {
    day.onclick = function() {
        const date = day.getAttribute("data-date");
        openServiceModal(date);
    };
});
