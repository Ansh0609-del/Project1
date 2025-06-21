<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear the cart
$clear_cart_sql = "DELETE FROM cart";

if ($conn->query($clear_cart_sql) === TRUE) {
    $message = "Your items will reach you soon. Thank you for shopping!";
    $alert_class = "alert-success";
} else {
    $message = "Error: " . $conn->error;
    $alert_class = "alert-danger";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .alert {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Checkout</h2>
        <p class="alert <?php echo $alert_class; ?> text-center"><?php echo $message; ?></p>
        <div class="text-center">
            <a href="men.html" class="btn btn-primary">Back to Shopping</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
