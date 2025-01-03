<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    // If user added a product to cart    
    if (isset($_SESSION['cart'])) {
        $product_array_ids = array_column($_SESSION['cart'], 'product_id');

        // If product is already added or not
        if (!in_array($_POST['product_id'], $product_array_ids)) {
            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
            );

            $_SESSION['cart'][$product_id] = $product_array;

        } else {
            echo '<script>alert("Product already added");</script>';
        }

    } else {
        // If first product    
        $product_id = $_POST['product_id'];
        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
        );

        $_SESSION['cart'][$product_id] = $product_array;
    }

    // Calculate total
    calculateTotalCart();

} elseif (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        echo '<script>alert("REMOVED PRODUCT: SUCCESSFUL ");</script>';
        calculateTotalCart();
    } else {
        echo '<script>alert("Product not found in cart: '.$product_id.'");</script>';
    }
} else {
    // header('Location: cart.php');
}

function calculateTotalCart() {
    $total = 0;

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $product = $_SESSION['cart'][$key];
            $price = $product['product_price'];
            $total += $price;
        }
    }
    $_SESSION['total'] = $total;
}

?>

<?php include("layout/header.php"); ?>

<section id="cart-body" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Remove</td>
                <td>Image</td>
                <td>Product</td>
                <td>Price</td>
            </tr>
        </thead>

        <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
        <?php foreach($_SESSION['cart'] as $key => $value) { ?>
        <tbody>
            <tr>
                <td>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                        <input type="submit" name="remove_product" class="remove-btn" value="Remove"/>
                    </form>
                </td>
                <td><img src="img/product/<?php echo $value['product_image']; ?>"></td>
                <td><?php echo $value['product_name']; ?></td>
                <td><span>₱</span><?php echo $value['product_price']; ?></td>
            </tr>
        </tbody>
        <?php } ?>
        <?php } else { ?>
        <tbody>
            <tr>
                <td colspan="4">Your cart is empty.</td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</section>

<section id="cart-total" class="section-p1">
    <div class="Subtotal">
        <h3>Total</h3>
        <table>
            <tr>
                <td>Cart Subtotal</td>
                <td>₱ <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : '0.00'; ?></td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>Free</td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td><strong>₱ <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : '0.00'; ?></strong></td>
            </tr>
        </table>
        <form method="POST" action="checkout.php">
            <input type="submit" class="button" value="CHECKOUT" name="checkout">
        </form>
    </div>
</section>

<?php include("layout/footer.php"); ?>
