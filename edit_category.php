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
    <title>Edit Category</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h2>Edit Category</h2>
            <ul>
            <li><a href="category.php" class="btn btn-primary">Back</a></li>
            </ul>
        </div>

        <?php
        // Include database connection file
        include_once("koneksi.php");

        // Check if the id is set in the URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch the existing category
            $result = mysqli_query($mysqli, "SELECT * FROM categories WHERE id = $id");
            $category_data = mysqli_fetch_assoc($result);
        }
        
        // Check if form is submitted
        if (isset($_POST['Update'])) {
            $name = $_POST['nama'];

            // Update the category in the database
            $update_result = mysqli_query($mysqli, "UPDATE categories SET name='$name' WHERE id=$id");

            // Show message and redirect
            if ($update_result) {
                echo "Category updated successfully. <a href='index.php' class='btn btn-warning'>View Categories</a>";
            } else {
                echo "Error updating category: " . mysqli_error($mysqli);
            }
        }
        ?>

        <form action="edit_category.php?id=<?php echo $id; ?>" method="post" name="form1">
            <table width="50%" border="0">
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="form-control" name="nama" value="<?php echo $category_data['name']; ?>" required></td>
                </tr>
            </table>
            <button type='submit' name='Update' class='btn btn-primary'>Update</button>
        </form>
    </div>

    <div class="footer-container">
        <div class="footer">
            <strong><p class="teks-footer">Copyright 2024 <a href="#">Vicky Galih</a> all rights reserved.</p></strong>
        </div>
    </div>
</body>

</html>
