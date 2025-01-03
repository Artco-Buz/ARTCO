<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTCO: Your Local Art Store</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/f112f1e794.js"></script>
</head>

<body>

<section id="header">
    <a href="index.php">
        <img src="img/logo.png" class="logo" alt="">
    </a>

    <div>
        <ul id="navbar">
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            ?>
            <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="shop.php" class="<?php echo ($current_page == 'shop.php') ? 'active' : ''; ?>">Shop</a></li>
            <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
            <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
            <li id="lg-bag"><a href="cart.php" class="<?php echo ($current_page == 'cart.php') ? 'active' : ''; ?>"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
            <li id="lg-bag"><a href="account.php" class="<?php echo ($current_page == 'account.php') ? 'active' : ''; ?>"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </div>
    <div id="mobile">
        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
</section>
