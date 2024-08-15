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
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this category?");
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="container py-3">
            <div class="header">
                <h1>Category</h1>
                <ul>
                    <li><a href="index.php">Home</a></li> 
                    <li><a href="add_category.php" class="btn btn-primary">Add New Category</a></li>
                </ul>
            </div>

            <table width='100%' class="table table-bordered" border=1>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Categories</th>
                    <th>Action</th>
                </tr>
                <?php
                include_once("koneksi.php");
                $result = mysqli_query($mysqli, "SELECT * FROM categories ORDER BY id ASC");
                while ($categories_data = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $categories_data['id'] . "</td>";
                    echo "<td>" . $categories_data['name'] . "</td>";
                    echo "<td class='text-center'>
                            <a href='edit_category.php?id={$categories_data['id']}' class='btn btn-sm btn-warning'>Edit</a> | 
                            <a href='delete_category.php?id={$categories_data['id']}' class='btn btn-sm btn-danger' onclick='return confirmDelete();'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div class="footer-container">
            <div class="footer">
                <strong><p class="teks-footer">Copyright 2024 <a href="#">Kelompok 1 TI23A5</a> all rights reserved.</p></strong>
            </div>
        </div>
    </div>

</body>

</html>
