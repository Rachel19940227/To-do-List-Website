<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set, index information, and page title -->
    <meta charset="utf-8"> <!-- 字符集、索引信息和页面标题的元标签 -->
    <meta name="main" content="main"> <!-- 主要内容的元标签 -->
    <title>allTask</title> <!-- 页面标题 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
            integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="../script/allTask.js"></script> <!-- 引入外部 JavaScript 文件 -->
    <!-- add meta and title to this page -->
</head>
<body>

<?php include ("allTask-header.php") ?> <!-- 包含 allTask-header.php 文件的内容 -->

<?php
session_start(); // 开始一个会话

// connection
$host = 'localhost'; // 主机
$user = 'root'; // 用户名
$password = ''; // 密码
$dbname = 'assignment2'; // 数据库名

$conn = new mysqli($host, $user, $password, $dbname); // 创建一个新的数据库连接
?>

<?php 

$sql = "SELECT * FROM tasks"; // SQL 查询语句：选择所有任务
$result = mysqli_query($conn, $sql); // 执行 SQL 查询

if ($result->num_rows > 0) { // 如果查询结果不为空
    $tasks = array(); // 初始化任务数组
    while ($row = $result->fetch_assoc()) { // 遍历查询结果的每一行
        $tasks[] = $row; // 将每一行添加到任务数组中
    }
    // echo json_encode($tasks); // 输出任务数据为 JSON 格式
} else {
    echo "No tasks found."; // 如果没有找到任务，则输出提示信息
}
?>

<!-- Main content section -->
<div class="container">
    <h1>Task Management</h1> <!-- 任务管理标题 -->
    <div id="allTask_info">
        <p>this is all tasks page, you can see tasks calculation here.</p> <!-- 这是所有任务页面，您可以在此处查看任务计算。 -->
        <p>if you want to create new task, please go to <a href="main.php">user page</a>.</p> <!-- 如果您想创建新任务，请转到用户页面。 -->
    </div>

    <div class="task-summary">
        <?php
        // Initialize counters for each priority level 初始化每个优先级的计数器
        $totalTasks = count($tasks); // 总任务数
        $lowPriorityTasks = 0; // 低优先级任务数
        $mediumPriorityTasks = 0; // 中等优先级任务数
        $highPriorityTasks = 0; // 高优先级任务数

        // Loop through tasks to count priority levels 遍历任务以计算优先级水平
        foreach ($tasks as $task) {
            switch ($task['priority_level']) {
                case 'Low':
                    $lowPriorityTasks++; // 低优先级任务数加一
                    break;
                case 'Medium':
                    $mediumPriorityTasks++; // 中等优先级任务数加一
                    break;
                case 'High':
                    $highPriorityTasks++; // 高优先级任务数加一
                    break;
                default:
                    // Handle unknown priority levels if needed 如果需要，处理未知的优先级水平
                    break;
            }
        }
        ?>
        <div class="task-item total-tasks">
            <i class="fas fa-tasks"></i> <!-- Font Awesome 图标 -->
            <p>Total Tasks: <span id="totalTasks"><?php echo $totalTasks; ?></span></p> <!-- 总任务数 -->
        </div>
        <div class="task-item low-priority">
            <i class="fa fa-minus-circle"></i> <!-- Font Awesome 图标 -->
            <p>Low Priority: <span id="lowPriorityTasks"><?php echo $lowPriorityTasks; ?></span></p> <!-- 低优先级任务数 -->
        </div>
        <div class="task-item medium-priority">
            <i class="fas fa-info-circle"></i> <!-- Font Awesome 图标 -->
            <p>Medium Priority: <span id="mediumPriorityTasks"><?php echo $mediumPriorityTasks; ?></span></p> <!-- 中等优先级任务数 -->
        </div>
        <div class="task-item high-priority">
            <i class="fa fa-exclamation-circle"></i> <!-- Font Awesome 图标 -->
            <p>High Priority: <span id="highPriorityTasks"><?php echo $highPriorityTasks; ?></span></p> <!-- 高优先级任务数 -->
        </div>
    </div>

    <!-- Search input and button -->
    <div id="search">
        <input type="text" id="searchInput" placeholder="Search Task Name"> <!-- 搜索任务名称的输入框 -->
        <button id="searchBtn">Search</button> <!-- 搜索按钮 -->
    </div>
    <!-- task table 任务表格 -->
    <table id="taskTable">
        <thead>
            <tr>
                <th>Task Name</th> <!-- 任务名称 -->
                <th>Task Info</th> <!-- 任务信息 -->
                <th>Priority Level</th> <!-- 优先级水平 -->
                <th>Create Time</th> <!-- 创建时间 -->
                <th>Created By</th> <!-- 创建者 -->
                <th>Complete</th> <!-- 完成状态 -->
            </tr>
        </thead>
        <tbody id="taskTableBody">
            <?php
            // Check if $tasks array is not empty 检查 $tasks 数组是否不为空
            if (!empty($tasks)) {
                foreach ($tasks as $task) {
                    // Fetch the username based on the user ID 根据用户ID获取用户名
                    $userID = $task['user_id'];
                    $sqlUsername = "SELECT username FROM users WHERE userID = $userID";
                    $resultUsername = mysqli_query($conn, $sqlUsername);
                    $username = "";
                    if ($resultUsername && mysqli_num_rows($resultUsername) > 0) {
                        $rowUsername = mysqli_fetch_assoc($resultUsername);
                        $username = $rowUsername['username'];
                    }

                    // Output table row for each task 输出每个任务的表格行
                    echo "<tr>";
                    echo "<td>{$task['task_name']}</td>"; // 任务名称
                    echo "<td>{$task['task_info']}</td>"; // 任务信息
                    echo "<td>{$task['priority_level']}</td>"; // 优先级水平
                    echo "<td>{$task['create_time']}</td>"; // 创建时间
                    echo "<td>{$username}</td>"; // 创建者
                    echo "<td>" . ($task['complete'] ? 'completed' : 'uncompleted') . "</td>"; // 完成状态
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No tasks found.</td></tr>"; // 如果没有找到任务，则输出提示信息
            }
            ?>
        </tbody>
    </table>
</div>
<div class="container" id="pagination">
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
        <a class="page-link">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
        <a class="page-link" href="#">Next</a>
        </li>
    </ul>
    </nav>
</div>
<?php include("footer.php"); ?> <!-- 包含 footer.php 文件的内容 -->

</body>
</html>
