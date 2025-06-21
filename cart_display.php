<?php
// Prevent caching of the cart display page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Remove item from cart if remove_id is set
if (isset($_GET['remove_id'])) {
    $remove_id = intval($_GET['remove_id']);
    $delete_sql = "DELETE FROM cart WHERE id = $remove_id";
    
    if ($conn->query($delete_sql) === TRUE) {
        $message = "Product removed successfully";
        $alert_class = "alert-success";
    } else {
        $message = "Error: " . $conn->error;
        $alert_class = "alert-danger";
    }
}

// Fetch cart items from the database
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .alert {
            margin-top: 20px;
            text-align: center;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table img {
            width: 50px;
            height: auto;
        }
        .table {
            margin-top: 20px;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Your Shopping Cart</h2>
        <?php if (!empty($message)): ?>
            <p class="alert <?php echo $alert_class; ?>"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <form id="cartForm" method="post" action="update_cart.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_amount = 0;
                        while ($row = $result->fetch_assoc()):
                            $total = $row["price"] * $row["quantity"];
                            $total_amount += $total;
                        ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($row["image"]); ?>" alt="Product Image"></td>
                                <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                                <td>₹<?php echo htmlspecialchars($row["price"]); ?></td>
                                <td><input type="number" name="quantity[<?php echo $row["id"]; ?>]" value="<?php echo htmlspecialchars($row["quantity"]); ?>" min="1" class="form-control"></td>
                                <td>₹<?php echo $total; ?></td>
                                <td><a href="cart_display.php?remove_id=<?php echo $row['id']; ?>" class="btn btn-danger">Remove</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <p class="text-right"><strong>Total Amount: ₹<?php echo $total_amount; ?></strong></p>
                <button type="submit" class="btn btn-primary">Update Cart</button>
            </form>
            <button id="buyNow" class="btn btn-success mt-3">Buy Now</button>
        <?php else: ?>
            <p>Your cart is empty</p>
        <?php endif; ?>
    </div>

    <script>
    document.getElementById('buyNow').addEventListener('click', function() {
        if (confirm("Your item will reach you soon. Thank you for shopping!")) {
            // Store the order details in the orders table and clear the cart
            fetch('process_order.php')
                .then(response => response.text())
                .then(data => {
                    // Optionally, display a success message or update the page
                    document.querySelector('body').innerHTML = '<div class="container text-center"><h2>' + data + '</h2></div>';
                });
        }
    });
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
