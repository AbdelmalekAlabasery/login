<?php
include 'dbcon.php';

// Check if car_id is passed in the URL and validate it
if (isset($_GET['car_id']) && is_numeric($_GET['car_id'])) {
    $car_id = (int)$_GET['car_id']; // Type-cast to integer for safety

    // Fetch car details from the database using prepared statements
    $sql = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id); // Bind car_id as integer
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
} else {
    // Handle case where car_id is invalid or not provided
    $car = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <!-- Custom Styling -->
    <style>
        body {
            background-color: #f5f5f5; /* Off-white background */
            color: #333; /* Dark text color */
            font-family: 'Arial', sans-serif;
        }

        .details-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; /* White container background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333; /* Dark title */
            text-align: center;
            font-size: 2.5rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .details p {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .details p strong {
            color: #007bff; /* Blue for key text */
        }

        .btn-back {
            display: block;
            width: 100%;
            margin-top: 20px;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            background-color: #007bff; /* Blue button */
            color: #ffffff;
            border: none;
            padding: 10px 0;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0056b3; /* Darker blue on hover */
            text-decoration: none;
        }

        .no-data {
            text-align: center;
            font-size: 1.5rem;
            color: #333; /* Dark text for "No data" messages */
        }
    </style>
</head>

<body>
    <div class="details-container">
        <?php if (isset($car) && $car): ?>
            <h1>Car Details</h1>
            <div class="details">
                <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                <p><strong>Used:</strong> <?php echo $car['used'] ? 'Yes' : 'No'; ?></p>
                <p><strong>Sale Date:</strong> <?php echo htmlspecialchars($car['sale_date']); ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($car['price'], 2); ?></p>
            </div>
            <a href="index.php" class="btn-back">Back to Records</a>
        <?php elseif (isset($car_id)): ?>
            <p class="no-data">Car not found.</p>
            <a href="index.php" class="btn-back">Back to Records</a>
        <?php else: ?>
            <p class="no-data">No car ID provided or invalid ID.</p>
            <a href="index.php" class="btn-back">Back to Records</a>
        <?php endif; ?>
    </div>
</body>

</html>
