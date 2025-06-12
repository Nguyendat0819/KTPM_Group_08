<?php
    include 'connectadmin.php';
    include 'admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admins.css">
</head>
<body>
    <div class="wrapper_contain">
        <div class="head"></div>
        <div class="body">
            <div class="body_head">
                <h1>Thêm sản phẩm </h1>
            </div>
            <div class="body_content">
                <div class="form_uplpoad">
                    <form action="" method="post">
                        <div class="input_products">
                            <input type="text" placeholder="Tên sản phẩm: " class="input_upload" name="productName" autocapitalize="off">
                        </div>
                        <div class="input_products">
                            <input type="text" name="buyPrice" id="" placeholder="Nhập số tiền: " autocapitalize="off" class="input_upload">
                        </div>
                        <div class="input_products">
                            <input type="number" name="qualityStock" id="" placeholder="Nhập số lượng" autocapitalize="off" class="input_upload" min="1">
                        </div>
                        <div class="input_products">
                            <input type="text" name="type" placeholder="Nhập loại sản phẩm: " autocomplete="off"  class="input_upload">
                        </div>
                        <div class="input_image_products">
                            <input type="file" name="fileImage" id="" placeholder="Nhập file ảnh vào đây">
                        </div>
                        <div class="input_products_submit">
                            <input type="submit" value="Thêm Sản Phẩm">
                        </div>
                    </form>

                    <?php
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $productName = $_POST['productName'] ?? '';
                            $buyPrice = $_POST['buyPrice'] ?? '';
                            $qualityStock = $_POST['qualityStock'] ?? '';   
                            $fileImage = $_POST['fileImage'] ?? '';
                            $type = $_POST['type'] ?? '';   
                            echo $productName;
                            echo "<br>";
                            echo $buyPrice;
                            echo "<br>";
                            echo $qualityStock;
                            echo "<br>";
                            echo $fileImage;
                            echo "<br>";
                            echo $type;
                            echo "<br>";
                            if( !empty($productName) && !empty($buyPrice) && !empty($qualityStock) && !empty($fileImage) && !empty($type)){
                                $conn = mysqli_connect('localhost','root','','ktpm'); // Kết nối đến cơ sở dữ liệu
                                if($_SERVER["REQUEST_METHOD"] == "POST"){
                                    if (!$conn) {
                                    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
                                    }                
                                    
                                    $stmt = mysqli_prepare($conn, "INSERT INTO products(productName, buyPrice, qualityStock, fileImage,type) VALUES ( ?, ?, ?, ?, ?)");// Chuẩn bị câu lệnh SQL        
                                    if($stmt){
                                        mysqli_stmt_bind_param($stmt,"sssss", $productName, $buyPrice, $qualityStock,$fileImage,$type); // Gán các biến vào câu lệnh đã chuẩn bị
                                        if(mysqli_stmt_execute($stmt)){ // Thực thi câu lệnh đã chuẩn bị
                                            header("Location: admin.php?msg=success");
                                            exit();
                                        }else{
                                            echo "Thêm sản phẩm thất bại".mysqli_stmt_error($stmt); // In ra lỗi nếu có
                                        }
                                        mysqli_stmt_close($stmt); // Đóng câu lệnh đã chuẩn bị    
                                    }else{ 
                                        echo "Lỗi chuẩn bị câu lệnh: ".mysqli_error($conn); // In ra lỗi chuẩn bị câu lệnh
                                    }
                                }else{
                                    echo "Không có dữ liệu để thêm sản phẩm"; // In ra thông báo nếu không có dữ liệu
                                }
                            }else{
                                echo "Vui lòng điền đầy đủ thông tin sản phẩm"; // In ra thông báo nếu không có dữ liệu
                            }
                        }
                    ?>

                    <!-- viết hàm thông báo -->
                     <?php 
                        if(isset($_GET['msg']) && $_GET['msg'] === 'success'){
                            echo '<script>alert("Thêm sản phẩm thành công!");</script>';
                        }
                     ?>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</body>
</html>