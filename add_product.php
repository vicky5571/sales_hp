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
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h2>Add Product</h2>
            <ul>
                <li><a href="index.php" class="btn btn-primary">Home</a></li>
            </ul>
        </div>
        
        <?php
        include_once("koneksi.php");

        // Fetch categories from the database
        $category_result = mysqli_query($mysqli, "SELECT id, name FROM categories");

        if (!$category_result) {
            echo "Error fetching categories: " . mysqli_error($mysqli);
        }
        ?>

        <form action="add_product.php" method="post" name="form1">
            <table width="50%" border="0">
                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php
                            while ($category = mysqli_fetch_assoc($category_result)) {
                                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td><input type="text" class="form-control" name="color" required></td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td><input type="number" class="form-control" name="quantity" required></td>
                </tr>
                <tr>
                    <td>Buy Price</td>
                    <td><input type="number" step="0.01" class="form-control" name="buy_price" required></td>
                </tr>
                <tr>
                    <td>SRP</td>
                    <td><input type="number" step="0.01" class="form-control" name="srp" required></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><input type="date" class="form-control" name="date" required></td>
                </tr>
                <tr>
                    <td>IMEIs</td>
                    <td><textarea class="form-control" name="imeis" placeholder="Enter IMEIs separated by commas" required></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type='submit' name='Submit' value="Add" class='btn btn-primary'>Submit</button></td>
                </tr>
            </table>
        </form>

        <?php
        // Check if form is submitted, insert form data into products and product_units tables.
        if (isset($_POST['Submit'])) {
            $category_id = $_POST['category_id'];
            $color = $_POST['color'];
            $quantity = $_POST['quantity'];
            $buy_price = $_POST['buy_price'];
            $srp = $_POST['srp'];
            $date = $_POST['date'];
            $imeis = explode(',', $_POST['imeis']);

            if (count($imeis) != $quantity) {
                echo "The number of IMEIs provided does not match the quantity specified.";
            } else {
                // Retrieve category name based on category_id
                $category_query = mysqli_query($mysqli, "SELECT name FROM categories WHERE id = '$category_id'");
                $category_data = mysqli_fetch_assoc($category_query);
                $category_name = $category_data['name'];

                // Insert product data into products table
                $result_product = mysqli_query($mysqli, "INSERT INTO products(category_name, color, quantity, buy_price, srp, category_id, date) VALUES('$category_name', '$color', '$quantity', '$buy_price', '$srp', '$category_id', '$date')");

                if ($result_product) {
                    $product_id = mysqli_insert_id($mysqli);
                    $success = true;

                    // Insert each IMEI into product_units table
                    foreach ($imeis as $imei) {
                        $imei = trim($imei);
                        $result_imei = mysqli_query($mysqli, "INSERT INTO product_units(product_id, imei) VALUES('$product_id', '$imei')");
                        if (!$result_imei) {
                            $success = false;
                            echo "Error inserting IMEI: " . mysqli_error($mysqli);
                        }
                    }

                    if ($success) {
                        echo "Product added successfully. <a href='product.php' class='btn btn-warning'>View Products</a>";
                    } else {
                        echo "Error occurred while adding product.";
                    }
                } else {
                    echo "Error: " . mysqli_error($mysqli);
                }
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
