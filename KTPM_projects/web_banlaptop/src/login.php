
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <header>
        <section class = "top-heading">
        <div class = "logo">
            <div class ="logo">
                <a href="/website/KTPM_projects/web_banlaptop/src/home.php">
                    <img src="../assets/logo.webp" alt="Logo" title="Trang chủ">
                </a>
            </div>
        </div>
    </section>
    </header>
    <div class = "body-login">
        <div class="login-display">
            <h1>Đăng nhập</h1>
            <div class ="sp-sign-up">
                <span>Bạn không có tài khoản?</span>
                <a href="/website/KTPM_projects/web_banlaptop/src/sign-up.php">Đăng Ký</a>
            </div>
            <div class="login-form">
                <!-- tiến hành đăng nhập -->
                <?php 
                    session_start();
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $conn = mysqli_connect('localhost','root','','ktpm');
                        if(!$conn){
                            die("faile".mysqli_connect_error());
                        }

                        $res = mysqli_query($conn, "SELECT userName FROM customer");
                        while($row = mysqli_fetch_assoc($res)){
                            // echo "[" . $row['userName'] . "]<br>";
                        }
                        $userName = trim($_POST['userName']);
                        // var_dump($userName);
                        $password = trim($_POST['password']);
                        // echo"$password";

                        
                        $sql = "SELECT * FROM customer WHERE userName  = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $userName);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        // var_dump($result->num_rows);
                        if($result->num_rows > 0){
                            $found = false;
                            while($user = $result->fetch_assoc()){
                                if($password == trim($user['password'])){
                                    $_SESSION['logged_in'] = true;
                                    $_SESSION['userName'] = $user['userName'];
                                    $_SESSION['customerName'] = $user['customerName'];
                                    $_SESSION['customerNumber'] = $user['customerNumber'];
                                    if($user['userName'] == 'admin' && $user['password'] == 'Admin123@'){
                                        header("Location: /website/KTPM_projects/web_banlaptop/src/admin/admin.php");
                                    } else {
                                        header("Location: homeuser.php");
                                    }
                                    exit();
                                }
                            }
                            echo "<script>alert('Sai mật khẩu');</script>";
                        } else {
                            echo "<script>alert('Tài khoản không tồn tại')</script>";
                        }
                    }
                ?>
                <form action="" method="POST">
                    <div class="input-field">
                        <input type="text" id="userName" placeholder="Tên đăng nhập" name="userName" required>
                    </div>
                    <div class="input-field" style="position: relative;">
                        <input type="password" id="password" placeholder="Mật khẩu" name="password" required style="padding-right: 40px;">
                        <img src="../assets/login/eye-opened.png" alt="Show Password" class="eye-icon">
                    </div>
                <button type="submit">Đăng nhập</button>
            </form>
            </div>
        </div>
    </div>
    <div class = "term-of-use">
        <div class="term-of-use-content">
            <p class="data-hook">*Bằng cách đăng nhập, bạn đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi.</p>
            <p class="data-hook">Nếu bạn gặp bất kỳ vấn đề nào trong quá trình đăng nhập, vui lòng liên hệ với chúng tôi qua <a href="#">trung tâm hỗ trợ</a>.</p>
            <p class="data-hook">Chúng tôi sử dụng cookie để cải thiện trải nghiệm của bạn trên trang web. Bằng cách tiếp tục sử dụng trang web, bạn đồng ý với việc sử dụng cookie của chúng tôi.</p>
        </div>
    </div>
</body>
<script>
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.querySelector(".eye-icon");

    let passwordVisible = false;

    eyeIcon.addEventListener("click", () => {
        passwordVisible = !passwordVisible;
        if (passwordVisible) {
            passwordInput.type = "text";
            eyeIcon.src = "../assets/login/eye-closed.jpg"; // Mắt đóng
            eyeIcon.alt = "Ẩn mật khẩu";
        } else {
            passwordInput.type = "password";
            eyeIcon.src = "../assets/login/eye-opened.png"; // Mắt mở
            eyeIcon.alt = "Hiện mật khẩu";
        }
    });
</script>
</html>