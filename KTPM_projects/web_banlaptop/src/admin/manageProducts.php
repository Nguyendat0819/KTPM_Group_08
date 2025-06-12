<?php
    include 'connectadmin.php';
    include 'admin.php';

    
    // Số sản phẩm mỗi trang
    $limit = 9;
    // Trang hiện tại
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    // Lấy tổng số sản phẩm
    $countResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
    $totalRow = mysqli_fetch_assoc($countResult);
    $totalProducts = $totalRow['total'];
    $totalPages = ceil($totalProducts / $limit);

    // Lấy sản phẩm cho trang hiện tại
    $query = "SELECT productCode, productName, buyPrice, qualityStock, fileImage, type FROM products LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $query);
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admins.css">
    <title>Quản lý sản phẩm</title>
</head>
<body>
    <div class="wrapper_table_products">
       
        <table border="1" cellpadding="5" cellspacing="0" class="table_products">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th>Loại</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['productCode']); ?></td>
                        <td>
                            <img src="../../images/<?php echo htmlspecialchars($row['fileImage']); ?>" width="60" alt="<?php echo htmlspecialchars($row['productName']); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($row['productName']); ?></td>
                        <td><?php echo number_format($row['buyPrice'], 0, '.', '.'); ?> VND</td>
                        <td><?php echo htmlspecialchars($row['qualityStock']); ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td>
                            <a href="editProduct.php?productCode=<?php echo $row['productCode']; ?>">Sửa</a>
                        </td>
                        <td>
                            <form method="POST" action="" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                <input type="hidden" name="productCode" value="<?php echo $row['productCode']; ?>">
                                <button type="submit" name="deleteProduct">Xóa</button>
                            </form>
                            <?php
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProduct'])) {
                                    $productCode = $_POST['productCode'];
                                    $deleteQuery = "DELETE FROM products WHERE productCode = '$productCode'";
                                    
                                    $deleteOrderDetailsQuery = "DELETE FROM orderdetails WHERE productCode = '$productCode'";
                                    mysqli_query($conn, $deleteOrderDetailsQuery);

                                    
                                    mysqli_query($conn, $deleteQuery);
                                    // Reload lại trang để cập nhật danh sách
                                    header("Location: manageProducts.php");
                                    exit;
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Không có sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
            <!-- PHÂN TRANG -->
        <div style="margin-top:50px;" class="direction_products">
            <?php if ($totalPages > 1): ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                <div class="current_direct">
                    <a href="?page=<?php echo $i; ?>" style="color: red; font-weight: bold;"><?php echo $i; ?></a>
                </div>
                <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>