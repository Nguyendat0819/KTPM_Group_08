<?php

    $conn = mysqli_connect('localhost', 'root', '', 'ktpm');
    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại" . mysqli_connect_error());
    }

    $item_per_page = !empty($_GET['per_page']) ? (int)$_GET['per_page'] : 15;
    $current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $item_per_page;

    // Lấy loại sản phẩm từ URL nếu có
    $product_type = isset($_GET['type']) ? htmlspecialchars($_GET['type'], ENT_QUOTES, 'UTF-8') : '';
    $type_param = !empty($product_type) ? '&type=' . urlencode($product_type) : '';

    // Đếm tổng số sản phẩm để tính số trang

    $total_query = "SELECT COUNT(*) AS total FROM products";
    if (!empty($product_type)) {
        $total_query .= " WHERE type = '" . mysqli_real_escape_string($conn, $product_type) . "'";
    }
    $total_result = mysqli_query($conn, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_items = $total_row['total'];
    $totalPage = ceil($total_items / $item_per_page);

    // Lấy danh sách sản phẩm theo loại và phân trang
    $sql_lietke = "SELECT productCode, productName, buyPrice, fileImage FROM products";
    if (!empty($product_type)) {
        $sql_lietke .= " WHERE type = '" . mysqli_real_escape_string($conn, $product_type) . "'";
    }
    $sql_lietke .= " ORDER BY productCode ASC LIMIT $item_per_page OFFSET $offset";
    $rows_lietke = mysqli_query($conn, $sql_lietke);

    

    if ($rows_lietke) {
        while ($row = mysqli_fetch_assoc($rows_lietke)) {
            echo "<a href='detailsProduct.php?id=" . htmlspecialchars($row['productCode'], ENT_QUOTES, 'UTF-8') . "'>";
            echo "<div class='squard_item'>";
            echo "<img src='../images/" . htmlspecialchars($row['fileImage'], ENT_QUOTES, 'UTF-8') . "' width='188' height='200'><br>";
            echo "</div>";
            echo "<span class='squard_item_prodcutName'>";
            echo htmlspecialchars($row['productName'], ENT_QUOTES, 'UTF-8') . "<br>" . number_format($row['buyPrice'], 0, ',', '.') . " VNĐ";
            echo "</span>";
            echo "</a>";
        }
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }

    
?>