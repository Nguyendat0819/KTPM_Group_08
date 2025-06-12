<?php
session_start();
$customerNumber = $_SESSION['customerNumber'] ?? 'guest';
$cartKey = 'cart_' . $customerNumber;
$productCode = $_POST['remove_cart_item'] ?? null;

if (!isset($_SESSION[$cartKey]) || !is_array($_SESSION[$cartKey])) {
    $_SESSION[$cartKey] = [];
}
error_log('So sánh:');
foreach ($_SESSION[$cartKey] as $idx => $item) {
    error_log('So sánh "' . $item['productCode'] . '" === "' . $productCode . '" ? ' . ($item['productCode'] === $productCode ? 'ĐÚNG' : 'SAI'));
    error_log('item['.$idx.'][productCode]: ' . $item['productCode']);
}
error_log('productCode cần xóa: ' . $productCode);

$found = false;
foreach ($_SESSION[$cartKey] as $idx => $item) {
    // So sánh sau khi trim và ép kiểu về chuỗi
    if (trim((string)$item['productCode']) === trim((string)$productCode)) {
        unset($_SESSION[$cartKey][$idx]);
        $_SESSION[$cartKey] = array_values($_SESSION[$cartKey]);
        $found = true;
        break;
    }
}

if ($found) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Không tìm thấy sản phẩm']);
}
exit;