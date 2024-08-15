<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include_once("koneksi.php");
include_once("koneksi.php");

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_level = 1; // Default user level, adjust as needed

    $result = mysqli_query($mysqli, "INSERT INTO users (name, username, password, user_level) VALUES ('$name', '$username', '$password', $user_level)");

    if ($result) {
        header("Location: login.php");
    } else {
        echo "Registration failed: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container register py-5">
        <div class="header">
            <h2>Register</h2>
        </div>
        <form action="register.php" method="post" name="form2">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="register" value="Register" class="btn btn-success">
            </div>
        </form>

        <ul>
            <li><a href="login.php" class="btn btn-primary">Login</a></li>
        </ul>
    </div>
</body>
</html>
