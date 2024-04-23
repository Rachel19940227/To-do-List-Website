<?php
session_start(); 

// 连接数据库 Connect to database
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'assignment2'; 

$conn = new mysqli($host, $user, $password, $dbname); // 创建一个新的数据库连接 Create a new database connection

// 检查数据库连接是否成功 Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // 若连接失败则输出错误信息并终止程序执行 Output error message and terminate program execution if connection fails
}

// 检查请求方法是否为 POST Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据 Get form data
    $taskTitle = $_POST['taskTitle']; 
    $taskInfo = $_POST['taskInfo']; 
    $prioritySelect = $_POST['prioritySelect']; 
    $completeSelect = ($_POST['completeSelect'] == 'Completed') ? 1 : 0; 
    $userId = mysqli_real_escape_string($conn, $_POST['userId']); // 用户ID（防止 SQL 注入攻击的特殊字符处理） User ID (special character processing to prevent SQL injection attacks)

    // 插入任务到 tasks 表中 Insert task into tasks table
    $currentTime = date('Y-m-d H:i:s'); // 当前时间 Current time
    $sqlInsertTask = "INSERT INTO tasks (task_name, task_info, priority_level, create_time, complete, user_id) VALUES ('$taskTitle', '$taskInfo', '$prioritySelect', '$currentTime', '$completeSelect','$userId')"; // 构建插入任务的 SQL 语句 Construct SQL statement to insert task
    if ($conn->query($sqlInsertTask) === TRUE) { // 执行 SQL 语句 Execute SQL statement
        echo "New task added successfully"; // 
        echo '<p>Back to <a href="main.php">Main Page</a></p>'; // 提供返回到主页面的链接 Provide a link to return to the main page
    } else {
        echo "Error: " . $sqlInsertTask . "<br>" . $conn->error; // 若插入任务失败则输出错误信息 Output error message if task insertion fails
    }
}

$conn->close(); 
?>
