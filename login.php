<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include_once("koneksi.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username'");
    $user_data = mysqli_fetch_assoc($result);

    if ($user_data && password_verify($password, $user_data['password'])) {
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['name'] = $user_data['name'];
        $_SESSION['user_level'] = $user_data['user_level'];
        header("Location: index.php");
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container login py-5">
        <div class="header">
            <h2>Login</h2>
        </div>
        <form method="post" action="login.php">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" name="login" value="Login" class="button">
        </form>
        <ul>
            <li><a href="register.php" class="btn btn-primary">Register</a></li>
        </ul>
    </div>
</body>
</html>
