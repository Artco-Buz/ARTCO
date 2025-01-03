<?php
session_start();
require_once('vendor/autoload.php');

// Check if the user is logged in
if (!isset($_SESSION["logged_in"])) {
    header('Location: login.php?message=Please Login to proceed with the payment');
    exit();
}

// Ensure order details are available
if (isset($_POST['order_pay_button']) && isset($_SESSION['total_order_price'])) {
    $total_order_price = $_SESSION['total_order_price'] * 100; // Amount in centavos
    $description = "Payment for ARTCO";

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.paymongo.com/v1/links",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $total_order_price,
                    'currency' => "PHP",
                    'description' => $description,
                    'remarks' => "Sample Remarks"
                ]
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("sk_test_DFuz68EgTTvoZLNv4Yu3Gxb6")
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo json_encode(['error' => "cURL Error #". $err ]);
    } else {
        $responseData = json_decode($response, true);
        if (isset($responseData["data"]["attributes"]["checkout_url"])) {
            $checkout_url = $responseData["data"]["attributes"]["checkout_url"];

            // Redirect to the payment URL
            header('Location: ' . $checkout_url);
            exit();
        } else {
            // Log full response for debugging
            echo json_encode(["error" => "FAILED TO CREATE PAYMENT LINK", "response" => $responseData]);
        }
    }
} else {
    header('Location: checkout.php');
    exit();
}
?>
