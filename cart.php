<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>
            alert('Please log in to add to cart!.');
            window.location.href = 'login.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/css_cho_cho.css">
    <style>
        body {
            background-image: url('anhcho/hinh-nen-cho-corgi-full-hd-cho-may-tinh_050618592.jpg');
            background-size: auto;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
        }
        #wrapper {
            width: 80%;
            margin: 20px auto;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #FFE4E1;
            margin-top: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cart-item .info {
            flex: 1;
            margin-left: 10px;
        }
        .cart-item .info p {
            margin: 0;
            color: #fff;
        }
        .cart-item .price {
            font-weight: bold;
            color: #FFE4E1;
        }
        .cart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        .cart-footer .total {
            font-size: 18px;
            font-weight: bold;
            color: #FFE4E1;
        }
        .back-button, .checkout-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-shadow: none;
        }
        .back-button:hover, .checkout-button:hover {
            background-color: #0056b3;
        }
        .cart-footer button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .remove-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .remove-button:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>

<body>

<div id="wrapper">
    <h1>Your Shopping Cart</h1>
    <div id="cart-items"></div>
    <div class="cart-footer">
        <button class="back-button" onclick="goBack()">Return to previous page</button>
        <div class="total" id="total-price">Total: 0 VND</div>
        <button class="checkout-button" id="checkout-button"><a href="checkout.php" style="color: white; text-decoration: none;">Check Out</a></button>
    </div>
</div>

<script>
    const isLoggedIn = <?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false'; ?>;
    
    if (!isLoggedIn) {
        alert("Please log in to add to cart!");
        window.location.href = 'login.php';
    }

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout-button');

    function calculateTotal() {
        const total = cart.reduce((acc, item) => acc + parseInt(item.price.replace(/\D/g, '')), 0);
        totalPriceElement.textContent = `Total: ${total.toLocaleString()} VND`;
        checkoutButton.disabled = cart.length === 0;
    }

    function displayCartItems() {
        cartItemsContainer.innerHTML = '';
        cart.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div class="info">
                    <p><strong>${item.name}</strong></p>
                    <p class="price">${item.price}</p>
                </div>
                <button class="remove-button" onclick="removeItem(${index})">Xóa</button>
            `;
            cartItemsContainer.appendChild(cartItem);
        });
    }

    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
    }

    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCartItems();
        calculateTotal();
    }

    function goBack() {
        window.history.back();
    }

    displayCartItems();
    calculateTotal();
</script>

</body>
</html>
