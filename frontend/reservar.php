<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedia-like Layout</title>
    <link rel="stylesheet" href="./css/reservar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

    <header class="navbar">
        <div class="Logo">PakaBussines</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">About us</a></li>
                <li><a href="form.php">Login</a></li>
                <li><a href="index.php">Info</a></li>
            </ul>
        </nav>

        <a href="form.php" class="get-started1">Get Started</a>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>¡BusesCorp!</h1>
            <div class="search-form-container">
                <form class="search-form" action="seat_selection.php" method="GET"> <div class="form-row">
                        <div class="input-group" id="from-input-group">
                            <label for="from">From</label>
                            <input type="text" id="from" name="from" placeholder="Origin City" readonly>
                        </div>
                        <div class="input-group" id="destination-input-group">
                            <label for="destination">Where to?</label>
                            <input type="text" id="destination" name="destination" placeholder="Destination City" readonly>
                        </div>
                        <div class="input-group" id="dates-input-group">
                            <label for="dates">Dates</label>
                            <input type="text" id="dates" name="dates" placeholder="Select Dates" readonly>
                        </div>
                        <div class="input-group" id="travelers-input-group">
                            <label for="travelers">Travelers</label>
                            <input type="text" id="travelers" name="travelers" value="1 traveler" readonly>
                            <input type="hidden" id="num-travelers" name="num_travelers" value="1">
                        </div>
                        <button type="submit" class="search-button">Search</button>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="bundle-save">
                        <label for="bundle-save">Add a flight to bundle & Save</label>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div id="cityModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Select City</h2>
            <input type="text" id="citySearchInput" placeholder="Search for a city...">
            <div id="cityList" class="city-list">
                <div class="city-item" data-city="Tacna">Tacna</div>
                <div class="city-item" data-city="Arequipa">Arequipa</div>
                <div class="city-item" data-city="Lima">Lima</div>
                <div class="city-item" data-city="Cusco">Cusco</div>
                <div class="city-item" data-city="Puno">Puno</div>
                <div class="city-item" data-city="Juliaca">Juliaca</div>
                <div class="city-item" data-city="Moquegua">Moquegua</div>
                <div class="city-item" data-city="Ica">Ica</div>
                <div class="city-item" data-city="Nazca">Nazca</div>
                <div class="city-item" data-city="Paracas">Paracas</div>
            </div>
            <button id="selectCityButton" class="modal-select-button">Select</button>
        </div>
    </div>

    <div id="travelersModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Travelers</h2>
            <div class="traveler-counter">
                <button id="decrementTravelers">-</button>
                <span id="travelerCount">1</span>
                <button id="incrementTravelers">+</button>
            </div>
            <button id="doneTravelersButton" class="modal-select-button">Done</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="./js/reservar.js"></script>
</body>
</html>