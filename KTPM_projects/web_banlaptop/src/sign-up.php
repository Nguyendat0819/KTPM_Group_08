<?php 
    include 'connect.php';

    // Function to sanitize input
    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/sign-up.css">
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
            <h1>Đăng ký</h1>
            <div class ="sp-sign-up">
                <span>Bạn đã có tài khoản?</span>
                <a href="/website/KTPM_projects/web_banlaptop/src/login.php">Đăng nhập</a>
            </div>
            <div class="login-form">
                <!-- hàm kiểm tra -->
                <?php
                    $customerName = $email = $userName = $password = $repeat_password = $date = $gender = ""; 
                    $ErrcustomerName = $Erremail = $ErruserName = $Errpassword = $Errrepeat_password = $Errdate = $Errgender = "";
                        

                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        // hàm kiể tra họ và tên 
                        if(empty($_POST["customerName"])){
                            $ErrcustomerName = "Yêu cầu nhập tên";
                        }else{
                            $customerName = test_input($_POST["customerName"]);
                            if (!preg_match("/^[\p{L}\s'-]+$/u", $customerName)) {
                                $ErrcustomerName = "Chỉ cho phép chữ cái và khoảng trắng";
                            }
                        }

                        // kiểm tra email

                        if(empty($_POST["email"])){
                            $Erremail = "Yêu cầu nhập email";
                        }else{
                            $email = test_input($_POST["email"]);
                            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                                $Erremail = "Lỗi format";
                            }
                        }

                        // kiểm tra userName 

                        if(empty($_POST["userName"])){
                            $ErruserName = "Yêu cầu nhập tên đăng nhập";
                        } else {
                            $userName = test_input($_POST["userName"]);
                            if (!preg_match("/^[a-zA-Z0-9_]{5,20}$/", $userName)) {
                                $ErruserName = "Tên đăng nhập chỉ chứa chữ cái, số, dấu gạch dưới và dài từ 5 đến 20 ký tự.";
                            }
                        }

                        // kiểm tra mk
                        if(empty($_POST["password"])){
                            $passwordErr = "Xin nhập mật khẩu";
                        } else {
                            $password = test_input($_POST["password"]);
                            $validationErrors = validate_password($password);

                            if(!empty($validationErrors)){
                                $passwordErr = implode("<br>", $validationErrors);
                            } else {
                                $passwordErr = ""; 
                            }
                        }
                        // kiểm tra lại mk 
                        $repeat_password = test_input($_POST["repeat_password"]);

                        if(empty($repeat_password)){
                             $Errrepeat_password = "Vui lòng nhập lại mật khẩu";
                        } elseif($password !== $repeat_password){
                             $Errrepeat_password = "Mật khẩu không khớp";
                        }

                        // kiểm tra date
                        if(empty($_POST["date"])){
                            $date = "";
                        }else{
                            $date = test_input($_POST["date"]);
                        }   

                        // kiểm tra gender
                        if (empty($_POST["gender"])) {
                            $Errgender = "Vui lòng chọn giới tính";
                        } else {
                            $gender = test_input($_POST["gender"]);
                            if ($gender !== "male" && $gender !== "female") {
                                $Errgender = "Giới tính không hợp lệ";
                            }
                        }
                    }
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }

                    function validate_password($password) {
                        $errors = [];
                        if (strlen($password) < 8) {
                            $errors[] = "Mật khẩu phải có ít nhất 8 ký tự.";
                        }
                        if (!preg_match('/[A-Z]/', $password)) {
                            $errors[] = "Mật khẩu phải chứa ít nhất một chữ cái viết hoa.";
                        }
                        if (!preg_match('/[a-z]/', $password)) {
                            $errors[] = "Mật khẩu phải chứa ít nhất một chữ cái viết thường.";
                        }
                        if (!preg_match('/[0-9]/', $password)) {
                            $errors[] = "Mật khẩu phải chứa ít nhất một chữ số.";
                        }
                        if (!preg_match('/[\W]/', $password)) {
                            $errors[] = "Mật khẩu phải chứa ít nhất một ký tự đặc biệt.";
                        }
                         return $errors;
                    }
                 ?>
                <form action="" method="POST">
                    <div class="input-field">
                        <input type="text" placeholder="Họ và tên" name="customerName" required>
                        <span class="Err"><?php echo $ErrcustomerName;?></span>
                    </div>

                    <div class="input-field">
                        <input type="email" placeholder="Email" name="email" required>
                        <span class="Err"><?php echo $Erremail;?></span>
                    </div>

                    <div class="input-field">
                        <input type="text" placeholder="Tên đăng nhập" name="userName" required>
                        <span class="Err"><?php echo $ErruserName;?></span>
                    </div>

                    <div class="input-field" style="position: relative;">
                        <input type="password" id="password" placeholder="Mật khẩu" name="password" required style="padding-right: 40px;">
                        <img src="../assets/login/eye-opened.png" alt="Hiện mật khẩu" class="eye-icon">
                        <span class="Err"><?php echo $Errpassword;?></span>
                    </div>

                    <div class="input-field" style="position: relative;">
                        <input type="password" id="repeat_password" placeholder="Nhập lại mật khẩu" name="repeat_password" required style="padding-right: 40px;">
                        <img src="../assets/login/eye-opened.png" alt="Hiện mật khẩu" class="eye-icon">
                        <span class="Err"><?php echo $Errrepeat_password;?></span>
                    </div>

                    <div class="input-field">
                        <input type="date" name="date" required>
                        <span class="Err"><?php echo $Errdate; ?></span>
                    </div>

                    <div class="gender">
                        <label><input type="radio" name="gender" value="male" checked> Nam</label>
                        <label><input type="radio" name="gender" value="female"> Nữ</label>
                        <span class="Err"><?php echo $Errgender;?></span>
                    </div>

                    <button type="submit">Đăng Ký</button>
                </form>
                <?php 
                    if($_SERVER["REQUEST_METHOD"] == "POST"){                        
                        if(
                            !empty($customerName) && 
                            !empty($email) && 
                            !empty($userName) && 
                            !empty($password) &&
                            !empty($repeat_password) &&
                            ($password === $repeat_password) &&
                            !empty($date) &&
                            !empty($gender)
                        ){
                            $conn = mysqli_connect('localhost','root','','ktpm');
                            if($_SERVER["REQUEST_METHOD"] == "POST"){                
                                $customerName = $_POST['customerName'] ?? '';
                                $email = $_POST['email'] ?? '';
                                $userName = $_POST['userName'] ?? '';
                                $password = $_POST['password'] ?? '';
                                $date = $_POST['date'] ?? '';
                                $gender = $_POST['gender'] ?? '';
                                $stmt = mysqli_prepare($conn, "INSERT INTO customer(customerName,email,userName,password,date,gender) VALUES(? , ? , ?, ? , ?, ?)");
                                    if($stmt){
                                        mysqli_stmt_bind_param($stmt,"ssssss", $customerName,$email, $userName,$password,$date,$gender);
                                        if(mysqli_stmt_execute($stmt)){
                                            echo"them du lieu thanh cong";
                                               
                                        }else{
                                            echo"lỗi khi thực hiện câu lệnh". mysqli_stmt_errno($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                    }else{
                                        echo"Lỗi chuẩn bị truy vấn".mysqli_error($conn);
                                    }
                                mysqli_close($conn);
                            }
                        }else{
                            echo"Không khớp dữ liệu";
                            echo $customerName;
                            echo "<br>";
                            echo $email;
                            echo "<br>";
                            echo $userName;
                             echo "<br>";
                            echo $password;
                             echo "<br>";
                            echo $repeat_password;
                             echo "<br>";
                            echo $date;
                             echo "<br>";
                            echo $gender;
                        }

                    }
                ?>
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
    const eyeIcons = document.querySelectorAll(".eye-icon");

    eyeIcons.forEach((icon, index) => {
        const input = icon.previousElementSibling;

        let visible = false;

        icon.addEventListener("click", () => {
            visible = !visible;
            if (visible) {
                input.type = "text";
                icon.src = "../assets/login/eye-closed.jpg";
                icon.alt = "Ẩn mật khẩu";
            } else {
                input.type = "password";
                icon.src = "../assets/login/eye-opened.png"; 
                icon.alt = "Hiện mật khẩu";
            }
        });
    });
</script>
</html>