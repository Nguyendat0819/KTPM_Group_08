<?php 
require 'connect.php';

if (!isset($_GET['province_id'])) {
    echo json_encode([
        ['id' => null, 'name' => 'Chưa có tỉnh/thành phố được chọn']
    ]);
    exit;
}

$province_id = (int)$_GET['province_id'];  // Ép kiểu để tránh SQL Injection

$sql = "SELECT * FROM `district` WHERE `province_id` = {$province_id}";
$result = mysqli_query($conn, $sql);

$data = [
    ['id' => null, 'name' => 'Chọn một Quận/huyện']
];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['district_id'],
            'name' => $row['name']
        ];
    }
}

echo json_encode($data);
?>
