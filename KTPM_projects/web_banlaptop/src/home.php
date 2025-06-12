
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
</head>
<body>
    <header>
        <section class = "top-heading">
        <div class = "logo-search-user">
            <div class ="logo">
                <a href="home.php">
                    <img src="../assets/logo.webp" alt="Logo" title="Trang chủ">
                </a>
            </div>
            <div class = "quick-for-user">
            <div class ="search">
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
                <div class = "search-suggest">
                </div>
            </div>
            <a class ="hotline text-link" href="tel:1234.5678" title="Nhấn để gọi" href="#">
                <img class ="hotline-icon" src="../assets/hotline.png" alt="Hotline">
                <span>1234 5678</span>
            </a>
            <a class ="user text-link" href="./login.php" title="Truy cập tài khoản" href="#">
                <img class ="user-icon" src="../assets/user.png" alt="Tài khoản">
                <span><b>Tài khoản</b></span>
            </a>
            <a class="cart text-link" href="" title="Xem giỏ hàng">
                <img class = "cart-icon" src="../assets/cart.png" alt="Giỏ hàng">
                <span><b>Giỏ hàng</b></span>
            </a>
            </div>
        </div>
    </section>
    </header>
    <div class = "w-container body-wrapper">
        <div class = "wrapper">
            <div class = "wrapper">
                <div class = "nav-full">
                    <nav>
                        <h2>Danh mục</h2>
                        <ul class="root" type="none">
                            <li><a class="label" href="homeUser.php?type=Mac" target="_self">
                                <img class="icon" src="../assets/laptop/apple.png" alt="apple" title="Mac">
                                Mac</a></li>
                            <li><a class="label" href="homeUser.php?type=ASUS" target="_self">
                                <img class="icon" src="../assets/laptop/asus.png" alt="asus" title="ASUS">
                                ASUS</a></li>
                            <li><a class="label" href="homeUser.php?type=Lenovo" target="_self">
                                <img class="icon" src="../assets/laptop/Lenovo.png" alt="lenovo" title="Lenovo">
                                Lenovo</a></li>
                            <li><a class="label" href="homeUser.php?type=Dell" target="_self">
                                <img class="icon" src="../assets/laptop/dell.png" alt="dell" title="Dell">
                                Dell</a></li>
                            <li><a class="label" href="homeUser.php?type=HP" target="_self">
                                <img class="icon" src="../assets/laptop/HP.png" alt="hp" title="HP">
                                HP</a></li>
                            <li><a class="label" href="homeUser.php?type=Acer" target="_self">
                                <img class="icon" src="../assets/laptop/Acer.png" alt="acer" title="Acer">
                                Acer</a></li>
                            <li><a class="label" href="homeUser.php?type=LG" target="_self">
                                <img class="icon" src="../assets/laptop/LG.png" alt="lg" title="LG">
                                LG</a></li>
                            <li><a class="label" href="homeUser.php?type=Huawei" target="_self">
                                <img class="icon" src="../assets/laptop/Huawei.png" alt="huawei" title="Huawei">
                                Huawei</a></li>
                            <li><a class="label" href="homeUser.php?type=MSI" target="_self">
                                <img class="icon" src="../assets/laptop/msi.png" alt="msi" title="MSI">
                                MSI</a></li>
                            <li><a class="label" href="homeUser.php?type=Gigabyte" target="_self">
                                <img class="icon" src="../assets/laptop/gigabyte.png" alt="gigabyte" title="Gigabyte">
                                Gigabyte</a></li>
                        </ul>
                    </nav>
                    <nav></nav>
                </div>
                <div class ="right-content">
                    <div class="container">
                        <div class="container_list">
                            <div class="wrapper_colum">
                                <div class="squard">
                                    <?php 
                                        $conn = mysqli_connect('localhost','root','','ktpm'); // Kết nối đến cơ sở dữ liệu
                                        if(!$conn){
                                            die("Kết nối cơ sở dữ liệu thất bại".mysqli_connect_error());
                                        }
                                        $item_per_page = !empty($_GET['per_page']) ?$_GET['per_page']:15;
                                        $current_page = !empty($_GET['page'])?$_GET['page']:1;
                                        $offset = ($current_page - 1) * $item_per_page;

                                        // truy vấn tổn số sản phẩm để tính số trang
                                        $total_result = mysqli_query($conn, "SELECT COUNT(*) AS total from products"); //tổng số 
                                        $total_row = mysqli_fetch_assoc($total_result); // bên trong là mảng 
                                        $total_items = $total_row['total']; // lấy dòng cuối của products là tổng số lượng ví dụ như 97 sản phẩm
                                        $totalPage = ceil($total_items / $item_per_page); // tính số trang
                                        $sql_lietke = "SELECT productCode, productName, buyPrice, fileImage FROM products ORDER BY productCode ASC LIMIT $item_per_page  OFFSET $offset";                           
                                        $rows_lietke = mysqli_query($conn, $sql_lietke);
                                        
                                        if($rows_lietke){
                                            while($row = mysqli_fetch_assoc($rows_lietke)){
                                                echo"<a href='detailsProduct.php?id=".$row['productCode']."'>";
                                                echo "<div class='squard_item'>";
                                                echo "<img src='../images/" . $row['fileImage'] . "' width='188' height ='200' ><br>";
                                                echo "</div>";
                                                echo"<span class='squard_item_prodcutName'>";
                                                echo $row['productName']. "<br>". number_format($row['buyPrice'], 0, ',', '.')." VNĐ";
                                                echo"</span>";
                                                echo"</a>";                                
                                            }
                                        }else{
                                            echo "Lỗi truy vấn: ".mysqli_error($conn);
                                        }

                                        // hiển thị trang 
                                    ?>
                            
                                </div>
                            </div>
                        </div>

                        <!-- phần điều hướng -->

                        <div class="page">
                            <div class="list_page">
                                <!--Nút bên trái  -->
                                <?php if($current_page >= 1): ?>
                                    <a class="page_conttroler page_conttroler_left button_icon_nav" href="?page=<?= $current_page - 1 ?>&per_page=<?= $item_per_page ?>">
                                        <svg class="shopee-svg-icon icon-arrow-left" viewBox="0 0 11 11"><g><path d="m8.5 11c-.1 0-.2 0-.3-.1l-6-5c-.1-.1-.2-.3-.2-.4s.1-.3.2-.4l6-5c .2-.2.5-.1.7.1s.1.5-.1.7l-5.5 4.6 5.5 4.6c.2.2.2.5.1.7-.1.1-.3.2-.4.2z"/></g></svg>
                                    </a>
                                <?php endif ;?>
                            
                                <div class="pagination">
                                    <?php
                                    for ($i = 1; $i <= $totalPage; $i++) {
                                        if ($i == $current_page) {
                                            echo "<span class='page_button current'>$i</span>";
                                        } else {
                                            echo "<a href='?page=$i&per_page=$item_per_page' class='page_button'>$i</a>";
                                        }
                                    }
                                    ?>
                                </div>

                                <!-- Nút mũi tên phải -->
                                <?php if ($current_page <=   $totalPage): ?>
                                    <a class="page_conttroler page_conttroler_right button_icon_nav" href="?page=<?= $current_page + 1 ?>&per_page=<?= $item_per_page ?>">
                                        <svg class="shopee-svg-icon icon-arrow-right" viewBox="0 0 11 11"><path d="m2.5 11c .1 0 .2 0 .3-.1l6-5c .1-.1.2-.3.2-.4s-.1-.3-.2-.4l-6-5c-.2-.2-.5-.1-.7.1s-.1.5.1.7l5.5 4.6-5.5 4.6c-.2.2-.2.5-.1.7.1.1.3.2.4.2z"/></path></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="bg">
            <div class="col-content">
                <div class="link-content">
                    <h4 style="font-size: 16px;">Hỗ trợ - dịch vụ</h4>
                    <ul type="none" class="list-link">
                        <li><a class="list-care" href="#">Chính sách và hướng dẫn mua hàng trả góp</a></li>
                        <li><a class="list-care" href="#">Hướng dẫn mua hàng và chính sách vận chuyển</a></li>
                        <li><a class="list-care" href="#">Tra cứu đơn hàng</a></li>
                        <li><a class="list-care" href="#">Chính sách đổi mới và bảo hành</a></li>
                        <li><a class="list-care" href="#">Dịch vụ bảo hành mở rộng</a></li>
                        <li><a class="list-care" href="#">Chính sách bảo mật</a></li>
                        <li><a class="list-care" href="#">Chính sách giải quyết khiếu nại</a></li>
                        <li><a class="list-care" href="#">Quy chế hoạt động</a></li>
                        <li><a class="list-care" href="#">Chương trình Hoàng Hà Edu</a></li>
                    </ul>
                </div>
                <div class="link-content">
                    <h4 style="font-size: 16px;">Thông tin liên hệ</h4>
                    <ul type="none" class="list-link">
                        <li><a class="list-care" href="#">Thông tin các trang TMĐT</a></li>
                        <li><a class="list-care" href="#">Chăm sóc khách hàng</a></li>
                        <li><a class="list-care" href="#">Dịch vụ sửa chữa</a></li>
                        <li><a class="list-care" href="">Khách hàng doanh nghiệp (B2B)</a></li>
                        <li><a class="list-care" href="">Tuyển dụng</a></li>
                        <li><a class="list-care" href="">Tra cứu bảo hành</a></li>
                    </ul>
                </div>
                <div style="font-family: 'Roboto', sans-serif;">
                    <h4 style="font-size: 16px;">Thanh toán miễn phí</h4>
                    <ul type="none" class="list-card list-link">
                            <img src="../assets/card/visa.png" alt="Visa" title="Thanh toán bằng thẻ Visa">
                            <img src="../assets/card/mastercard.png" alt="MasterCard" title="Thanh toán bằng thẻ MasterCard">
                            <img src="../assets/card/jcb.png" alt="JCB" title="Thanh toán bằng thẻ JCB">
                            <img src="../assets/card/applepay.png" alt="APPLEPAY" title="Thanh toán bằng thẻ Apple Pay">
                            <img src="../assets/card/samsungpay.png" alt="PayPal" title="Thanh toán bằng PayPal">
                            <img src="../assets/card/zalopay.png" alt="ZaloPay" title="Thanh toán bằng ZaloPay">
                            <img src="../assets/card/vnpay.png" alt="VNPay" title="Thanh toán bằng VNPay">
                        </li>
                    </ul>
                    <div>
                        <h4 style="font-size: 16px;">Hình thức vận chuyển</h4>
                        <ul type="none" class="list-logo list-link">
                            <li>
                                <img src="../assets/deliver/nhattin.png" alt="NHATTIN">
                                <img src="../assets/deliver/vnpost.png" alt="VNPOST" >
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="support">
                    <h4 style="font-size: 16px ;">Tổng đài</h4>
                    <a class="phone-number" href="tel:1234.5678">1234.5678</a>
                    <div style="font-size: 14px;">(Từ 8h30-21h30)</div>
                </div>
                <div class="support">
                    <h4 style="font-size: 16px;">Kết nối với chúng tôi</h4>
                    <ul type="none" style="display:flex; gap:4px" class="list-link">
                        <li><a href="#" target="_blank" class="footer-social-item"><img src="../assets/social/fb.png"></a></li>
                        <li><a href="#" target="_blank" class="footer-social-item"><img src="../assets/social/tt.png"></a></li>
                        <li><a href="#" target="_blank" class="footer-social-item"><img src="../assets/social/inst.png"></li>
                        <li><a href="#" target="_blank" class="footer-social-item"><img src="../assets/social/yt.png"></li>
                        <li><a href="#" target="_blank" class="footer-social-item"><img src="../assets/social/thr.png"></li>
                    </ul>
                    <div class="mg-top20">
                    <a href="http://online.gov.vn/Home/WebDetails/28738" target="_blank"><img src="../assets/social/logo-bct.png"></a>
                </div>
                </div>
            </div>
            <div class="info">
                <p>© 2023 Laptop Store. Bản quyền thuộc về Công ty TNHH Laptop Store. Công ty cổ phần thương mại Laptop Store.</p>
                <p>Địa chỉ: Số 123, Đường ABC, Quận XYZ, TP. Hà Nội, Việt Nam. Điện thoại: 1234.5678.</p>
                <p>Email: <a href="mailto:laptopstore@gmail.com" style="color:white">laptopstore@gmail.com</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
