/**
 * Hydrothermal Vent Database - Main JavaScript
 * SET08101 Web Technologies Coursework
 */

// Filter panel toggle
// The filter panel on index.php is hidden by default.
// Clicking the button adds/removes the 'open' class, which CSS uses
// to show or hide the panel (display: none / display: block).

const filterToggle = document.getElementById('filterToggle');
const searchPanel = document.getElementById('searchPanel');

console.log("JS loaded!");
document.addEventListener('DOMContentLoaded', function () {
    const locationElem = document.getElementById('location');
    if (locationElem) {
        const locationText = locationElem.textContent.trim();
        // Extract coordinates from brackets
        const match = locationText.match(/\(([^)]+)\)/);
        if (match) {
            let [latStr, longStr] = match[1].split(',').map(s => s.trim());
            // Parse latitude
            let lat = parseFloat(latStr);
            if (/S$/i.test(latStr)) lat = -lat;
            // Parse longitude
            let long = parseFloat(longStr);
            if (/W$/i.test(longStr)) long = -long;
            // Using leaflet to display map
            var map = L.map('map').setView([lat, long], 5);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
            }).addTo(map);
            L.marker([lat, long]).addTo(map);
        }
    }
});
if (filterToggle && searchPanel) {
    filterToggle.addEventListener('click', function () {
        const isOpen = searchPanel.classList.toggle('open');
        // Update button text to reflect state
        filterToggle.textContent = isOpen ? '▲ Filter' : '▼ Filter';
        // Visual feedback on the button
        filterToggle.classList.toggle('active', isOpen);
    });
}

// Contact form validation
const form = document.getElementById('contact-form');

if (form) {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    form.addEventListener('submit', function (e) {
        let hasError = false;

        document.getElementById('name-error').textContent = '';
        document.getElementById('email-error').textContent = '';
        document.getElementById('message-error').textContent = '';

        // Remove any error styling from inputs
        nameInput.classList.remove('error');
        emailInput.classList.remove('error');
        messageInput.classList.remove('error');

        // Name validation
        const nameValue = nameInput.value.trim();
        if (nameValue === '') {
            document.getElementById('name-error').textContent = 'Name is required.';
            nameInput.classList.add('error');
            hasError = true;
        } else if (nameVal.length < 3) {
            document.getElementById('name-error').textContent = 'Name must be at least 3 characters.';
            nameInput.classList.add('error');
            hasError = true;
        }

        // Email validation
        // Regex checks for a basic valid email pattern: test@abc.com
        const emailVal = emailInput.value.trim();
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(emailVal)) {
            document.getElementById('email-error').textContent = 'Please enter a valid email address.';
            emailInput.classList.add('error');
            hasError = true;
        }

        // Message validation
        // Standard length check
        const msgVal = messageInput.value.trim();
        if (msgVal === '') {
            document.getElementById('message-error').textContent = 'Message is required.';
            messageInput.classList.add('error');
            hasError = true;
        } else if (msgVal.length < 10) {
            document.getElementById('message-error').textContent = 'Message must be at least 10 characters.';
            messageInput.classList.add('error');
            hasError = true;
        }

        // If any error, stop the form from submitting
        if (hasError) {
            e.preventDefault();
        }
    });
}