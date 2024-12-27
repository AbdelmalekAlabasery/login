<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Records</title>
    <!-- Bootstrap CSS (via CDN for simplicity) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styling -->
    <style>
        body {
            background-color: #f5f5f5; /* Off-white background */
            color: #333; /* Dark text color */
        }

        .table-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; /* White background for the table container */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333; /* Dark text for the title */
            text-align: center;
            font-size: 2.5rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table {
            background-color: #ffffff; /* White table background */
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background-color: #007bff; /* Blue background for headers */
            color: #ffffff; /* White text */
            text-align: center;
            padding: 10px;
        }

        .table td {
            color: #333; /* Dark text for all table cells */
            padding: 10px;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #e7f1ff; /* Light blue highlight on hover */
        }

        .btn {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff; /* Blue button */
            border: none;
        }

        .btn:hover {
            opacity: 0.8; /* Slight transparency on hover */
        }

        .no-records {
            color: #333; /* Dark text for "No records found" */
        }
    </style>
</head>

<body>
<a href="logout.php" class="btn btn-danger">Logout</a>
<div class="table-container">
        <h1>Car Records</h1>
        
        <a href="create.php" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add New Car
        </a>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Used</th>
                    <th>Sale Date</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all car records from the database
                include 'dbcon.php';
                $sql = "SELECT * FROM cars";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop through each record and display it
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['car_id'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";
                        echo "<td>" . ($row['used'] == 1 ? 'Yes' : 'No') . "</td>";
                        echo "<td>" . $row['sale_date'] . "</td>";
                        echo "<td>$" . number_format($row['price'], 2) . "</td>";
                        echo "<td>
                                <a href='show.php?car_id=" . $row['car_id'] . "' class='btn btn-primary btn-sm'>Show</a>
                                <a href='update.php?car_id=" . $row['car_id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete.php?car_id=" . $row['car_id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-records'>No records found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>