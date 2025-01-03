<?php
$status = isset($_GET['status']) ? $_GET['status'] : 'unknown';
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';

include("layout/header.php");
?>

<section id="payment-status" class="section-m1">
    <div class="status-des">
        <h2 class="form-weight-bold">Payment Status</h2>
        <hr class="mx-auto">
        <?php if ($status == 'success') { ?>
            <p class="text-center" style="color:green;">Payment Successful! Your payment ID is <?php echo htmlspecialchars($payment_id); ?></p>
        <?php } elseif ($status == 'failed') { ?>
            <p class="text-center" style="color:red;">Payment Failed. Please try again. Payment ID: <?php echo htmlspecialchars($payment_id); ?></p>
        <?php } elseif ($status == 'expired') { ?>
            <p class="text-center" style="color:orange;">Payment Expired. Please try again. Payment ID: <?php echo htmlspecialchars($payment_id); ?></p>
        <?php } else { ?>
            <p class="text-center" style="color:gray;">Payment Status Unknown. Please contact support. Payment ID: <?php echo htmlspecialchars($payment_id); ?></p>
        <?php } ?>
    </div>
</section>

<?php include("layout/footer.php"); ?>
