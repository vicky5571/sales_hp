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
    <title>Add Sale</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <div class="header">
            <h2>Add Sales</h2>
            <ul>
                <li><a href="sales.php" class="btn btn-primary">Back to Sales</a></li>
            </ul>
        </div>
        
        <form action="add_sales.php" method="post">
            <div class="form-group">
                <label for="product_unit_id">Product (IMEI):</label>
                <select name="product_unit_id" id="product_unit_id" class="form-control" required>
                    <option value="">Select Product</option>
                    <?php
                    session_start();
                    include_once("koneksi.php");

                    // Get the IDs of products already in the cart
                    $cart_product_ids = [];
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $cart_product_ids[] = $item['product_unit_id'];
                        }
                    }

                    if (empty($cart_product_ids)) {
                        $cart_product_ids[] = 0;
                    }

                    $product_result = mysqli_query($mysqli, "
                        SELECT products.id as product_id, products.category_name, products.color, product_units.id as product_unit_id, product_units.imei 
                        FROM products 
                        JOIN product_units ON products.id = product_units.product_id
                        WHERE product_units.id NOT IN (" . implode(',', $cart_product_ids) . ")
                    ") or die(mysqli_error($mysqli));

                    while ($product = mysqli_fetch_assoc($product_result)) {
                        $product_id = $product['product_id'];
                        $product_name = $product['category_name'];
                        $product_unit_id = $product['product_unit_id'];
                        $imei_value = $product['imei'];
                        echo "<option value='$product_unit_id'>";
                        echo "$product_name - IMEI: $imei_value";
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sale_price">Sale Price:</label>
                <input type="number" name="sale_price" id="sale_price" class="form-control" required>
            </div>
            <input type="hidden" name="action" value="add_to_cart">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>

        <?php
        // Handle adding to cart
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_to_cart') {
            $product_unit_id = $_POST['product_unit_id'];
            $sale_price = $_POST['sale_price'];

            $product_query = "
                SELECT products.id as product_id, products.category_name, products.color, product_units.imei 
                FROM products 
                JOIN product_units ON products.id = product_units.product_id 
                WHERE product_units.id = $product_unit_id
            ";
            $product_result = mysqli_query($mysqli, $product_query) or die(mysqli_error($mysqli));
            $product_row = mysqli_fetch_assoc($product_result);

            $product_id = $product_row['product_id'];
            $product_name = $product_row['category_name'];
            $imei_value = $product_row['imei'];
            $product_color = $product_row['color'];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $_SESSION['cart'][] = [
                'product_unit_id' => $product_unit_id,
                'product_id' => $product_id,
                'product_name' => $product_name,
                'imei' => $imei_value,
                'color' => $product_color,
                'sale_price' => $sale_price,
            ];

            header("Location: add_sales.php");
            exit();
        }

        // Handle deleting from cart
        if (isset($_GET['remove'])) {
            $remove_id = $_GET['remove'];
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['product_unit_id'] == $remove_id) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
            // Reindex the cart array
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            header("Location: add_sales.php");
            exit();
        }

        // Display the cart
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            echo "<h3>Selected Products</h3>";
            echo "<table class='table table-bordered'>";
            echo "<tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>IMEI</th>
                    <th>Color</th>
                    <th>Sale Price</th>
                    <th>Action</th>
                  </tr>";

            $no = 1;
            foreach ($_SESSION['cart'] as $item) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>" . (isset($item['product_name']) ? $item['product_name'] : '') . "</td>
                        <td>" . (isset($item['imei']) ? $item['imei'] : '') . "</td>
                        <td>" . (isset($item['color']) ? $item['color'] : '') . "</td>
                        <td>{$item['sale_price']}</td>
                        <td>
                            <a href='add_sales.php?remove={$item['product_unit_id']}' class='btn btn-danger btn-sm'>Remove</a>
                        </td>
                      </tr>";
                $no++;
            }
            echo "</table>";
        }
        ?>

        <form action="add_sales.php" method="post">
            <input type="hidden" name="action" value="finalize_sale">
            <button type="submit" class="btn btn-primary">Finalize Sale</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'finalize_sale') {
            foreach ($_SESSION['cart'] as $item) {
                $product_unit_id = $item['product_unit_id'];
                $product_id = $item['product_id'];
                $sale_price = $item['sale_price'];
                $imei_value = $item['imei'];

                // Insert the sale into the sales table
                $insert_sale_query = "
                    INSERT INTO sales (product_id, sale_price, quantity, total_price, profit, imei, date)
                    VALUES ($product_id, $sale_price, 1, $sale_price, ($sale_price - (SELECT buy_price FROM products WHERE id = $product_id)), '$imei_value', NOW())
                ";
                mysqli_query($mysqli, $insert_sale_query) or die(mysqli_error($mysqli));

                // Reduce the quantity in the products table
                $update_quantity_query = "
                    UPDATE products
                    SET quantity = quantity - 1
                    WHERE id = $product_id
                ";
                mysqli_query($mysqli, $update_quantity_query) or die(mysqli_error($mysqli));

                // Delete the product unit from the product_units table
                $delete_imei_query = "
                    DELETE FROM product_units
                    WHERE id = $product_unit_id
                ";
                mysqli_query($mysqli, $delete_imei_query) or die(mysqli_error($mysqli));
            }

            unset($_SESSION['cart']);
            header("Location: sales.php");
            exit();
        }

        mysqli_close($mysqli);
        ?>
    </div>
</body>
</html>
