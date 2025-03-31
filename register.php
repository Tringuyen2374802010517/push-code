<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $password);

    if ($stmt->execute()) {
        $success = "<b>Registered successfully!</b> You can <a href='login.php'>login here</a>.";
    } else {
        $error = "<b>Username already exists. Please try again.</b>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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
        <form action="register.php" method="POST">
            <h3>Register</h3>
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <?php if (isset($success)) echo "<p style='color: #00FFFF;'>$success</p>"; ?>
            <div class="form-group">
                <input type="text" name="name" required>
                <label for="">User</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" required>
                <label for="">Password</label>
            </div>
            <input type="submit" value="Register" id="btn-login">
        </form>
    </div>
    <h4>Return to <a href="login.php">Log In</a></h4>
</body>
</html>
