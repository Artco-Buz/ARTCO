<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["logged_in"])) {
    header('Location: login.php?errorpaymentmessage=Please Login to place an order');
    exit();
}

// Set the order status if not already set
if (!isset($_SESSION['order_status'])) {
    $_SESSION['order_status'] = "No recent orders.";
}

// Check if order details are passed and set the session variable
if (isset($_POST['place_order']) && isset($_POST['total_order_price'])) {
    $_SESSION['total_order_price'] = $_POST['total_order_price'];
    $_SESSION['order_status'] = "Order placed successfully!";
}

include("layout/header.php");
?>

<section id="checkout" class="section-m1">
    <div class="checkout-des">
        <h2 class="form-weight-bold">PAYMENT</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <?php if (isset($_SESSION['total_order_price']) && $_SESSION['total_order_price'] != 0) { ?>
            <p style="color: green;" class="text-center"> <?php echo $_SESSION['order_status']; ?></p>
            <p>TOTAL PAYMENT: ₱<?php echo $_SESSION['total_order_price']; ?></p>
            <form method="POST" action="process_payment.php">
                <input type="hidden" name="total_order_price" value="<?php echo $_SESSION['total_order_price']; ?>"/>
                <input type="hidden" name="order_status" value="Not Paid"/>
                <input class="btn btn-primary" type="submit" value="Pay Now" name="order_pay_button"/>
            </form>
        <?php } else { ?>
            <p>YOU DO NOT HAVE ANY ORDERS</p>
        <?php } ?>
    </div>
</section>

<?php include("layout/footer.php"); ?>
