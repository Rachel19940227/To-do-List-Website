<?php
session_start(); 


$host = 'localhost'; 
$user = 'root'; 
$password = '';
$dbname = 'assignment2'; 

$conn = new mysqli($host, $user, $password, $dbname); // 创建一个新的数据库连接

if ($conn->connect_error) { // 检查连接是否成功
    die("Connection failed: " . $conn->connect_error); // 如果连接失败，则输出错误信息并终止程序执行
}

// 设置登录成功和失败的消息
$loginSuccess = "Login successful"; // 登录成功消息
$loginErr = "Invalid username or password"; // 用户名或密码无效消息
$msg = ''; // 初始化消息变量

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'"; // 构建 SQL 查询语句
    $result = $conn->query($sql); // 执行查询

    
    if ($result->num_rows > 0) { // 如果查询结果不为空
        $user = $result->fetch_assoc(); // 将用户数据作为关联数组提取出来
        $_SESSION['id'] = $user['id']; // 将用户ID存储在会话中
        $_SESSION['username'] = $user['username']; // 如果需要，存储用户名
        $msg = $loginSuccess; // 设置成功消息
        header('Location: main.php'); // 登录成功后重定向到主页
        exit(); // 终止脚本执行
    } else {
        // 登录失败
        $msg = $loginErr; // 设置失败消息
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php include ("header.php") ?> 
    <form action="login.php" method="post"> 
        <div class="container">
            <div class="login-wrapper">
                <div class="header">Login</div> 
                <div class="form-wrapper">
                    <input type="text" name="username" id="username" placeholder="Username" class="input-item" required> 
                    <input type="password" name="password" id="password" placeholder="Password" class="input-item" required>
                    <div class="btn"><input type="submit" value="Login" class="button"></div> 
                </div>
                <div class="msg">
                    Don't have an account? <a href="../server/sign-up.php">Sign up</a>
                </div>
                <div class="red"><?php echo $msg; ?></div> 
            </div>
        </div>
    </form>
    <?php include("footer.php"); ?> 
</body>
</html>
