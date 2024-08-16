<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sales</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this sale?')) {
                window.location.href = 'delete_sales.php?id=' + id;
            }
        }

        function showDeleteSuccess() {
            alert('Sale deleted successfully.');
        }
    </script>
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h1>Sales</h1>
            <ul>
                <li><a href="index.php" class="btn btn-primary">Home</a></li>
                <li><a href="add_sales.php" class="btn btn-primary">Add Sale</a></li>
            </ul>
        </div>

        <?php
        // Include your database connection file
        include_once("koneksi.php");

        // Query to select sales details along with the product details
        $result = mysqli_query($mysqli, "
            SELECT 
                sales.id, 
                sales.sale_price, 
                sales.quantity, 
                sales.total_price, 
                sales.date, 
                sales.imei, 
                sales.profit, 
                products.category_name AS product_name, 
                products.buy_price, 
                products.srp, 
                products.color 
            FROM sales 
            LEFT JOIN products ON sales.product_id = products.id
        ");

        // Check if query executed successfully
        if ($result) {
            echo "<table class='table table-bordered'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>IMEI</th>
                    <th>Color</th>
                    <th>Buy Price</th>
                    <th>SRP</th>
                    <th>Sale Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Profit</th>
                    <th>Action</th>
                  </tr>";

            // Fetch and display each row of sales data
            while ($sale_data = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $sale_data['id'] . "</td>";
                echo "<td>" . $sale_data['date'] . "</td>";
                echo "<td>" . $sale_data['product_name'] . "</td>";
                echo "<td>" . $sale_data['imei'] . "</td>";
                echo "<td>" . $sale_data['color'] . "</td>";
                echo "<td>" . $sale_data['buy_price'] . "</td>";
                echo "<td>" . $sale_data['srp'] . "</td>";
                echo "<td>" . $sale_data['sale_price'] . "</td>";
                echo "<td>" . $sale_data['quantity'] . "</td>";
                echo "<td>" . $sale_data['total_price'] . "</td>";
                echo "<td>" . $sale_data['profit'] . "</td>";
                echo "<td class='text-center'>
                        <a href='edit_sales.php?id=" . $sale_data['id'] . "' class='btn btn-sm btn-warning'>Edit</a> | 
                        <a href='#' class='btn btn-sm btn-danger' onclick='confirmDelete(" . $sale_data['id'] . ")'>Delete</a>
                      </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            // Handle query execution error
            echo "Error: " . mysqli_error($mysqli);
        }

        // Close the database connection
        mysqli_close($mysqli);
        ?>
    </div>

    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Vicky Galih</a> all rights reserved.</p></strong>
        </div>
    </div>

    <?php
    if (isset($_GET['delete_success']) && $_GET['delete_success'] == 1) {
        echo "<script>showDeleteSuccess();</script>";
    }
    ?>
</body>

</html>
