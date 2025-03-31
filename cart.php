<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
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
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        #wrapper {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #234078;
            margin-top: 30px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
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
        }
        .cart-item .price {
            font-weight: bold;
            color: #234078;
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
        }
        .back-button, .checkout-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        <button class="checkout-button" id="checkout-button">Check Out</button>
    </div>
</div>

<script>
    // Kiểm tra xem người dùng đã đăng nhập chưa
    const isLoggedIn = <?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false'; ?>;
    
    if (!isLoggedIn) {
        alert("Please log in to add to cart!");
        window.location.href = 'login.php'; // Chuyển hướng đến trang đăng nhập nếu người dùng chưa đăng nhập
    }

    // Lấy giỏ hàng từ localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout-button');

    // Hàm tính tổng giá trị giỏ hàng
    function calculateTotal() {
        const total = cart.reduce((acc, item) => acc + parseInt(item.price.replace(/\D/g, '')), 0);
        totalPriceElement.textContent = `Total: ${total.toLocaleString()} VND`;
        checkoutButton.disabled = cart.length === 0;
    }

    // Hàm hiển thị các sản phẩm trong giỏ hàng
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

    // Hàm xóa sản phẩm khỏi giỏ hàng
    function removeItem(index) {
        cart.splice(index, 1);  // Xóa sản phẩm khỏi mảng cart
        updateCart();
    }

    // Hàm cập nhật giỏ hàng và lưu vào localStorage
    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCartItems();
        calculateTotal();
    }

    // Hàm quay lại trang trước
    function goBack() {
        window.history.back();
    }

    // Hiển thị giỏ hàng và tính tổng
    displayCartItems();
    calculateTotal();
</script>

</body>
</html>
