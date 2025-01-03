<?php

include("server/connection.php");

if(isset($_POST["order_details_btn"]) && isset($_POST["order_id"])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare('SELECT * FROM order_items WHERE order_id=?');
    $stmt->bind_param('i', $order_id);
    $stmt->execute(); 
    $order_details = $stmt->get_result();

    // Calculate total order price based on order details
    $total_order_price = 0;
    while($row = $order_details->fetch_assoc()) {
        $total_order_price += $row['product_price'];
    }

    // Reset the result pointer to the beginning
    $order_details->data_seek(0);

} else {
    header('location:account.php');
    exit();
}

?>

<?php include("layout/header.php"); ?>

<section id="orders" class="section-p1 text-center">
    <div class="register-des">
        <h2 class="form-weight-bold">ORDER DETAILS</h2>
        <hr class="mx-auto">
    </div>
</section>

<section id="cart-body" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Image</td>
                <td>Product Name</td>
                <td>Price</td>
                <td>Order Date</td>
            </tr>
        </thead>

        <?php while($row = $order_details->fetch_assoc()) { ?>
        <tbody>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="img/product/<?php echo $row['product_image']; ?>" alt="Product Image">
                    </div>
                </td>
                <td><?php echo $row['product_name']; ?></td>
                <td><span>₱<?php echo $row['product_price']; ?></span></td>
                <td><span><?php echo $row['order_date']; ?></span></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>

    <?php if($order_status == "Not Paid"){ ?>
        <form style="float: right;" method="POST" action="payment_order_details.php">
            <input type="hidden" name="total_order_price" value="<?php echo $total_order_price; ?>"/>
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>"/>
            <input type="hidden" name="order_status" value="<?php echo $order_status; ?>"/> 
            <input type="submit" name="order_pay_button" class="button" value="Pay Now" />
        </form>
    <?php } ?>
</section>

<?php include("layout/footer.php"); ?>
