<?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] < 2) {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sales Report Table</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h1>Sales Report Table</h1>
        </div>

        <?php
        include_once("koneksi.php");

        if (isset($_GET['Submit'])) {
            $product_id = $_GET['product_id'];
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];

            // Base query
            $query = "
                SELECT 
                    sales.id, 
                    sales.sale_price, 
                    sales.quantity, 
                    sales.total_price, 
                    sales.date, 
                    products.category_name AS product_name, 
                    products.buy_price, 
                    sales.imei, 
                    products.color,
                    sales.profit
                FROM sales 
                LEFT JOIN products ON sales.product_id = products.id 
                WHERE 1=1
            ";

            // Add filters to the query
            if ($product_id) {
                $query .= " AND sales.product_id = '$product_id'";
            }
            if ($start_date) {
                $query .= " AND sales.date >= '$start_date'";
            }
            if ($end_date) {
                $query .= " AND sales.date <= '$end_date'";
            }

            $result = mysqli_query($mysqli, $query);

            // Display selected dates
            echo "<h4>Date Range: $start_date to $end_date</h4>";

            // Initialize summary variables
            $total_quantity = 0;
            $total_total_price = 0;
            $total_profit = 0;
            $row_number = 1; // Initialize row number

            if ($result) {
                echo "<table class='table table-bordered'>";
                echo "<tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Sale Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Buy Price</th>
                        <th>IMEI</th>
                        <th>Color</th>
                        <th>Profit</th>
                      </tr>";

                while ($sale_data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row_number . "</td>";
                    echo "<td>" . $sale_data['product_name'] . "</td>";
                    echo "<td>" . $sale_data['sale_price'] . "</td>";
                    echo "<td>" . $sale_data['quantity'] . "</td>";
                    echo "<td>" . $sale_data['total_price'] . "</td>";
                    echo "<td>" . $sale_data['date'] . "</td>";
                    echo "<td>" . $sale_data['buy_price'] . "</td>";
                    echo "<td>" . $sale_data['imei'] . "</td>";
                    echo "<td>" . $sale_data['color'] . "</td>";
                    echo "<td>" . $sale_data['profit'] . "</td>";
                    echo "</tr>";

                    // Update summary totals
                    $total_quantity += $sale_data['quantity'];
                    $total_total_price += $sale_data['total_price'];
                    $total_profit += $sale_data['profit'];
                    $row_number++; // Increment row number
                }

                echo "</table>";

                // Display summary table
                echo "<h2>Summary</h2>";
                echo "<table class='table table-bordered'>";
                echo "<tr>
                        <th>Total Unit Sold</th>
                        <th>Total of Total Price</th>
                        <th>Total Profit</th>
                      </tr>";
                echo "<tr>
                        <td>" . $total_quantity . "</td>";
                echo "<td>" . $total_total_price . "</td>";
                echo "<td>" . $total_profit . "</td>";
                echo "</tr>";
                echo "</table>";
            } else {
                echo "Error fetching sales data: " . mysqli_error($mysqli);
            }
        }
        ?>
    </div>

    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Vicky Galih</a> all rights reserved.</p></strong>
        </div>
    </div>
</body>

</html>
