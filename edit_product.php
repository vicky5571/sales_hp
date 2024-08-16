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
    <title>Edit Product</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h2>Edit Product</h2>
            <ul>
                <li><a href="product.php" class="btn btn-primary">Back to Products</a></li>
            </ul>
        </div>

        <?php
        include_once("koneksi.php");

        // Check if ID is set
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch current product details
            $result = mysqli_query($mysqli, "SELECT * FROM products WHERE id='$id'");
            $product_data = mysqli_fetch_assoc($result);

            // Fetch current IMEIs
            $imei_result = mysqli_query($mysqli, "SELECT imei FROM product_units WHERE product_id='$id'");
            $imeis = mysqli_fetch_all($imei_result, MYSQLI_ASSOC);
            $imei_values = array_column($imeis, 'imei');
            $imei_string = implode(", ", $imei_values);
        }

        // Update product details if form is submitted
        if (isset($_POST['Update'])) {
            $category_id = $_POST['category_id'];
            $color = $_POST['color'];
            $quantity = $_POST['quantity'];
            $buy_price = $_POST['buy_price'];
            $srp = $_POST['srp'];
            $date = $_POST['date'];
            $imeis = $_POST['imeis'];

            // Check if the number of IMEIs matches the quantity
            $imei_array = explode(",", $imeis);
            if (count($imei_array) != $quantity) {
                echo "<div class='alert alert-danger'>The number of IMEI values must match the quantity.</div>";
            } else {
                // Update product details
                $update_query = "UPDATE products SET category_id='$category_id', color='$color', quantity='$quantity', buy_price='$buy_price', srp='$srp', date='$date' WHERE id='$id'";
                mysqli_query($mysqli, $update_query);

                // Update IMEIs
                mysqli_query($mysqli, "DELETE FROM product_units WHERE product_id='$id'");
                foreach ($imei_array as $imei) {
                    mysqli_query($mysqli, "INSERT INTO product_units (product_id, imei) VALUES ('$id', '$imei')");
                }

                header("Location: product.php?update=success");
                exit();
            }
        }
        ?>

        <form action="edit_product.php?id=<?php echo $id; ?>" method="post" name="form1">
            <table width="50%" border="0">
                <tr>
                    <td>Category ID</td>
                    <td>
                        <input type="number" class="form-control" name="category_id" value="<?php echo $product_data['category_id']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td>
                        <input type="text" class="form-control" name="color" value="<?php echo $product_data['color']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td>
                        <input type="number" class="form-control" name="quantity" value="<?php echo $product_data['quantity']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Buy Price</td>
                    <td>
                        <input type="number" step="0.01" class="form-control" name="buy_price" value="<?php echo $product_data['buy_price']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>SRP</td>
                    <td>
                        <input type="number" step="0.01" class="form-control" name="srp" value="<?php echo $product_data['srp']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>
                        <input type="date" class="form-control" name="date" value="<?php echo $product_data['date']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>IMEIs (comma separated)</td>
                    <td>
                        <input type="text" class="form-control" name="imeis" value="<?php echo $imei_string; ?>" required>
                    </td>
                </tr>
            </table>
            <button type='submit' name='Update' value="Update" class='btn btn-primary'>Update</button>
        </form>
    </div>

    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Vicky Galih</a> all rights reserved.</p></strong>
        </div>
    </div>
</body>

</html>
