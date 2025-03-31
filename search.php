<?php
// Kết nối cơ sở dữ liệu
require 'db.php'; 

// Lấy từ khóa tìm kiếm từ người dùng
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Truy vấn sản phẩm từ cơ sở dữ liệu theo từ khóa tìm kiếm
$sql = "SELECT * FROM products WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $search . "%";  // Tìm kiếm theo tên sản phẩm
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-image: url('anhcho/hinh-nen-cho-corgi-full-hd-cho-may-tinh_050618592.jpg');
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-box input {
            padding: 10px;
            font-size: 20px;
            width: 300px;
            margin-right: 20px;
        }
        .search-box button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #bbb;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #234078;
            color: white;
            font-weight: bold;
        }
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .back-link {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .back-link a {
            text-decoration: none;
            color: #234078;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="back-link">
        <a href="javascript:history.back()">
            <i class="fa fa-arrow-left"></i> Return to the previous page
        </a>
    </div>

    <div class="search-box">
        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search for products..." value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit">Search</button>
        </form>
    </div>

    <h2>Search results</h2>

    <!-- Bảng Hiển thị sản phẩm -->
    <table>
        <thead>
            <tr>
                <th>Product name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>