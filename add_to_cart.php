<?php
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Default to 1 if not set
    $image = $conn->real_escape_string($_POST['image']);

    $sql = "INSERT INTO cart (product_name, price, quantity, image) VALUES ('$product_name', '$price', '$quantity', '$image')";

    if ($conn->query($sql) === TRUE) {
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer?status=added");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
