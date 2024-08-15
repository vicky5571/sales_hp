<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<?php
// Include database connection file
include_once("koneksi.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $product_unit_id = mysqli_real_escape_string($mysqli, $_POST['product_unit_id']); // Product unit ID from select dropdown
    $sale_price = mysqli_real_escape_string($mysqli, $_POST['sale_price']);
    $quantity = 1; // Since quantity is always 1 for a specific IMEI

    // Fetch product_id, imei, and buy_price from product_units based on $product_unit_id
    $product_query = "SELECT product_id, imei FROM product_units WHERE id = $product_unit_id";
    $product_result = mysqli_query($mysqli, $product_query);
    $product_row = mysqli_fetch_assoc($product_result);
    $product_id = $product_row['product_id'];
    $imei = $product_row['imei'];

    // Fetch buy price
    $buy_price_query = "SELECT buy_price FROM products WHERE id = $product_id";
    $buy_price_result = mysqli_query($mysqli, $buy_price_query);
    $buy_price_row = mysqli_fetch_assoc($buy_price_result);
    $buy_price = $buy_price_row['buy_price'];

    // Calculate total price and profit
    $total_price = $sale_price * $quantity;
    $profit = $sale_price - $buy_price; // Calculate profit

    // Insert sales data into database including the IMEI
    $insert_query = "INSERT INTO sales (product_id, sale_price, quantity, total_price, imei, profit, date) 
                     VALUES ('$product_id', '$sale_price', '$quantity', '$total_price', '$imei', '$profit', NOW())";

    if (mysqli_query($mysqli, $insert_query)) {
        // Update products to reduce the quantity by 1
        $update_quantity_query = "UPDATE products SET quantity = quantity - 1 WHERE id = $product_id";
        mysqli_query($mysqli, $update_quantity_query);

        // Delete the sold IMEI from product_units
        $delete_imei_query = "DELETE FROM product_units WHERE id = $product_unit_id";
        mysqli_query($mysqli, $delete_imei_query);

        // Redirect back to sales.php after successful insertion
        header("Location: sales.php");
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($mysqli);
    }

    // Close database connection
    mysqli_close($mysqli);
}
?>
