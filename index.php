<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login_account.php');
    exit();
}


if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login_account.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chính</title>
    <link rel="stylesheet" href="">
    <style>
        <?php
        include 'style.php';
        ?>
    </style>

</head>

<body>

    <header>
        <h1>QUẢN LÝ SẢN PHẨM</h1>
        <div class="user-info">
            <p>Xin chào, <?php echo $_SESSION['username']; ?>!</p>
            <form action="" method="POST">
                <input type="submit" name="logout" value="Đăng xuất">
            </form>
        </div>
        <?php
        if ($_SESSION['role'] == 'admin') {
            echo '<button onclick="location.href=\'add_nhanvien.php\'" style="background-image: url(\'images/\'); background-repeat: no-repeat; background-position: left center; padding-left: 20px;">Thêm nhân viên</button>';
        }

        ?>
    </header>

    <h2>THÔNG TIN SẢN PHẨM</h2>
    <div class="container">
        <h2>Sắp xếp sản phẩm</h2>
        <a href="sort.php?order=desc">Giá từ cao đến thấp</a> |
        <a href="sort.php?order=asc">Giá từ thấp đến cao</a>
    </div>


    <form method="GET" action="search.php">
        <input type="text" name="query" placeholder="Nhập từ khóa...">
        <button type="submit">Tìm kiếm</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Loại sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Mô tả</th>


            <?php
            if ($_SESSION['role'] == 'admin') {
                echo '<th>Tùy Chỉnh</th>';
            }
            ?>
        </tr>

        <?php
        include 'config/connect.php';

        $results_per_page = 5;

        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $start_from = ($page - 1) * $results_per_page;

        $sql = "SELECT Product.ProductName,Product.CateID,Product.Price,Product.Quantity,Product.Description,Product.ProductID
                FROM Product
                -- JOIN category ON Product.CateID = category.CateID
                LIMIT $start_from, $results_per_page";

        $result = $conn->query($sql);

        function displayEmployeeRow($row)
        {
            echo "<tr>";
            echo "<td>{$row['ProductID']}</td>";
            echo "<td>{$row['ProductName']}</td>";
            echo "<td>{$row['CateID']}</td>";
            echo "<td>{$row['Price']}</td>";
            echo "<td>{$row['Quantity']}</td>";
            echo "<td>{$row['Description']}</td>";
            echo "<td><a href='/detail.php?id={$row['ProductID']}'>Chi tiết</a></td>";
            if ($_SESSION['role'] == 'admin') {
                echo "<td>";
                echo "<a href='/edit_nhanvien.php?id={$row['ProductID']}'><img src='images/edit.png' alt='Edit'></a> | ";
                echo "<a href='/delete_nhanvien.php?id={$row['ProductID']}'><img src='images/bin.png' alt='Delete'></a>";
               
                echo "</td>";
            } else {
               
                echo "<td>";
                echo "<form method='POST' action='add_to_cart.php'>";
                echo "<input type='hidden' name='product_id' value='{$row['ProductID']}'>";
                echo "<input type='number' name='quantity' value='1' min='1'>";
                echo "<input type='submit' value='Thêm vào giỏ hàng'>";
                echo "</form>";
                echo "</td>";
            }
           
            echo "</tr>";
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                displayEmployeeRow($row);
            }
        } else {
            echo "Không có dữ liệu!";
        }


        $conn->close();
        ?>
    </table>

    <?php
    // chia trang
    include 'phantrang.php';
    ?>

</body>

</html>