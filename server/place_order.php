<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION["logged_in"])) {
    header('Location: ../checkout.php?message=Please Login to place an order');
    exit();
}

if (isset($_POST['place_order'])) {
    // Get user info and store in database
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $City = $_POST['City'];
    $Address = $_POST['Address'];
    $order_cost = $_SESSION['total'];
    $order_status = "Not Paid";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    // Prepare and execute the order insertion
    $stmt = $conn->prepare('INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                            VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $Phone, $City, $Address, $order_date);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Prepare the statement for order items
        $stmt1 = $conn->prepare('INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, user_id, order_date)
                                 VALUES (?, ?, ?, ?, ?, ?, ?)');

        foreach ($_SESSION['cart'] as $key => $product) {
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];

            // Bind parameters and execute for each product
            $stmt1->bind_param('iissiis', $order_id, $product_id, $product_name, $product_image, $product_price, $user_id, $order_date);
            if (!$stmt1->execute()) {
                echo "Error inserting product: " . $stmt1->error . "<br>";
            }
        }

        // Close the statement for order items
        $stmt1->close();

        // Set session variable for order total
        $_SESSION['total_order_price'] = $order_cost;
        $_SESSION['order_status'] = "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the order statement
    $stmt->close();
    // Close the database connection
    $conn->close();

    // Redirect after successful order placement
    header('Location: ../payment_checkout.php?order_status=ORDER PLACED SUCCESSFULLY');
    exit();
} else {
    header('Location: index.php');
    exit();
}
