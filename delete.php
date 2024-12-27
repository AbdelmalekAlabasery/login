<?php
include 'dbcon.php';

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Delete the car from the database
    $sql = "DELETE FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        echo "Car deleted successfully!";
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No car ID provided.";
}

$conn->close();
?>
