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
    <title>Add Stock</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h2>Add Stock</h2>
            <ul>
                <li><a href="product.php" class="btn btn-primary">Back to Products</a></li>
            </ul>
        </div>

        <?php
        include_once("koneksi.php");

        // Get product ID from URL
        $product_id = $_GET['product_id'];

        // Query to get product details
        $product_query = "SELECT * FROM products WHERE id = $product_id";
        $product_result = mysqli_query($mysqli, $product_query);
        $product = mysqli_fetch_assoc($product_result);
        ?>

        <form action="add_stock.php?product_id=<?php echo $product_id; ?>" method="post">
            <div class="form-group">
                <label for="product_name">Product:</label>
                <input type="text" class="form-control" value="<?php echo $product['category_name']; ?>" disabled>
            </div>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="imei">IMEI:</label>
                <input type="text" name="imei" id="imei" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <button type="submit" name="add_stock" class="btn btn-primary">Add Stock</button>
        </form>

        <?php
        // Handle adding stock
        if (isset($_POST['add_stock'])) {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $imei = $_POST['imei'];
            $date = $_POST['date'];

            // Update quantity of the product
            $update_query = "UPDATE products SET quantity = quantity + $quantity WHERE id = $product_id";
            mysqli_query($mysqli, $update_query);

            // Insert new IMEI into product_units
            $insert_query = "INSERT INTO product_units (product_id, imei) VALUES ($product_id, '$imei')";
            mysqli_query($mysqli, $insert_query);

            // Redirect to product page after adding stock
            header("Location: product.php?stock_added=1");
            exit();
        }

        // Close the database connection
        mysqli_close($mysqli);
        ?>
    </div>

    <?php
    if (isset($_GET['stock_added']) && $_GET['stock_added'] == 1) {
        echo "<script>alert('Stock added successfully.');</script>";
    }
    ?>
</body>

</html>
