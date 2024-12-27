<?php
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $model = $_POST['model'];
    $used = $_POST['used'];
    $sale_date = $_POST['sale_date'];
    $price = $_POST['price'];

    // Insert the new car into the database
    $sql = "INSERT INTO cars (model, used, sale_date, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisd", $model, $used, $sale_date, $price);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Car</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <!-- Custom Styling -->
    <style>
        /* General body styling */
        body {
            background-color: #f8f9fa; /* Off-white background */
            color: #333; /* Dark text color */
            font-family: 'Arial', sans-serif;
        }

        /* Center the container */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff; /* White background for the container */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Page Title */
        h1 {
            color: #333; /* Dark text */
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1.5px;
        }

        /* Form labels and inputs */
        .form-label {
            color: #333; /* Dark text color for labels */
            font-weight: bold;
        }

        .form-control {
            background-color: #f1f1f1; /* Light gray input background */
            color: #333; /* Dark text color */
            border: 1px solid #ced4da; /* Light gray border */
        }

        .form-control:focus {
            border-color: #80bdff; /* Blue border on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Soft glow on focus */
        }

        /* Submit Button */
        .btn-primary {
            background-color: #1B0FFC; /* Vibrant purple button */
            border: none;
            text-transform: uppercase;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #5a3ea1; /* Darker purple on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add New Car</h1>
        <form method="POST" action="create.php">
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="used" class="form-label">Used</label>
                <select class="form-control" id="used" name="used" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sale_date" class="form-label">Sale Date</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Car</button>
        </form>
    </div>
</body>

</html>