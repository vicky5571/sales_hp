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
    <title>Sales Report</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h1>Sales Report</h1>
            <ul>
                <li><a href="index.php" class="btn btn-primary">Home</a></li>
            </ul>
        </div>

        <?php
        include_once("koneksi.php");

        // Fetch products for the dropdown filter
        $product_result = mysqli_query($mysqli, "SELECT id, category_name FROM products");
        ?>

        <form action="sales_report_table.php" method="get" name="form1" target="_blank">
            <table width="50%" border="0">
                <tr>
                    <td>Product</td>
                    <td>
                        <select name="product_id" class="form-control">
                            <option value="">All Products</option>
                            <?php
                            while ($product = mysqli_fetch_assoc($product_result)) {
                                echo "<option value='" . $product['id'] . "'>" . $product['category_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td><input type="date" class="form-control" name="start_date"></td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td><input type="date" class="form-control" name="end_date"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type='submit' name='Submit' value="Generate Report" class='btn btn-primary'>Generate Report</button></td>
                </tr>
            </table>
        </form>
    </div>

    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Vicky Galih</a> all rights reserved.</p></strong>
        </div>
    </div>
</body>

</html>
