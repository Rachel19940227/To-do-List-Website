<?php

// Include your database connection code here 包含数据库连接代码

$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'assignment2'; 

// Create connection 创建数据库连接
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection 检查连接是否成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // 如果连接失败，则输出错误信息并终止程序执行
}

// Check if the form is submitted 检查表单是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the modified task information from the form 从表单中获取修改后的任务信息
    $modifyTaskTitle = $_POST['modifyTaskTitle']; 
    $modifyTaskInfo = $_POST['modifyTaskInfo']; 
    $modifyPriority = $_POST['modifyPrioritySelect']; 
    $modifyCompleteSelect = ($_POST['modifyCompleteSelect'] == 'Completed') ? 1 : 0; // 修改完成状态,如果是completed则保存到数据库里是1
    $taskId = $_POST['modifyTaskId']; // 从隐藏的输入字段中检索任务ID

    // Update the task in the database 在数据库中更新任务
    $sql = "UPDATE tasks SET task_name='$modifyTaskTitle', task_info='$modifyTaskInfo', priority_level='$modifyPriority', complete='$modifyCompleteSelect' WHERE task_id='$taskId'";

    if ($conn->query($sql) === TRUE) {
        echo "Task updated successfully"; 
        
        echo '<p>Back to <a href="main.php">Main Page</a></p>'; 
    } else {
        echo "Error updating task: " . $conn->error; 
    }
}


$conn->close();
?>
