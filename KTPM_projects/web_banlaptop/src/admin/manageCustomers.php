<?php
    include 'connectadmin.php';
    include 'admin.php';

    // Xử lý xóa khách hàng
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCustomer'])) {
        $customerNumber = $_POST['customerNumber'];
        // Xóa khách hàng (nên kiểm tra ràng buộc khóa ngoại trước khi xóa thực tế)
        $deleteQuery = "DELETE FROM customer WHERE customerNumber = '$customerNumber'";
        
        mysqli_query($conn, "DELETE FROM customeraddress WHERE customerNumber = '$customerNumber'");
        mysqli_query($conn, "DELETE FROM payments WHERE customerNumber = '$customerNumber'");
        mysqli_query($conn, "DELETE FROM orders WHERE customerNumber = '$customerNumber'");
        
        
        mysqli_query($conn, $deleteQuery);
        header("Location: manageCustomers.php");
        exit;
    }

    // Lấy danh sách khách hàng
    $query = "
        SELECT c.customerNumber, c.customerName, c.email, c.userName, c.password, c.gender, c.date,
            ca.addressHome, ca.phone, ca.province_id, ca.district_id, ca.wards_id
        FROM customer c
        LEFT JOIN customeraddress ca ON c.customerNumber = ca.customerNumber
        GROUP BY c.customerNumber
    ";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="wrapper_manage_customer">
        <div class="manage_customer">
            <h2 style="text-align: center;">Danh sách khách hàng</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Mã KH</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Tài khoản</th>
                        <th>Mật khẩu</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Địa chỉ</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['customerNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['customerName']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['userName']); ?></td>
                            <td><?php echo htmlspecialchars($row['password']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['addressHome']); ?></td>
                            
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?');">
                                    <input type="hidden" name="customerNumber" value="<?php echo $row['customerNumber']; ?>">
                                    <button type="submit" name="deleteCustomer">Xóa</button>
                                </form>
                                
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Không có khách hàng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>