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
    <title>Edit Sale</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h1>Edit Sale</h1>
            <ul>
                <li><a href="sales.php" class="btn btn-primary">Back to Sales</a></li>
            </ul>
        </div>

        <?php
        // Include your database connection file
        include_once("koneksi.php");

        // Check if form is submitted for sales update, then redirect to sales page after update
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $sale_price = $_POST['sale_price'];
            $quantity = $_POST['quantity'];
            $date = $_POST['date'];
            $imei = $_POST['imei'];

            // Validate IMEI count matches quantity
            $imei_array = explode(',', $imei);
            if (count($imei_array) != $quantity) {
                echo "<script>alert('The number of IMEI values must match the quantity.'); history.go(-1);</script>";
                exit();
            }

            // Calculate total price and profit
            $total_price = $sale_price * $quantity;
            $product_result = mysqli_query($mysqli, "SELECT buy_price FROM products WHERE id=(SELECT product_id FROM sales WHERE id=$id)");
            $product_data = mysqli_fetch_assoc($product_result);
            $buy_price = $product_data['buy_price'];
            $profit = ($sale_price - $buy_price) * $quantity;

            // Update sale data
            $result = mysqli_query($mysqli, "UPDATE sales SET sale_price='$sale_price', quantity='$quantity', total_price='$total_price', date='$date', imei='$imei', profit='$profit' WHERE id=$id");

            // Redirect to sales page
            header("Location: sales.php");
        }

        // Display selected sale data based on id
        // Getting id from url
        $id = $_GET['id'];

        // Fetch sale data based on id
        $result = mysqli_query($mysqli, "SELECT * FROM sales WHERE id=$id");

        while ($sale_data = mysqli_fetch_array($result)) {
            $sale_price = $sale_data['sale_price'];
            $quantity = $sale_data['quantity'];
            $total_price = $sale_data['total_price'];
            $date = $sale_data['date'];
            $imei = $sale_data['imei'];
        }
        ?>

        <form name="update_sale" method="post" action="edit_sales.php">
            <table width="50%" border="0">
                <tr>
                    <td>Sale Price</td>
                    <td><input type="text" name="sale_price" value="<?php echo $sale_price; ?>" class="form-control"></td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" class="form-control"></td>
                </tr>
                <tr>
                    <td>Total Price</td>
                    <td><input type="text" name="total_price" value="<?php echo $total_price; ?>" class="form-control" readonly></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><input type="date" name="date" value="<?php echo $date; ?>" class="form-control"></td>
                </tr>
                <tr>
                    <td>IMEI</td>
                    <td><input type="text" name="imei" value="<?php echo $imei; ?>" class="form-control"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value=<?php echo $_GET['id']; ?>></td>
                    <td><input type="submit" name="update" value="Update" class="btn btn-primary"></td>
                </tr>
            </table>
        </form>
    </div>

    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Kelompok 1 TI23A5</a> all rights reserved.</p></strong>
        </div>
    </div>
</body>

</html>
