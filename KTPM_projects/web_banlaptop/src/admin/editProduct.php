<?php
// editProduct.php
include 'connectadmin.php';
include 'admin.php';
$productCode = $_GET['productCode'];
// Lấy dữ liệu sản phẩm
$sql = "SELECT * FROM products WHERE productCode = '$productCode'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $productName = $_POST['productName'];
    $buyPrice = $_POST['buyPrice'];
    $qualityStock = $_POST['qualityStock'];
    $type = $_POST['type'];
    // ... xử lý upload ảnh nếu có

    // Cập nhật vào database
    $update = "UPDATE products SET productName='$productName', buyPrice='$buyPrice', qualityStock='$qualityStock', type='$type' WHERE productCode='$productCode'";
    mysqli_query($conn, $update);
    header('Location: manageProducts.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admins.css">
    <title>Document</title>
</head>
<body>
    
    <div class="wrapper_edit_product">
        <h1>Sửa sản phẩm</h1>
        <div class="edit_product">
            <form method="post" class="form_edit_product">
                Tên sản phẩm: <input type="text" name="productName" value="<?php echo htmlspecialchars($product['productName']); ?>"><br>
                Giá bán: <input type="text" name="buyPrice" value="<?php echo htmlspecialchars($product['buyPrice']); ?>"><br>
                Số lượng: <input type="text" name="qualityStock" value="<?php echo htmlspecialchars($product['qualityStock']); ?>"><br>
                Loại: <input type="text" name="type" value="<?php echo htmlspecialchars($product['type']); ?>"><br>
                <button type="submit" class="submit_edit_products">Lưu</button>
            </form>
        </div>
    </div>
</body>
</html>