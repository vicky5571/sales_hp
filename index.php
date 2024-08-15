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
    <!-- <link rel="stylesheet" type="text/css" href="bootstrap/css.css"> -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="container py-3">
            <div class="header-polos">
                <h1>Sales Dashboard</h1>
                <ul>
                    <li><a href="logout.php" class="btn btn-primary">Logout</a></li>
                </ul>
            </div>

            <div class="hero">
                <h2 class="heading">JV 8 CELL PAJANG</h2>
                <p class="sub-heading">Sistem Informasi Penjualan</p>
            </div>

            <section class="services">
                <a href="category.php" class="service-link">
                    <div class="service">
                        <div class="icon"><img src="img/categories.png" alt=""></div>
                        <h3>Categories</h3>
                    </div>
                </a>
                <a href="product.php" class="service-link">
                    <div class="service">
                        <div class="icon"><img src="img/products.png" alt=""></div>
                        <h3>Products</h3>
                    </div>
                </a>
                <a href="sales.php" class="service-link">
                    <div class="service">
                        <div class="icon"><img src="img/sales.png" alt=""></div>
                        <h3>Sales</h3>
                    </div>
                </a>
                <a href="sales_report.php" class="service-link">
                    <div class="service">
                        <div class="icon"><img src="img/sales-report.png" alt=""></div>
                        <h3>Sales Report</h3>
                    </div>
                </a>
            </section>         
        </div>



        <div class="footer-container">
            <div class="footer">
                <strong><p class="teks-footer">Copyright 2024 <a href="#">Vicky Galih</a> all rights reserved.</p></strong>
            </div>
        </div>
    </div>
    
</body>

</html>