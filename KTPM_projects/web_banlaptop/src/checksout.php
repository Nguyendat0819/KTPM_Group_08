<?php
    session_start(); 
    require 'connect.php';
    $sql = "SELECT * FROM province";
    $result = mysqli_query($conn, $sql);
    if (isset($_POST['add_sale'])) {
        echo "<pre>";
        print_r($_POST);
        die();
    }

    // Xử lý thêm vào giỏ hàng bằng AJAX
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $data = json_decode(file_get_contents('php://input'), true);

        $productCode = $data['productCode'] ?? '';
        $quantity = (int)($data['quantity'] ?? 1);

        // Lấy thông tin sản phẩm từ database
        $sql = "SELECT * FROM products WHERE productCode = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $productCode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        if ($product) {
            $customerNumber = $_SESSION['customerNumber'] ?? 'guest';
            $cartKey = 'cart_' . $customerNumber;

            $item = [
                'productCode' => $product['productCode'],
                'productName' => $product['productName'],
                'quantity' => $quantity,
                'price' => $product['buyPrice'],
                'type' => $product['type'] ?? 'Không xác định',
                'Imageproduct' => $product['fileImage'] ?? ''
            ];

            if (!isset($_SESSION[$cartKey])) {
                $_SESSION[$cartKey] = [];
            }

            // Nếu sản phẩm đã có trong giỏ thì cộng dồn số lượng
            $found = false;
            foreach ($_SESSION[$cartKey] as &$cartItem) {
                if ($cartItem['productCode'] === $productCode) {
                    $cartItem['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            unset($cartItem);

            if (!$found) {
                $_SESSION[$cartKey][] = $item;
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Không tìm thấy sản phẩm']);
        }
        exit;
    }

    // phần này sẽ xử lý việc xóa sản phẩm khỏi giỏ hàng


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="../css/user.css"> 
    <link rel="stylesheet" href="../css/checkout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script> 
    <script src="../js/app.js"></script>
</head>
<body>
    <header>
        <section class="top-heading">
            <div class="logo-search-user">
                <div class="logo">
                    <a href="homeuser.php" class="text-link" title="Trang chủ">
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
                    <a class="cart text-link" href="#" title="Xem giỏ hàng">
                        <img class="cart-icon" src="../assets/cart.png" alt="Giỏ hàng">
                        <span><b>Giỏ hàng</b></span>
                        <span class="count_holer">
                             <span class="count">
                                <?php
                                    $customerNumber = $_SESSION['customerNumber'] ?? ''; // Lấy customerNumber từ session
                                    $cartKey = 'cart_' . $customerNumber; // Tạo key session riêng cho từng người dùng
                                    $cart = $_SESSION[$cartKey] ?? [];
                                    $totalProducts = count($cart); // Đếm số sản phẩm trong giỏ hàng
                                    echo $totalProducts;
                                ?>
                             </span>                               
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </header>
    <div class="container">
        <div class="wrap">
            <div class="main">
                <div class="main_header">
                    <div class="header_logo" bis_skin_checked="1">
                        <div class="wrap-logo" itemscope="" itemtype="http://schema.org/Organization" bis_skin_checked="1">	
                            <a href="homeuser.php" aria-label="Eva De Eva" itemprop="url">
                               <img src="../assets/logo.webp" alt="Logo" title="Trang chủ" width="220" height="70">
                            </a>														
                        </div>
                    </div>
                </div>
                <div class="main_conttent">
                    <div class="section_header">
                        <h2 class="section_tittle">Thông tin giao hàng</h2>
                    </div>
                    <div class="section_conttent">
                        <form action="" method="post" id="myForm" class="mt-5">
                            <div class="file file_show_name">
                                <div class="file_input_wrapper">                                        
                                    <input 
                                    type="text"
                                    class="file_input file_input_name " 
                                    placeholder="Họ và tên" 
                                    autocomplete="off"
                                    size="30" 
                                    name="customerName">
                                    </div>                                    
                                </div>

                                <div class="file file_show_name">
                                    <div class="file_input_wrapper">                                        
                                        <input 
                                         type="text"
                                         class="file_input file_input_name "
                                         style="display: none"
                                         placeholder="customerNumber" 
                                         autocomplete="off"
                                         size="30" 
                                         name="customerNumber"  
                                         value="
                                            <?php 
                                                if (isset($_SESSION['customerNumber'])) {
                                                    echo htmlspecialchars($_SESSION['customerNumber'], ENT_QUOTES, 'UTF-8');
                                                } else {
                                                    // Nếu không có customerNumber trong session, có thể tạo mới hoặc để trống
                                                    echo '';
                                                }
                                            ?>
                                         ">
                                    </div>                                    
                                </div>
                                
                                <div class="file file_show_phone">
                                    <div class="file_input_wrapper">
                                        <input type="text" class="file_input file_input_phone" name="phone" placeholder="Số điện thoại" autocomplete="off">
                                    </div>
                                </div>
                                <div class="selection_address">
                                    <div class="row_add">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="province">Tỉnh/Thành phố</label>
                                                <select id="province" name="province_id" class="form-control">
                                                    <option value="">Chọn một tỉnh</option>
                                                    <!-- populate options with data from your database or API -->
                                                    <?php
                                                        if ($result) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                                <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                                                            <?php
                                                            }
                                                        } else {
                                                            echo '<option value="">Không có dữ liệu</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="district">Quận/Huyện</label>
                                                <select id="district" name="district_id" class="form-control">
                                                    <option value="">Chọn một quận/huyện</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="wards">Phường/Xã</label>
                                                <select id="wards" name="wards_id" class="form-control">
                                                    <option value="">Chọn một xã</option>
                                                </select>
                                            </div>											
                                        </div>
                                    </div>																
                                </div>
                                <div class="file file_show_address">
                                    <div class="file_input_wrapper">
                                        <input type="text" class="file_input file_input_address" name="addressHome" placeholder="Địa chỉ" autocomplete="off">
                                    </div>
                                </div>

                                <div class="file file_show_address">
                                    <div class="file_input_wrapper">
                                        <input type="text" class="file_input file_input_address" name="comment" placeholder="comment" autocomplete="off">
                                    </div>
                                </div>
                                <div class="file file_submit">
                                    <input type="submit" name="submit_products" value="Hoàn tất đơn hàng" class="submit_products" onclick="alert('Đặt hàng thành công!')">
                                </div>
                            </form>
                                <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_products'])) {
                                        // Lấy dữ liệu từ POST trước khi kiểm tra rỗng
                                        $customerName = $_POST['customerName'] ?? '';
                                        $customerNumber = $_POST['customerNumber'] ?? '';
                                        $phone = $_POST['phone'] ?? '';
                                        $addressHome = $_POST['addressHome'] ?? '';
                                        $comment = $_POST['comment'] ?? '';
                                        $province_id = isset($_POST['province_id']) ? (int)$_POST['province_id'] : 0;
                                        $district_id = isset($_POST['district_id']) ? (int)$_POST['district_id'] : 0;
                                        $wards_id = isset($_POST['wards_id']) ? (int)$_POST['wards_id'] : 0;

                                        // Kiểm tra các trường bắt buộc
                                        if (!empty($phone) && !empty($addressHome) && !empty($customerName) && !empty($customerNumber) && !empty($comment) && $province_id > 0 && $district_id > 0 && $wards_id > 0) {
                                            $conn = mysqli_connect('localhost', 'root', '', 'ktpm');
                                            if (!$conn) {
                                                die("Kết nối thất bại: " . mysqli_connect_error());
                                            }

                                            // 1. Thêm vào customeraddress
                                            $stmt = mysqli_prepare($conn, "INSERT INTO customeraddress (customerNumber, customerName, phone, addressHome, comment, province_id, district_id, wards_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                            if ($stmt) {
                                                mysqli_stmt_bind_param($stmt, "ssssssss", $customerNumber, $customerName, $phone, $addressHome, $comment, $province_id, $district_id, $wards_id);
                                                mysqli_stmt_execute($stmt);
                                                mysqli_stmt_close($stmt);
                                            }

                                            // 2. Thêm vào orders
                                            $orderDate = date('Y-m-d H:i:s');
                                            $status = 'Đang xử lý';
                                            $stmt = mysqli_prepare($conn, "INSERT INTO orders (customerNumber, orderDate, status) VALUES (?, ?, ?)");
                                            if ($stmt) {
                                                mysqli_stmt_bind_param($stmt, "iss", $customerNumber, $orderDate, $status);
                                                if (mysqli_stmt_execute($stmt)) {
                                                    $orderNumber = mysqli_insert_id($conn); // Lấy orderNumber vừa tạo
                                                }
                                                mysqli_stmt_close($stmt);
                                            }

                                            // 3. Thêm vào orderdetails
                                            $customerNumber = isset($_SESSION['customerNumber']) ? trim($_SESSION['customerNumber']) : '';
                                            $cartKey = 'cart_' . $customerNumber;
                                            $cart = $_SESSION[$cartKey] ?? [];

                                            // TÍNH TỔNG TIỀN NGAY ĐÂY
                                            $total = 0;
                                            foreach ($cart as $item) {
                                                $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                                                $price = isset($item['price']) ? (float)$item['price'] : 0.0;
                                                $total += $quantity * $price;
                                            }

                                            if (!empty($cart) && isset($orderNumber)) {
                                                foreach ($cart as $item) {
                                                    $productCode = isset($item['productCode']) ? (int)$item['productCode'] : 0;
                                                    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                                                    $price = isset($item['price']) ? (float)$item['price'] : 0.0;
                                                    $typeOrdered = isset($item['type']) ? trim($item['type']) : '';

                                                    // Kiểm tra dữ liệu trước khi thêm vào orderdetails
                                                    if ($productCode > 0 && $quantity > 0 && $price > 0 && !empty($typeOrdered)) {
                                                        $stmt = mysqli_prepare($conn, "INSERT INTO orderdetails (orderNumber, productCode, quantity, priceEach, typeOrdered) VALUES (?, ?, ?, ?, ?)");
                                                        if ($stmt) {
                                                            mysqli_stmt_bind_param($stmt, "iiids", $orderNumber, $productCode, $quantity, $price, $typeOrdered);
                                                            mysqli_stmt_execute($stmt);
                                                            mysqli_stmt_close($stmt);
                                                        } else {
                                                            error_log("Lỗi khi chuẩn bị báo cáo chi tiết đơn hàng: " . mysqli_error($conn));
                                                        }
                                                    } else {
                                                        error_log("Dữ liệu không hợp lệ cho orderdetails: productCode=$productCode, quantity=$quantity, price=$price, typeOrdered=$typeOrdered");
                                                    }
                                                }
                                            } else {
                                                error_log("Giỏ hàng trống hoặc orderNumber chưa được thiết lập.");
                                            }

                                            // 4. Thêm vào bảng payments (CHỈ 1 LẦN)
                                            $paymentDate = date('Y-m-d');
                                            $checkNumber = uniqid('PAY');
                                            $amount = $total;

                                            $stmt = mysqli_prepare($conn, "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount) VALUES (?, ?, ?, ?)");
                                            if ($stmt) {
                                                mysqli_stmt_bind_param($stmt, "issd", $customerNumber, $checkNumber, $paymentDate, $amount);
                                                mysqli_stmt_execute($stmt);
                                                mysqli_stmt_close($stmt);
                                            }


                                            // 5. Xóa giỏ hàng
                                            unset($_SESSION[$cartKey]);
                                            mysqli_close($conn);
                                            echo "<script>alert('Đặt hàng thành công!'); window.location.href='homeuser.php';</script>";
                                            exit;
                                            
                                        }
                                    }
                                ?>
                        </div>
                    </div>    
            </div>              
            <div class="sidebar">
                <div class="cart">
                    <h2>Giỏ hàng của bạn</h2>
                        <ul class="cart_items">
                            <?php
                                $customerNumber = $_SESSION['customerNumber'] ?? ''; // Lấy customerNumber từ session
                                $cartKey = 'cart_' . $customerNumber; // Tạo key session riêng cho từng người dùng
                                $cart = $_SESSION[$cartKey] ?? [];

                                if ($cart && count($cart) > 0) {
                                    foreach ($cart as $item) {
                                        echo '<li class="cart_item" style="margin-bottom: 65px;">';
                                        echo '<div class="item_name">' . htmlspecialchars($item['productName'] ?? 'Tên sản phẩm không xác định', ENT_QUOTES, 'UTF-8') . '</div>';
                                        echo '<div class="item_Image">';
                                        if (!empty($item['Imageproduct'])) {
                                            echo '<img src="../images/' . htmlspecialchars($item['Imageproduct'] ?? '', ENT_QUOTES, 'UTF-8') . '" alt="Hình ảnh sản phẩm" width="69" height="102">';
                                        } else {
                                            echo 'Hình ảnh không xác định';
                                        }
                                        echo '</div>';
                                        echo '<div class="item_quantity">Số lượng: ' . (int)($item['quantity'] ?? 0) . '</div>';
                                        echo '<div class="item_price">Giá: ' . htmlspecialchars(number_format($item['price'], 0, ',', '.'), ENT_QUOTES, 'UTF-8') . ' VND</div>';
                                        echo '<div class="item_type">Loại: ' . htmlspecialchars($item['type'] ?? 'Không xác định', ENT_QUOTES, 'UTF-8') . '</div>';
                                        echo '<button class="remove-item" data-code="' . htmlspecialchars($item['productCode'] ?? '', ENT_QUOTES, 'UTF-8') . '">Xóa</button>';
                                        echo '</li>';
                                    }
                                } else {
                                    echo '<li class="cart_item">Giỏ hàng của bạn đang trống.</li>';
                                }
                            ?>
                        </ul>
                        <div class="cart_total">
                            Tổng cộng: 
                            <?php
                                $total = 0;
                                foreach ($cart as $item) {
                                    $quantity = (int)($item['quantity'] ?? 0);
                                    $price = (float)($item['price'] ?? 0);
                                    $total += $quantity * $price;
                                }
                                echo number_format($total, 0, ',', '.') . ' VND';
                            ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/checksout.js"></script>
</html>