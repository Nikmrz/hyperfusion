<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #1e1e1e;
            color: #fff !important;
        }
        .table {
            background-color: #2e2e2e;
            color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th, .table td {
            text-align: center;
            border: 1px solid #444 !important;
            padding: 15px !important;
        }
        .table th {
            background-color: #3c3c3c !important;
            font-weight: bold;
        }
        .table tbody tr:nth-child(even) {
            background-color: #1f1f1f !important;
        }
        .btn-remove, .btn-buy {
            padding: 8px 16px;
            font-size: 14px;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-remove {
            background-color: #dc3545 !important; /* Red */
        }
        .btn-buy {
            background-color: #28a745 !important; /* Green */
            width: 100%;
        }
        .btn-quantity {
            background-color: #444 !important;
            color: #fff;
            padding: 4px 10px;
            font-size: 12px;
            border: none;
            border-radius: 5px;
        }
        .profile-library p {
    color: #fff;
    font-size: 18px;
    text-align: center;
}

    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-white">Your Cart</h2>
    <?php if (!empty($_SESSION['cart'])) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Game Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $id => $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotal;
                ?>
                    <tr id="item-<?php echo $id; ?>">
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td>
                            <button class="btn-quantity" onclick="updateQuantity(<?php echo $id; ?>, -1)">-</button>
                            <span id="quantity-<?php echo $id; ?>"><?php echo $item['quantity']; ?></span>
                            <button class="btn-quantity" onclick="updateQuantity(<?php echo $id; ?>, 1)">+</button>
                        </td>
                        <td id="total-<?php echo $id; ?>"><?php echo $itemTotal; ?></td>
                        <td>
                            <button class="btn-remove" onclick="removeFromCart(<?php echo $id; ?>)">Remove</button>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3">Total Price</td>
                    <td id="grand-total"><?php echo $totalPrice; ?></td>
                    <td><button class="btn-buy" onclick="buyNow()">Buy Now</button></td>
                </tr>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-white">Your cart is empty.</p>
    <?php } ?>
</div>

<script>
function updateQuantity(id, delta) {
    let currentQuantity = parseInt($("#quantity-" + id).text());
    let newQuantity = currentQuantity + delta;
    if (newQuantity < 1) {
        newQuantity = 1;
    }
    $.post("cart.php", { id: id, action: 'update', quantity: newQuantity }, function() {
        $("#quantity-" + id).text(newQuantity);
        let itemPrice = parseFloat($("#item-" + id + " td:nth-child(2)").text());
        let itemTotal = itemPrice * newQuantity;
        $("#total-" + id).text(itemTotal.toFixed(2));
        updateGrandTotal();
    });
}

function removeFromCart(id) {
    $.post("cart.php", { id: id, action: 'remove' }, function() {
        // Remove the item row from the table
        $("#item-" + id).remove();
        
        // Update the grand total
        updateGrandTotal();

        // Check if the cart is empty and update the cart table content accordingly
        if ($(".table tbody tr[id^='item-']").length === 0) {
            $(".profile-library").html("<p class='text-white'>Your cart is empty.</p>");
        }
    });
}


function updateGrandTotal() {
    let grandTotal = 0;
    $(".table tbody tr[id^='item-']").each(function() {
        let itemTotal = parseFloat($(this).find("td:nth-child(4)").text());
        grandTotal += itemTotal;
    });
    $("#grand-total").text(grandTotal.toFixed(2));
}

// Redirects based on login status
function buyNow() {
    $.post("check_login_status.php", function(response) {
        if (response.loggedIn) {
            // If logged in, go to checkout page
            window.location.href = "checkout.php";
        } else {
            // If not logged in, redirect to login page
            window.location.href = "Login/login.html";
        }
    }, "json");
}
</script>

</body>
</html>
