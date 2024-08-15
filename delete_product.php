<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<?php
include_once("koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete related sales records first
    mysqli_query($mysqli, "DELETE FROM sales WHERE product_id='$id'");

    // Now delete the product
    $result = mysqli_query($mysqli, "DELETE FROM products WHERE id='$id'");

    if ($result) {
        header("Location: product.php?delete=success");
        exit();
    } else {
        echo "Error deleting product: " . mysqli_error($mysqli);
    }
}
?>
