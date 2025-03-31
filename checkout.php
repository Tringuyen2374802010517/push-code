<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>
            alert('Please log in to proceed to checkout.');
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
    <title>Check Out</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/css_cho_cho.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
  
            background-image: url('anhcho/hinh-nen-cho-corgi-full-hd-cho-may-tinh_050618592.jpg'); /* Thay đổi đường dẫn hình nền tại đây */
            background-size:auto;
        }
        #wrapper {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #234078;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .checkout-button, .back-button {
            padding: 10px 15px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .checkout-button:hover, .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <h1>Check Out</h1>
    <form action="process_checkout.php" method="post">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required>
        
        <button type="submit" class="checkout-button">Confirm Order</button>
    </form>
    <button class="back-button" onclick="goBack()">Go Back</button>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
