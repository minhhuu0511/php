<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Search Results</h2>
        <?php
        // Kết nối đến database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ecommerce";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối không thành công: " . $conn->connect_error);
        }

        // Lấy từ khóa tìm kiếm từ URL
        $query = $_GET['query'];

        // Xử lý và tránh SQL injection
        $query = mysqli_real_escape_string($conn, $query);

        // Tạo câu truy vấn
        $sql = "SELECT * FROM product WHERE ProductName LIKE '%$query%'";

        $result = $conn->query($sql);

        // Hiển thị kết quả
        if ($result->num_rows > 0) {
            // In ra tiêu đề của bảng
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead class="thead-dark">';
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

            // Duyệt qua từng hàng kết quả và in ra dưới dạng bảng
            while ($row = $result->fetch_assoc()) {
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
            // Hiển thị thông báo nếu không tìm thấy kết quả
            echo '<div class="alert alert-warning" role="alert">Không tìm thấy kết quả.</div>';
        }

        $conn->close();
        ?>

        
        <a href="index.php" class="btn btn-primary mb-3">Quay về trang chủ</a> <!-- Thêm nút quay về trang chủ -->
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
