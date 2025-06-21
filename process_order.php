<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate a unique order ID (could be based on a session ID or timestamp)
$order_id = uniqid();

// Fetch the items from the cart
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_name = $row['product_name'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $total = $price * $quantity;

        // Insert the order details into the orders table
        $insert_order = "INSERT INTO orders (order_id, product_name, price, quantity, total)
                         VALUES ('$order_id', '$product_name', '$price', '$quantity', '$total')";
        $conn->query($insert_order);
    }

    // Clear the cart
    $conn->query("DELETE FROM cart");

    echo "Your order has been placed successfully!";
} else {
    echo "Your cart is empty.";
}

$conn->close();
?>
