<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <link rel="stylesheet" href="./css/seat_selection.css">
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

    <main class="seat-selection-container">
        <h1>Select Your Seats</h1>
        <?php
        // Get data from the previous form
        $from = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : 'N/A';
        $destination = isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : 'N/A';
        $dates = isset($_GET['dates']) ? htmlspecialchars($_GET['dates']) : 'N/A';
        $travelers = isset($_GET['num_travelers']) ? htmlspecialchars($_GET['num_travelers']) : '1';

        echo "<p><strong>Route:</strong> $from to $destination</p>";
        echo "<p><strong>Dates:</strong> $dates</p>";
        echo "<p><strong>Travelers:</strong> $travelers</p>";
        ?>

        <div class="bus-layout">
            <div class="driver-seat">Driver</div>
            <div class="seats-grid">
                <?php
                $total_seats = 30; // Example total seats
                for ($i = 1; $i <= $total_seats; $i++) {
                    $is_occupied = (rand(0, 9) < 2); // Randomly make some seats occupied
                    $seat_class = $is_occupied ? 'seat occupied' : 'seat available';
                    echo "<div class='$seat_class' data-seat-number='$i'>$i</div>";
                }
                ?>
            </div>
            <div class="legend">
                <span class="seat available"></span> Available
                <span class="seat occupied"></span> Occupied
                <span class="seat selected"></span> Selected
            </div>
        </div>

        <div class="selection-summary">
            <h3>Selected Seats: <span id="selected-seats-count">0</span></h3>
            <p>Seat Numbers: <span id="selected-seats-numbers">None</span></p>
            <button id="proceedToBuy" class="buy-button">Proceed to Buy</button>
        </div>
    </main>

    <script src="./js/seat_selection.js"></script>
</body>
</html>