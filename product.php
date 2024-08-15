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
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h1>Products</h1>
            <ul>
                <li><a href="index.php" class="btn btn-primary">Home</a></li>
                <li><a href="add_product.php" class="btn btn-primary">Add Product</a></li>
            </ul>
        </div>

        <?php
        include_once("koneksi.php");

        // Check for success message
        if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
            echo "<script>alert('Product deleted successfully!');</script>";
        }

        // Query to select product details along with the category name and IMEIs
        $result = mysqli_query($mysqli, "
            SELECT 
                products.id, 
                categories.name AS category_name, 
                products.color,
                products.quantity, 
                products.buy_price, 
                products.srp, 
                products.date,
                GROUP_CONCAT(product_units.imei SEPARATOR ', ') AS imeis
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id
            LEFT JOIN product_units ON products.id = product_units.product_id
            GROUP BY products.id
        ");

        echo "<table class='table table-bordered'>";
        echo "<tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Buy Price</th>
                <th>SRP</th>
                <th>Date</th>
                <th>IMEIs</th>
                <th>Action</th>
              </tr>";

        while ($product_data = mysqli_fetch_assoc($result)) {
            echo "<tr data-id='" . $product_data['id'] . "'>";
            echo "<td>" . $product_data['id'] . "</td>";
            echo "<td>" . $product_data['category_name'] . "</td>";
            echo "<td>" . $product_data['color'] . "</td>";
            echo "<td>" . $product_data['quantity'] . "</td>";
            echo "<td>" . $product_data['buy_price'] . "</td>";
            echo "<td>" . $product_data['srp'] . "</td>";
            echo "<td>" . $product_data['date'] . "</td>";
            echo "<td>" . $product_data['imeis'] . "</td>";
            echo "<td class='text-center'>
                    <a href='edit_product.php?id=" . $product_data['id'] . "' class='btn btn-sm btn-warning'>Edit</a> | 
                    <a href='delete_product.php?id=" . $product_data['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a> |
                    <a href='add_stock.php?product_id=" . $product_data['id'] . "' class='btn btn-sm btn-success'>Add Stock</a>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>
    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Kelompok 1 TI23A5</a> all rights reserved.</p></strong>
        </div>
    </div>
</body>

</html>
