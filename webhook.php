<?php
// Read the request body
$input = @file_get_contents("php://input");
$event_json = json_decode($input, true);

// Handle the event
if ($event_json && isset($event_json['data']['attributes']['status'])) {
    $status = $event_json['data']['attributes']['status'];
    $payment_id = $event_json['data']['id'];

    // Redirect based on the payment status
    switch ($status) {
        case 'paid':
            header('Location: reference_page.php?status=success&payment_id=' . $payment_id);
            break;
        case 'failed':
        case 'cancelled':
            header('Location: reference_page.php?status=failed&payment_id=' . $payment_id);
            break;
        case 'expired':
            header('Location: reference_page.php?status=expired&payment_id=' . $payment_id);
            break;
        default:
            header('Location: reference_page.php?status=unknown&payment_id=' . $payment_id);
            break;
    }
    exit();
}

// Respond with a 200 status code to acknowledge receipt of the event
http_response_code(200);
?>
