document.addEventListener('DOMContentLoaded', () => {
    const seats = document.querySelectorAll('.seat.available');
    const selectedSeatsCountSpan = document.getElementById('selected-seats-count');
    const selectedSeatsNumbersSpan = document.getElementById('selected-seats-numbers');
    const proceedToBuyButton = document.getElementById('proceedToBuy');

    let selectedSeats = [];

    // Get number of travelers from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const numTravelers = parseInt(urlParams.get('num_travelers')) || 1;

    // Display expected number of seats to select
    if (numTravelers > 1) {
        selectedSeatsCountSpan.closest('h3').innerHTML = `Selected Seats (<span id="selected-seats-count">0</span> of ${numTravelers})`;
    } else {
        selectedSeatsCountSpan.closest('h3').innerHTML = `Selected Seats: <span id="selected-seats-count">0</span>`;
    }

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            const seatNumber = seat.dataset.seatNumber;

            if (seat.classList.contains('selected')) {
                // Deselect seat
                seat.classList.remove('selected');
                selectedSeats = selectedSeats.filter(num => num !== seatNumber);
            } else {
                
                if (selectedSeats.length < numTravelers) {
                    seat.classList.add('selected');
                    selectedSeats.push(seatNumber);
                } else {
                    alert(`You can only select ${numTravelers} seat(s) for ${numTravelers} traveler(s).`);
                }
            }
            updateSelectedSeatsDisplay();
        });
    });

    function updateSelectedSeatsDisplay() {
        selectedSeatsCountSpan.textContent = selectedSeats.length;
        if (selectedSeats.length > 0) {
            selectedSeatsNumbersSpan.textContent = selectedSeats.sort((a, b) => a - b).join(', ');
        } else {
            selectedSeatsNumbersSpan.textContent = 'None';
        }

        
        if (selectedSeats.length === numTravelers) {
            proceedToBuyButton.disabled = false;
        } else {
            proceedToBuyButton.disabled = true;
        }
    }

   
    updateSelectedSeatsDisplay();

    proceedToBuyButton.addEventListener('click', () => {
        if (selectedSeats.length === numTravelers) {
            const from = urlParams.get('from');
            const destination = urlParams.get('destination');
            const dates = urlParams.get('dates');

            // Construct URL parameters for the boleta page
            const params = new URLSearchParams();
            params.append('from', from);
            params.append('destination', destination);
            params.append('dates', dates);
            params.append('travelers', numTravelers);
            params.append('selected_seats', selectedSeats.join(','));

            
            window.location.href = `/frontend/generate_boleto.php?${params.toString()}`;
        } else {
            alert(`Please select exactly ${numTravelers} seat(s).`);
        }
    });
});