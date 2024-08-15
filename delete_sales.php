<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<?php
// Include your database connection file
include_once("koneksi.php");

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the sale record
    $result = mysqli_query($mysqli, "DELETE FROM sales WHERE id=$id");

    // Check if the query was successful
    if ($result) {
        header("Location: sales.php?delete_success=1");
    } else {
        echo "<script>alert('Error deleting sale.'); window.location.href='sales.php';</script>";
    }
} else {
    // Redirect if ID is not set in the URL
    header("Location: sales.php");
}
?>
