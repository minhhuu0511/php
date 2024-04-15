<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Product List</h2>
        <?php
        // Kết nối tới cơ sở dữ liệu
        $conn = mysqli_connect('localhost', 'root', '', 'ecommerce');

        // Kiểm tra kết nối
        if (!$conn) {
            die("Kết nối thất bại: " . mysqli_connect_error());
        }

        // Mặc định sắp xếp từ thấp đến cao
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

        // Truy vấn SQL sắp xếp theo giá
        $sql = "SELECT * FROM product ORDER BY Price $order";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Hiển thị kết quả
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">Product ID</th>';
            echo '<th scope="col">Product Name</th>';
            echo '<th scope="col">Category ID</th>';
            echo '<th scope="col">Price</th>';
            echo '<th scope="col">Quantity</th>';
            echo '<th scope="col">Description</th>';
            echo'<th scope="col">Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo "<td>{$row['ProductID']}</td>";
                echo "<td>{$row['ProductName']}</td>";
                echo "<td>{$row['CateID']}</td>";
                echo "<td>{$row['Price']}</td>";
                echo "<td>{$row['Quantity']}</td>";
                echo "<td>{$row['Description']}</td>";
                echo "<td>";
                echo "<form method='POST' action='add_to_cart.php'>";
                echo "<input type='hidden' name='product_id' value='{$row['ProductID']}'>";
                echo "<input type='number' name='quantity' value='1' min='1'>";
                echo "<input type='submit' value='Thêm vào giỏ hàng'>";
                echo "</form>";
                echo "</td>";
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "<p>Không có sản phẩm nào.</p>";
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
