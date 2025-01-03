<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    header('Location: login.php?message=Please Login to place an order');
    exit();
}

if (!empty($_SESSION['cart'])) {
    // Your code here
} else {
    header('location: index.php');
    exit();
}

include("layout/header.php");
?>

<section id="checkout" class="section-m1">
    <div class="checkout-des">
        <h2 class="form-weight-bold"> CHECKOUT </h2>
        <hr class="mx-auto">
    </div>

    <div class="mb-3">
        <form id="checkout-form" method="POST" action="server/place_order.php">
            <p class="text-center" style="color:red;">
                <?php if (isset($_GET['message'])) { echo $_GET['message']; } ?>
                <?php if (isset($_GET['message'])) { ?>
                    <a href="login.php" class="button">LOGIN</a>
                <?php } ?>
            </p>

            <div class="checkout-form-class checkout-small-element">
                <label>NAME</label>
                <input type="text" class="form-control" id="checkout-name" name="Name" placeholder="NAME" required/>
            </div>

            <div class="checkout-form-class checkout-small-element">
                <label>EMAIL</label>
                <input type="text" class="form-control" id="checkout-email" name="Email" placeholder="EMAIL" required/>
            </div>

            <div class="checkout-form-class checkout-small-element">
                <label>PHONE</label>
                <input type="text" class="form-control" id="checkout-phone" name="Phone" placeholder="PHONE" required/>
            </div>

            <div class="checkout-form-class checkout-small-element">
                <label>CITY</label>
                <input type="text" class="form-control" id="checkout-city" name="City" placeholder="CITY" required/>
            </div>

            <div class="checkout-form-class checkout-large-element">
                <label>ADDRESS</label>
                <input type="text" class="form-control" id="checkout-address" name="Address" placeholder="ADDRESS" required/>
            </div>

            <div class="register-form-class checkout-btn-container">
                <p>TOTAL AMOUNT: ₱<?php echo $_SESSION['total']; ?></p>
                <input type="hidden" name="total_order_price" value="<?php echo $_SESSION['total']; ?>"/>
                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order"/>
            </div>
        </form>
    </div>
</section>

<?php include("layout/footer.php"); ?>
