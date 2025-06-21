<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear all items from the cart
$clear_sql = "DELETE FROM cart";

if ($conn->query($clear_sql) === TRUE) {
    echo "Cart cleared";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
