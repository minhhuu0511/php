<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Shopping Cart</h2>
        <?php
session_start();
// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'ecommerce');

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id']; // Giả sử bạn đã xác thực người dùng và lưu ID vào phiên

// Truy vấn danh sách sản phẩm trong giỏ hàng của người dùng
$sql = "SELECT cart_items.CartID, cart_items.ProductID, cart_items.Quantity, product.ProductName, product.Price 
        FROM cart_items 
        INNER JOIN product ON cart_items.ProductID = product.ProductId 
        WHERE cart_items.UserId = $user_id";

$total_price = 0; // Khởi tạo biến tổng giá trị giỏ hàng

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Hiển thị danh sách sản phẩm trong giỏ hàng
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Product Name</th>';
    echo '<th scope="col">Price</th>';
    echo '<th scope="col">Quantity</th>';
    echo '<th scope="col">Actions</th>'; // Thêm cột Actions
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo "<td>{$row['ProductName']}</td>";
        echo "<td>{$row['Price']}</td>";
        echo "<td>{$row['Quantity']}</td>";
        echo '<td><form method="post"><input type="hidden" name="cart_id" value="' . $row['CartID'] . '"><button type="submit" class="btn btn-danger" name="remove">Remove</button></form></td>'; // Thêm nút Remove
        echo '</tr>';
        $total_price += ($row['Price'] * $row['Quantity']);
    }

    echo '</tbody>';
    echo '</table>';


    //thể hiện khung tổng tiền
    echo '</tbody>';
            echo '<tfoot>'; // Thêm tfoot cho dòng tổng giá trị giỏ hàng
            echo '<tr>';
            echo '<td colspan="3" class="text-right"><strong>Total Price</strong></td>';
            echo '<td><strong>$' . number_format($total_price, 2) . '</strong></td>'; // Hiển thị tổng giá trị giỏ hàng
            echo '</tr>';
            echo '</tfoot>';
            echo '</table>';

}else {
    echo "Giỏ hàng trống.";
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove'])) {
    $cart_id = $_POST['cart_id'];
    $delete_sql = "DELETE FROM cart_items WHERE CartID = $cart_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo '<div class="alert alert-success" role="alert">Sản phẩm đã được xóa khỏi giỏ hàng thành công.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Đã xảy ra lỗi. Vui lòng thử lại sau.</div>';
    }
}


// Đóng kết nối
mysqli_close($conn);

?>
        <a href="index.php" class="btn btn-primary mb-3">Quay về trang chủ</a> <!-- Thêm nút quay về trang chủ -->

    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
