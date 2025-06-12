<?php 
    session_start(); 
     // Kết nối đến file lietke.php
    $conn = mysqli_connect('localhost','root','','ktpm'); // Kết nối đến cơ sở dữ liệu
    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error()); // Kiểm tra kết nối
    }
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Lấy ID từ URL
    if($id > 0){
        $sql = "SELECT * FROM products WHERE productCode = $id LIMIT 1";
        $result = mysqli_query($conn,$sql); // Thực thi câu lệnh SQL
        if($result && mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result); // Lấy dữ liệu sản phẩm
            // echo "<h2>Chi tiết sản phẩm</h2>";
            // echo "<img src='../images/" . htmlspecialchars($row['fileImage']) . "' width='100'><br>";
            // echo "Mã sản phẩm: " . htmlspecialchars($row['productCode']) . "<br>";
            // echo "Tên sản phẩm: " . htmlspecialchars($row['productName']) . "<br>";
            // echo "Giá sản phẩm: " . htmlspecialchars($row['buyPrice']) . "<br>";
            // echo "Số lượng: " . htmlspecialchars($row['qualityStock']) . "<br>";
            // echo "Loại sản phẩm: " . htmlspecialchars($row['type']) . "<br>";            
            // echo "<a href='admin.php'>Quay lại</a>"; // In ra thông báo thành công
        }else{
            echo "Không tìm thấy sản phẩm.";
        }
    }else{
        echo "ID không hợp lệ.";
    }
    mysqli_close($conn); // Đóng kết nối
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/user.css"> 
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/detailsProduct.css"> 
</head>
<body>
    <header>
        <section class="top-heading">
            <div class="logo-search-user">
                <div class="logo">
                    <a href="../src/homeuser.php">
                        <img src="../assets/logo.webp" alt="Logo" title="Trang chủ">
                    </a>
                </div>
                <div class="quick-for-user">
                    <div class="search">
                        <div class="search-box">
                            <form>
                                <div class="search-background">
                                    <input class="input-search" type="text" placeholder="Bạn muốn tìm kiếm gì?">
                                    <button class="search-button" type="submit" title="Tìm kiếm">
                                        <img src="../assets/search-icon.png" alt="Tìm kiếm" class="search-icon-img">
                                        <span>Tìm kiếm</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="search-suggest"></div>
                    </div>
                    <a class="hotline text-link" href="tel:1234.5678" title="Nhấn để gọi">
                        <img class="hotline-icon" src="../assets/hotline.png" alt="Hotline">
                        <span>1234 5678</span>
                    </a>
                    <div class="account_inner">
                        <a class="user text-link" title="Truy cập tài khoản" href="">
                            <img class="user-icon" src="../assets/user.png" alt="Tài khoản">
                            <span><b>Tài khoản</b></span>
                        </a>
                        <div class="account_inner_user">
                            <div class="account_conntent">
                                <div class="account_list">
                                    <div class="account_title">
                                        <div class="account_title_header">
                                            <p class="txt_title" style="text-align: center;">THÔNG TIN TÀI KHOẢN</p>
                                        </div>
                                    </div>
                                    <div class="account_block">
                                        <ul>
                                            <li class="user_name">
                                                <span>
                                                    <?php 
                                                        // session_start(); // Bắt đầu phiên 
                                                        if (isset($_SESSION['customerName'])) {
                                                            echo htmlspecialchars($_SESSION['customerName'], ENT_QUOTES, 'UTF-8');
                                                        } else {
                                                            echo 'Guest';
                                                        }
                                                    ?>
                                                </span>
                                            </li>
                                            <li>
                                                <a href="">Tài khoản của tôi</a>
                                            </li>
                                            <li>
                                                <a href="home.php">Đăng xuất</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="cart text-link" href="checksout.php" title="Xem giỏ hàng">
                        <img class="cart-icon" src="../assets/cart.png" alt="Giỏ hàng">
                        <span><b>Giỏ hàng</b></span>
                        <span class="count_holer">
                             <span class="count" style="width:21px">
                                <?php
                                    if(isset($_SESSION['customerNumber']) && !empty($_SESSION['customerNumber'])) {
                                        $customerNumber = $_SESSION['customerNumber']; // Lấy customerNumber từ session
                                        $cartKey = 'cart_' . $customerNumber; // Tạo key session riêng cho từng người dùng
                                        $cart = $_SESSION[$cartKey] ?? [];
                                        $totalProducts = count($cart); // Đếm số sản phẩm trong giỏ hàng
                                        echo $totalProducts > 0 ? $totalProducts : 0; // Nếu không có sản phẩm, hiển thị 0
                                    } else {
                                        echo 0; // Nếu chưa đăng nhập hoặc customerNumber không hợp lệ, giỏ hàng mặc định là 0
                                    }
                                    
                                ?>
                             </span>                               
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </header>
    <div class="body">
        <div class="product_detail_container">
            <div class="product_detail_left">
                <img src="../images/<?php echo isset($row['fileImage']) ? htmlspecialchars($row['fileImage'], ENT_QUOTES, 'UTF-8') : 'default.jpg'; ?>" alt="<?php echo isset($row['productName']) ? htmlspecialchars($row['productName'], ENT_QUOTES, 'UTF-8') : 'No Name'; ?>" class="product_detail_image">
                <!-- Có thể thêm slider ảnh nếu có nhiều ảnh -->
            </div>
            <div class="product_detail_right">
                <h1>
                    <?php
                        if (isset($row)) {
                            echo "" . htmlspecialchars($row['productName']);
                        } else {
                            echo "Thông tin sản phẩm không khả dụng.";
                        }
                    ?>
                </h1>
                <div class="product_detail_wrapper">
                    <div class="product_meta">
                        <span class="product_meta_borderright">
                            <?php
                                if (isset($row)) {
                                    echo "" . htmlspecialchars($row['productCode']);
                                } else {
                                    echo "Thông tin sản phẩm không khả dụng.";
                                }
                            ?>
                        </span> 
                        
                        <span>Thương hiệu: The Computer Shop</span>
                    </div>
                    <div class="product_price">
                        <span class="price">
                            <?php
                                if (isset($row)) {
                                    echo "" . htmlspecialchars(number_format($row['buyPrice'], 0, ',', '.'), ENT_QUOTES, 'UTF-8') . " VNĐ";
                                } else {
                                    echo "Thông tin sản phẩm không khả dụng.";
                                }
                            ?>
                        </span>
                    </div>
                    <div class="product_options">
                        <div class="option">
                            <label>Số lượng:</label>
                            <button class="button_detail button_detail_left">
                                <svg focusable="false" class="icon icon--minus " viewBox="0 0 10 2" role="presentation">
                                    <path d="M10 0v2H0V0z"></path>
                                </svg>
                            </button>
                            <input type="text" value="1" style="width: 40px; text-align: center;" class="qty_val">
                            <button class="button_detail button_detail_right">
                                <svg focusable="false" class="icon icon--plus " viewBox="0 0 10 10" role="presentation">
                                    <path d="M6 4h4v2H6v4H4V6H0V4h4V0h2v4z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="quality_now">
                            <div class="quality_now_inner">
                                    <span style="font-size:18px">
                                       <?php
                                            if (isset($row)) {
                                                echo "" . htmlspecialchars($row['qualityStock']);
                                            } else {
                                                echo "Thông tin sản phẩm không khả dụng.";
                                            }
                                        ?>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="product_actions">
                        <button 
                            class="add_to_cart"
                            data-product-code="<?php echo htmlspecialchars($row['productCode'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-cart-add-url="checksout.php"
                        >
                            THÊM VÀO GIỎ
                        </button>
                        <!-- <button 
                            class="buy_now"
                            data-product-code="<?php echo htmlspecialchars($row['productCode'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-buy-now-url="checkout.php"
                        >
                            MUA NGAY
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/detailsProducts.js"></script>
</html>