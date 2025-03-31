<?php
session_start();
require 'db.php';

$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_mywebsite";
$conn = new mysqli($host, $user, $password, $dbname);

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['name'];
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Welcome</title>
        <style>
            body {
                background-image: url(thisanhthat/chocon.jpeg);
                background-size: cover;
                font-family: 'Montserrat', sans-serif;
                text-align: center;
                margin-top: 20%;
            }
            h1 {
                color: #20B2AA;
            }
            a, button {
                font-size: 16px;
                text-decoration: none;
                color: white;
                background-color: #20B2AA;
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s ease-in-out;
            }
            a:hover, button:hover {
                opacity: 0.85;
            }
        </style>
    </head>
    <body>
        <h1>Welcome, $username!</h1>
        <button onclick=\"window.location.href='logout.php'\">Log Out</button>
        <br><br>
        <a href='mainpage.html'>Go to Main Page</a>
    </body>
    </html>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $user['name'];
            echo "<script>
                localStorage.setItem('user', '$name');
                alert('Login Successfully!');
                window.location.href = 'mainpage.html';
            </script>";
            exit();
        } else {
            $error = "Wrong password. Please try again.";
        }
    } else {
        $error = "The account does not exist. Please <a href='register.php'>register</a>.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap');
        *{
            box-sizing: border-box;
        }
        body{
            background-image: url(thisanhthat/chocon.jpeg);
            background-size: cover;
            font-family: 'Montserrat', sans-serif;
            font-size: 17px;
        }
        #wrapper{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        form{
            border: 1px solid #20B2AA;
            border-radius: 5px;
            padding: 30px;
        }
        h3{
            text-align: center;
            font-size: 24px;
            font-weight: 500;
        }
        .form-group{
            margin-bottom: 15px;
            position: relative;
        }
        input{
            height: 50px;
            width: 300px;
            outline: none;
            border: 1px solid #20B2AA;
            padding: 10px;
            border-radius: 5px;
            font-size: inherit;
            color: black;
            transition: all 0.3 ease-in-out;
        }
        label{
            position: absolute;
            padding: 0px 5px;
            left: 5px;
            top: 50%;
            pointer-events: none;
            transform: translateY(-50%);
            background: white;
            transition: all 0.3 ease-in-out;
        }
        .form-group input:focus{
            border: 2px solid #20B2AA;
        }
        .form-group input:focus + label, .form-group input:valid + label{
            top: 0px;
            font-size: 13px;
            font-weight: 500;
            color: #20B2AA;
        }
        input#btn-login{
            background: #20B2AA;
            color: azure;
            cursor: pointer;
        }
        input#btn-login:hover{
            opacity: 0.85;
        }
        h4{
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <form action="login.php" method="POST">
            <h3>Log In</h3>
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <div class="form-group">
                <input type="text" name="name" required>
                <label for="">User</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" required>
                <label for="">Password</label>
            </div>
            <input type="submit" value="Log In" id="btn-login">
        </form>
    </div>
    <h4>Don't you have an account?<a href="register.php">Register</a> Now!</h4>
    <h4>Return to The <a href="mainpage.html">Main Page.</a></h4>
</body>
</html>
