<?php
include 'dbcon.php';

// Check if car_id is passed in the URL
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Fetch car details from the database
    $sql = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    // Check if the car exists
    if (!$car) {
        echo "Car not found.";
        exit;
    }

    // If the form is submitted, update the car details
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $model = $_POST['model'];
        $used = $_POST['used'];
        $sale_date = $_POST['sale_date'];
        $price = $_POST['price'];

        // Update the car in the database
        $update_sql = "UPDATE cars SET model = ?, used = ?, sale_date = ?, price = ? WHERE car_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sisdi", $model, $used, $sale_date, $price, $car_id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error updating car: " . $stmt->error;
        }
    }
} else {
    echo "No car ID provided.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <!-- Custom Styling -->
    <style>
        body {
            background-color: #f8f8f8; /* Off-white background */
            color: #333333; /* Darker text for readability */
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; /* White container background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333; /* Darker title text */
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
        }

        label {
            color: #333333; /* Darker label color */
            font-weight: bold;
        }

        .form-control {
            background-color: #ffffff; /* Match the form input background with the container */
            color: #333333; /* Text color for inputs */
            border: 1px solid #cccccc;
        }

        .form-control:focus {
            border-color: #007bff; /* Blue border for focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.7);
        }

        .btn-primary {
            background-color: #007bff; /* Blue button */
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Car Details</h1>
        <form method="POST" action="update.php?car_id=<?php echo $car_id; ?>">
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="used" class="form-label">Used</label>
                <select class="form-control" id="used" name="used" required>
                    <option value="0" <?php echo $car['used'] == 0 ? 'selected' : ''; ?>>No</option>
                    <option value="1" <?php echo $car['used'] == 1 ? 'selected' : ''; ?>>Yes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sale_date" class="form-label">Sale Date</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" value="<?php echo htmlspecialchars($car['sale_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($car['price']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Car</button>
        </form>
    </div>
</body>

</html>
