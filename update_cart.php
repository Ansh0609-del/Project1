<?php
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['quantity'] as $id => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            $update_sql = "UPDATE cart SET quantity = $quantity WHERE id = $id";
            $conn->query($update_sql);
        }
    }
}

$conn->close();

header("Location: cart_display.php");
exit();
?>
