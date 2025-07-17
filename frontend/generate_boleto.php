<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bus Ticket - Boleta</title>
    <link rel="stylesheet" href="./css/boleta.css">
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

    <main class="boleta-container">
        <h1>Your Bus Ticket (Boleta)</h1>

        <?php
        // Retrieve data from URL parameters
        $from = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : 'N/A';
        $destination = isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : 'N/A';
        $dates = isset($_GET['dates']) ? htmlspecialchars($_GET['dates']) : 'N/A';
        $travelers = isset($_GET['travelers']) ? htmlspecialchars($_GET['travelers']) : '1';
        $selected_seats_str = isset($_GET['selected_seats']) ? htmlspecialchars($_GET['selected_seats']) : 'None';
        $selected_seats_array = explode(',', $selected_seats_str);

        // Basic calculation (you'd get this from a database in a real app)
        $price_per_seat = 25.00; // Example price
        $total_price = $price_per_seat * count($selected_seats_array);
        $ticket_number = 'PB' . strtoupper(uniqid()); // Simple unique ID
        $current_date = date('Y-m-d H:i:s');
        ?>

        <div class="boleta-details">
            <p><strong>Ticket Number:</strong> <?php echo $ticket_number; ?></p>
            <p><strong>Date of Purchase:</strong> <?php echo $current_date; ?></p>
            <hr>
            <p><strong>From:</strong> <?php echo $from; ?></p>
            <p><strong>To:</strong> <?php echo $destination; ?></p>
            <p><strong>Travel Dates:</strong> <?php echo $dates; ?></p>
            <p><strong>Number of Travelers:</strong> <?php echo $travelers; ?></p>
            <p><strong>Selected Seats:</strong> <?php echo $selected_seats_str; ?></p>
            <hr>
            <p class="price-info"><strong>Price per Seat:</strong> $<?php echo number_format($price_per_seat, 2); ?></p>
            <p class="price-info total-price"><strong>Total Price:</strong> $<?php echo number_format($total_price, 2); ?></p>
        </div>

        <div class="boleta-footer">
            <p>Thank you for choosing PakaBussines!</p>
            <button onclick="window.print()" class="print-button">Print Ticket</button>
            <a href="dashboard.php" class="back-button">Go to Dashboard</a>
        </div>
    </main>
</body>
</html>