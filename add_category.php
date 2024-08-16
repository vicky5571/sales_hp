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
    <title>Add Category</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container py-5">
        <div class="header">
            <h2>Add Category</h2>
            <ul>
                <li><a href="category.php" class="btn btn-primary">Back</a></li>
            </ul>
        </div>
        
        <form action="add_category.php" method="post" name="form1">
            <table width="50%" border="0">
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="form-control" name="nama" required></td>
                </tr>
            </table>
            <button type='submit' name='Submit' value="Add" class='btn btn-primary'>Submit</button>
        </form>
        <?php
        // Check If form submitted, insert form data into the categories table.
        if (isset($_POST['Submit'])) {
            $name = $_POST['nama'];

            // Include database connection file
            include_once("koneksi.php");
            // Insert category data into table
            $result = mysqli_query($mysqli, "INSERT INTO categories(name) VALUES('$name')");
            // Show message when category added
            echo "Category added successfully. <a href='category.php' class='btn btn-warning'>View Categories</a>";
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
