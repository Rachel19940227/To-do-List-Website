<?php
session_start(); 

$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'assignment2'; 

// 创建数据库连接
$conn = new mysqli($host, $user, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // 如果连接失败，则输出错误信息并终止程序执行
}

$loginError = ''; // 初始化登录错误消息

// 检查表单是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password'];

    // 检查用户名是否已存在
    $checkUser = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) { // 如果用户名已存在
        $loginError = "Username already exists"; 
    } else {
        // 插入新用户数据到数据库
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) { // 如果插入成功
            // 注册成功，重定向到登录页面
            header('Location: ../server/login.php');
            exit(); // 终止后续执行
        } else {
            $loginError = "Error: Registration failed"; // 设置注册失败的错误消息
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="sign-up" content="sign-up">
    <title>sign-up</title>
    
</head>
<body>
<form action="../server/sign-up.php" method="post" onsubmit="return validate();">
<?php include ("header.php") ?> 
<div class="container">
    <div class="login-wrapper">
        <div class="header">Sign Up</div> 
        <div class="form-wrapper">
            <input type="text" name="username" id="username" placeholder="username" class="input-item" oninput="validateUsername()"> <!-- 用户名输入框 -->
            <div id="usernameErrorMessage" class="error"></div> 
            <input type="password" name="password" id="password" placeholder="password" class="input-item" oninput="validatePassword()"> <!-- 密码输入框 -->
            <div id="passwordErrorMessage" class="error"></div> 
            <input type="password" name="confirmPassword" id="password2" placeholder="confirm password" class="input-item" oninput="validateConfirmPassword()"> <!-- 确认密码输入框 -->
            <div id="confirmPasswordErrorMessage" class="error"></div> 
            <div class="btn"><button class="button" id="sign-up-button">Sign Up</button></div> 
        </div>
        <div class="msg">
            Have account?
            <a href="../server/login.php">Login</a> <!-- 如果有账户，登录链接 -->
            <?php
                if (!empty($loginError)) { // 如果登录错误消息不为空
                    echo '<p style="color: red;">' . $loginError . '</p>'; // 输出登录错误消息
                }
                ?>
        </div>
    </div>
    </div>
</div>
<?php include("footer.php"); ?> 
</div>
</form>

<script src="../script/signup_validate.js"></script> 
</body>
</html>
