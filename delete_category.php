<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once("koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if there are products associated with the category
    $result = mysqli_query($mysqli, "SELECT COUNT(*) AS product_count FROM products WHERE category_id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($row['product_count'] > 0) {
        echo "<script>alert('Cannot delete this category because it has associated products.'); window.location.href='category.php';</script>";
    } else {
        // Delete the category from the database
        $delete_result = mysqli_query($mysqli, "DELETE FROM categories WHERE id = $id");

        // Check if the deletion was successful
        if ($delete_result) {
            echo "<script>alert('Category deleted successfully.'); window.location.href='category.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error deleting category: " . mysqli_error($mysqli) . "'); window.location.href='category.php';</script>";
        }
    }
} else {
    echo "<script>alert('No category ID specified for deletion.'); window.location.href='category.php';</script>";
}

mysqli_close($mysqli);
?>
