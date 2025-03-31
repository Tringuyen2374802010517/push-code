<?php
session_start();
session_unset();
session_destroy();
echo "<script>
    localStorage.removeItem('user'); // Xóa thông tin người dùng khỏi localStorage
    window.location.href = 'login.php'; // Chuyển hướng đến trang đăng nhập
</script>";
?>

