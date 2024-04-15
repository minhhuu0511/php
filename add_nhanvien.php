<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập và có quyền 'admin' chưa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Nếu không, chuyển hướng đến trang đăng nhập
    header('location: login_account.php');
    exit(); // Dừng thực thi script
}

// Kết nối CSDL
include 'config/connect.php';

// Xử lý form thêm nhân viên

include 'category.class.php';
$categories = Category::list_category();
if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $product_name = $_POST['productname'];
    $cate_id = $_POST['txtCateID'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $picture = $_POST['filePath'];
    
    // Query thêm nhân viên vào CSDL
    $sql = "INSERT INTO Product ( ProductName, CateID, Price, Quantity, Description, Picture) 
            VALUES ('$product_name', '$cate_id', '$price', '$quantity', '$description',  '$picture')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng đến trang index.php hoặc thông báo thành công
        header('location: index.php');
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên Mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Thêm Nhân Viên Mới</h1>
        <form action="" method="POST">

            <label for="product_name">Tên sản phẩm:</label><br>
            <input type="text" id="product_name" name="productname" required><br>

            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" required><br>


            <label for="cate_id">Mã Sản phẩm:</label><br>
            <div class="lblinput">
                <select name="txtCateID">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['CateID']; ?>"><?php echo $category['CategoryName']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label for="quantiy">Số lượng:</label><br>
            <input type="number" id="quantity" name="quantity" required><br><br>

            <label for="description">Mô tả:</label><br>
            <input type="text" id="description" name="description" required><br>

            <label for="picture">Hình ảnh:</label><br>
      
                <input type="text" id="filePath" name="filePath" placeholder="Đường dẫn file" readonly>
                <input type="file" id="fileInput" style="display: none;">
                <button type="button" onclick="chooseFile()">Chọn File</button>
                
            



            <input type="submit" name="submit" value="Lưu">
        </form>
    </div>
</body>

</html>

<script>
        function chooseFile() {
            document.getElementById('fileInput').click();
        }

        document.getElementById('fileInput').addEventListener('change', function() {
            var filePath = this.value;
            document.getElementById('filePath').value = filePath;
        });
    </script>