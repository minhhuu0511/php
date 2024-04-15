<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập và có quyền 'admin' chưa
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     // Nếu không, chuyển hướng đến trang đăng nhập
//     header('location: login_account.php');
//     exit(); // Dừng thực thi script
// }

// Kiểm tra xem đã có mã nhân viên được chọn để sửa chưa
if (!isset($_GET['id'])) {
    // Nếu không, chuyển hướng đến trang index.php hoặc thông báo lỗi
    header('location: index.php');
    exit();
} else {
    // Kết nối CSDL
    include 'config/connect.php';


    include 'category.class.php';
    $categories = Category::list_category();

    // Lấy mã nhân viên từ URL
    $product_id = $_GET['id'];

    // Query lấy thông tin nhân viên từ CSDL
    $sql = "SELECT * FROM product WHERE ProductID = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Xử lý form sửa nhân viên
        if (isset($_POST['submit'])) {
            // Lấy dữ liệu từ form
            $product_name = $_POST['productname'];
            $cate_id = $_POST['txtCateID'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $description = $_POST['description'];
            $picture=$_POST['picture'];
            // Query cập nhật thông tin nhân viên vào CSDL
            $update_sql = "UPDATE Product 
                           SET ProductName = '$product_name', CateID = '$cate_id', Quantity = '$quantity', 
                               Price = '$price', Description = '$description',Picture='$picture '
                           WHERE ProductID = '$product_id'";

            if ($conn->query($update_sql) === TRUE) {
                // Chuyển hướng đến trang index.php hoặc thông báo thành công
                header('location: index.php');
                exit();
            } else {
                echo "Lỗi: " . $conn->error;
            }
        }
    } else {
        // Không tìm thấy nhân viên có mã tương ứng
        echo "Không tìm thấy sản phẩm.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Sản phẩm</title>
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
        <h1>Thông Tin Sản phẩm</h1>
        <form action="" method="POST">
            <label for="ma_nv">Mã Sản Phẩm:</label><br>
            <input type="text" id="productDI" name="ma_nv" value="<?php echo $row['ProductID']; ?>" disabled><br>
            
            <label for="product_name">Tên sản phẩm:</label><br>
            <input type="text" id="productname" name="productname" value="<?php echo $row['ProductName']; ?>"disabled><br>

            <label for="cate_id">Mã Sản phẩm:</label><br>
            <div class="lblinput">
                <select name="txtCateID" disabled>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['CateID']; ?>"><?php echo $category['CategoryName']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" value="<?php echo $row['Price']; ?>"disabled><br>
            
            <label for="quantiy">Số lượng:</label><br>
            <input type="number" id="quantity" name="quantity" value="<?php echo $row['Quantity']; ?>"disabled><br><br>

            <label for="description">Mô tả:</label><br>
            <input type="text" id="description" name="description" value="<?php echo $row['Description']; ?>"disabled><br>

            <label for="picture">Hình ảnh:</label><br>
            <input type="text" id="picture" name="picture" value="<?php echo $row['Picture']; ?>"disabled><br>
            
            
        </form>
    </div>
</body>
</html>

