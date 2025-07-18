document.addEventListener('DOMContentLoaded', () => {
    // Get elements
    const fromInput = document.getElementById('from');
    const destinationInput = document.getElementById('destination');
    const datesInput = document.getElementById('dates');
    const travelersInput = document.getElementById('travelers');
    const numTravelersHiddenInput = document.getElementById('num-travelers');

    const cityModal = document.getElementById('cityModal');
    const travelersModal = document.getElementById('travelersModal');

    const closeButtons = document.querySelectorAll('.modal .close-button');
    const citySearchInput = document.getElementById('citySearchInput');
    const cityList = document.getElementById('cityList');
    const selectCityButton = document.getElementById('selectCityButton');
    const travelerCountSpan = document.getElementById('travelerCount');
    const decrementTravelersBtn = document.getElementById('decrementTravelers');
    const incrementTravelersBtn = document.getElementById('incrementTravelers');
    const doneTravelersButton = document.getElementById('doneTravelersButton');

    let currentCityInput = null; // To track which input triggered the city modal

    // --- City Modal Logic ---
    fromInput.addEventListener('focus', (e) => {
        e.preventDefault(); // Prevent default focus behavior
        cityModal.style.display = 'flex';
        currentCityInput = fromInput;
        citySearchInput.value = ''; // Clear search on open
        filterCityList(''); // Show all cities
        // Pre-select if value exists
        const currentVal = currentCityInput.value;
        document.querySelectorAll('.city-item').forEach(item => {
            item.classList.remove('selected');
            if (item.dataset.city === currentVal) {
                item.classList.add('selected');
            }
        });
    });

    destinationInput.addEventListener('focus', (e) => {
        e.preventDefault(); // Prevent default focus behavior
        cityModal.style.display = 'flex';
        currentCityInput = destinationInput;
        citySearchInput.value = ''; // Clear search on open
        filterCityList(''); // Show all cities
        // Pre-select if value exists
        const currentVal = currentCityInput.value;
        document.querySelectorAll('.city-item').forEach(item => {
            item.classList.remove('selected');
            if (item.dataset.city === currentVal) {
                item.classList.add('selected');
            }
        });
    });

    citySearchInput.addEventListener('keyup', (e) => {
        filterCityList(e.target.value);
    });

    function filterCityList(searchTerm) {
        const items = cityList.querySelectorAll('.city-item');
        items.forEach(item => {
            const cityName = item.dataset.city.toLowerCase();
            if (cityName.includes(searchTerm.toLowerCase())) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    cityList.addEventListener('click', (e) => {
        if (e.target.classList.contains('city-item')) {
            document.querySelectorAll('.city-item').forEach(item => {
                item.classList.remove('selected');
            });
            e.target.classList.add('selected');
        }
    });

    selectCityButton.addEventListener('click', () => {
        const selectedCityItem = cityList.querySelector('.city-item.selected');
        if (selectedCityItem && currentCityInput) {
            currentCityInput.value = selectedCityItem.dataset.city;
            cityModal.style.display = 'none';
        } else {
            alert('Please select a city.');
        }
    });

    // --- Dates (Flatpickr) Logic ---
    flatpickr(datesInput, {
        mode: "range",
        minDate: "today",
        dateFormat: "M j, Y",
        onClose: function(selectedDates, dateStr, instance) {
            // This function is called when the date picker is closed.
            // You can optionally do something with the selected dates here.
            // The input's value is already updated by Flatpickr.
        }
    });

    // --- Travelers Modal Logic ---
    travelersInput.addEventListener('focus', (e) => {
        e.preventDefault(); // Prevent default focus behavior
        travelersModal.style.display = 'flex';
        travelerCountSpan.textContent = numTravelersHiddenInput.value; // Sync with hidden input
    });

    decrementTravelersBtn.addEventListener('click', () => {
        let count = parseInt(travelerCountSpan.textContent);
        if (count > 1) { // Minimum 1 traveler
            count--;
            travelerCountSpan.textContent = count;
        }
    });

    incrementTravelersBtn.addEventListener('click', () => {
        let count = parseInt(travelerCountSpan.textContent);
        count++;
        travelerCountSpan.textContent = count;
    });

    doneTravelersButton.addEventListener('click', () => {
        const count = parseInt(travelerCountSpan.textContent);
        travelersInput.value = `${count} traveler${count > 1 ? 's' : ''}`;
        numTravelersHiddenInput.value = count; // Update hidden input
        travelersModal.style.display = 'none';
    });

    // --- Close Modals ---
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            cityModal.style.display = 'none';
            travelersModal.style.display = 'none';
        });
    });

    // Close modal when clicking outside of the content
    window.addEventListener('click', (event) => {
        if (event.target == cityModal) {
            cityModal.style.display = "none";
        }
        if (event.target == travelersModal) {
            travelersModal.style.display = "none";
        }
    });

    // The form submission is now handled by the HTML `action` attribute.
    // When the "Search" button is clicked, the form data will be sent to `seat_selection.php`
    // via GET request, which is suitable for initial search parameters.
});