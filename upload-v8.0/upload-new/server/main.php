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

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // 如果未登录，则重定向到登录页面
    exit(); // 终止后续执行
}

// 从用户表中通过用户名获取用户ID（user_id）
$username = $_SESSION['username']; // 获取当前登录用户的用户名
$sqlUserId = "SELECT userID FROM users WHERE username='$username'"; // SQL查询语句，根据用户名查询用户ID
$resultUserId = $conn->query($sqlUserId); // 执行SQL查询

if ($resultUserId->num_rows > 0) {
    $rowUserId = $resultUserId->fetch_assoc(); // 获取查询结果的关联数组形式
    $userId = $rowUserId['userID']; // 获取用户ID（user_id）

    // 使用用户ID（user_id）从数据库中获取该用户创建的任务列表
    $sqlTasks = "SELECT * FROM tasks WHERE user_id='$userId'"; // SQL查询语句，根据用户ID查询任务列表
    $resultTasks = $conn->query($sqlTasks); // 执行SQL查询

    $tasks = []; // 初始化任务数组
    if ($resultTasks->num_rows > 0) {
        while ($rowTask = $resultTasks->fetch_assoc()) {
            $tasks[] = $rowTask; // 将每个任务添加到任务数组中
        }
    }
} else {
    // 处理无法找到用户ID（user_id）的错误
    echo "Error: User ID not found."; // 输出错误信息
    exit(); // 终止后续执行
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set, index information, and page title -->
    <meta charset="utf-8">
    <meta name="main" content="main">
    <title>main</title>
    <!-- add meta and title to this page -->
</head>
<body>

<?php include ("main-header.php") ?> <!-- 包含 main-header.php 文件的内容 -->
<!-- Main content section -->
<div class="container">
    <h1><?php echo $_SESSION['username']; ?>'s Todo List</h1> <!-- 显示当前登录用户的用户名 -->

    <!-- 添加添加任务按钮和选择按钮 -->
    <div class="right-align-container">
        <div class="button-container">
            <button class="button" id="addTaskBtn" name="add">Add Task</button> <!-- 添加任务按钮 -->
        </div>
        <div class="select-container">
            <select name="todos" class="filter-todo" onchange="filterTasks()"> <!-- 选择按钮，用于过滤任务列表 -->
                <option value="all">All</option>
                <option value="completed">Completed</option>
                <option value="uncompleted">Uncompleted</option>
            </select>
        </div>
    </div>

    <!-- 添加任务信息表格 -->
    <table id="taskTable">
        <thead>
            <tr>
                <th>Task Title</th>
                <th>Task Info</th>
                <th>Priority Level</th>
                <th>Create Time</th>
                <th>complete</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="taskTableBody">
            <!-- 显示当前登录用户创建的任务 -->
            <?php foreach ($tasks as $task): ?>
                <tr id="<?php echo $task['task_id']; ?>" class="task-row"> 
                    <td><?php echo $task['task_name']; ?></td> 
                    <td><?php echo $task['task_info']; ?></td> 
                    <td><?php echo $task['priority_level']; ?></td> 
                    <td><?php echo $task['create_time']; ?></td> 
                    <td><?php echo ($task['complete'] == 1) ? 'Completed' : 'Uncompleted'; ?></td> 
                    <td>
                        <button class="modifyTaskBtn" onclick="modifyTask(this);">Modify</button> 
                        <button class="btn delete-btn" onclick="deleteTask(<?php echo $task['task_id']; ?>)">Delete</button></a> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- 添加新任务表单 -->
    <div class="modal-overlay" id="modalOverlay">
        <!-- 模态框内容 -->
        <div class="modal-content">
            <h2 class="modal-title">Add a Task</h2> 
            <form action="add-task.php" method="post">
            <input type="hidden" name="userId" value="<?php echo $userId; ?>"> 
                <div class="modal-input">
                    <label for="taskTitle">Task Title:</label> 
                    <input type="text" id="taskTitle" name="taskTitle" placeholder="Please input task title" required />
                </div>
                <div class="modal-input">
                    <label for="taskInfo">Task Info:</label> 
                    <input type="text" id="taskInfo" name="taskInfo" placeholder="Please input task info" required />
                </div>
                <div class="modal-input">
                    <label for="prioritySelect">Priority Level:</label> 
                    <select id="prioritySelect" name="prioritySelect" required> 
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="modal-input">
                    <label for="completeSelect">Complete:</label> 
                    <select id="completeSelect" name="completeSelect" required> 
                        <option value="Completed">Completed</option>
                        <option value="Uncompleted">Uncompleted</option>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="button" id="cancelBtn">Cancel</button> 
                    <button type="submit" id="saveBtn">Save</button> 
                </div>
            </form>
        </div>
    </div>
    <!-- 修改任务表单 -->
    <div class="modal-overlay" id="modifyModalOverlay">
        <!-- 模态框内容 -->
        <div class="modal-content">
            <h2 class="modal-title" id="modifyModalTitle">Modify Task</h2> 
            <form action="modify.php" method="post">
                <div class="modal-input">
                    <label for="modifyTaskTitle">Task Title:</label> 
                    <input type="text" id="modifyTaskTitle" name="modifyTaskTitle" required /> 
                </div>
                <div class="modal-input">
                    <label for="modifyTaskInfo">Task Info:</label> 
                    <input type="text" id="modifyTaskInfo" name="modifyTaskInfo" required /> 
                </div>
                <div class="modal-input">
                    <label for="modifyPrioritySelect">Priority Level:</label> 
                    <select id="modifyPrioritySelect" name="modifyPrioritySelect" required> 
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="modal-input">
                    <label for="modifyCompleteSelect">Complete:</label> 
                    <select id="modifyCompleteSelect" name="modifyCompleteSelect" required> 
                        <option value="Completed">Completed</option>
                        <option value="Uncompleted">Uncompleted</option>
                    </select>
                </div>
                <!-- 隐藏字段，存储任务ID -->
                <input type="hidden" id="modifyTaskId" name="modifyTaskId" />
                <div class="modal-buttons">
                    <button type="button" id="cancelModifyBtn">Cancel</button> 
                    <button type="submit" id="saveModifyBtn">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../script/modify.js"></script> 
<script src="../script/app1.js"></script> 
<?php include("footer.php"); ?> <!-- 包含 footer.php 文件的内容 -->
</body>
</html>
