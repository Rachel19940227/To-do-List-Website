<?php
// Include your database connection file 包含数据库连接文件

$host = 'localhost'; // Your database host 你的数据库主机
$user = 'root'; // Your database username 你的数据库用户名
$password = ''; // Your database password 你的数据库密码
$dbname = 'assignment2'; // Your database name 你的数据库名

// Check if the task ID is received 检查是否收到任务ID
if (isset($_GET['task_id'])) {
    $taskId = $_GET['task_id']; // Get the task ID 获取任务ID

    $conn = mysqli_connect($host, $user, $password, $dbname); // Connect to the database 连接数据库

    $sql = "DELETE FROM tasks WHERE task_id = $taskId"; // SQL query to delete task 根据任务ID删除任务
    $result = mysqli_query($conn, $sql); // Execute the query 执行查询
    header('Location: main.php'); // Redirect to main.php 重定向到 main.php
} else {
    // Return an error message if task ID is not provided 如果未提供任务ID，则返回错误消息
    echo json_encode(['success' => false, 'message' => 'Task ID not provided.']); // Output JSON response 输出 JSON 响应
}
?>
