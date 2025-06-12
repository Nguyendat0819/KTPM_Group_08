<?php
    include 'connectadmin.php';
    include 'admin.php';

    // Xử lý cập nhật trạng thái
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'], $_POST['orderNumber'])) {
        $orderNumber = (int)$_POST['orderNumber'];
        $newStatus = 'Hoàn tất';
        $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE orderNumber=?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $newStatus, $orderNumber);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // Lấy danh sách đơn hàng và trạng thái
    $query = "
        SELECT o.orderNumber, o.orderDate, o.status, c.customerName, c.email, SUM(p.amount) AS totalAmount
        FROM orders o
        JOIN customer c ON o.customerNumber = c.customerNumber
        JOIN payments p ON o.customerNumber = p.customerNumber
        GROUP BY o.customerNumber, o.orderNumber, o.orderDate, o.status, c.customerName, c.email
        ORDER BY o.orderNumber ASC
    ";
    $result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trạng thái đơn hàng</title>
    <link rel="stylesheet" href="../../css/admins.css">
</head>
<body>
    <div class="wrapper_manage_order">
        <div class="manage_order">
            <h2 style="text-align: center;">Trạng thái đơn hàng</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr <?php if ($row['status'] === 'Hoàn tất') echo ' style="background-color: #b6fcb6;"'; ?>>
                            <td><?php echo htmlspecialchars($row['orderNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['orderDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['customerName']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['totalAmount'],0,',','.').'VNĐ'); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] !== 'Hoàn tất'): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="orderNumber" value="<?php echo $row['orderNumber']; ?>">
                                    <button type="submit" name="update_status" onclick="return confirm('Xác nhận hoàn tất đơn hàng này?')">Hoàn tất</button>
                                </form>
                                <?php else: ?>
                                    Đã hoàn tất
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Không có đơn hàng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>