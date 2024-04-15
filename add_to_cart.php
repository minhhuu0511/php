<?php
session_start();
// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'ecommerce');

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy thông tin sản phẩm từ yêu cầu POST
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$user_id = $_SESSION['user_id']; // Giả sử bạn đã xác thực người dùng và lưu ID vào phiên

// Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
$sql = "SELECT * FROM cart_items WHERE ProductID = $product_id AND UserID = $user_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
    $row = mysqli_fetch_assoc($result);
    
    $new_quantity = $row['Quantity'] + $quantity;
    $update_sql = "UPDATE cart_items SET Quantity = $new_quantity WHERE ProductID = $product_id "  ;
    mysqli_query($conn, $update_sql);
} else {
    // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
    $insert_sql = "INSERT INTO cart_items (ProductID, Quantity, UserID) VALUES ($product_id, $quantity, $user_id)";
    mysqli_query($conn, $insert_sql);
}

// Đóng kết nối
mysqli_close($conn);

// Chuyển hướng người dùng đến trang giỏ hàng
header("Location: cart.php");
?>