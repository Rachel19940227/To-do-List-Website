
function modifyTask(obj){
    //这段代码中的 obj.parentNode.parentNode 表示从当前元素向上两层，即获取当前元素modifyTaskBtn的父元素的父元素。
    var task_tr = obj.parentNode.parentNode;
    var task_title = task_tr.children[0].innerText;
    var task_info = task_tr.children[1].innerText;
    var priority_level = task_tr.children[2].innerText;
    var complete = task_tr.children[4].innerText;
    var task_id = task_tr.id;
    document.getElementById('modifyTaskTitle').value = task_title;
    document.getElementById('modifyTaskInfo').value = task_info;
    document.getElementById('modifyPrioritySelect').value = priority_level;
    document.getElementById('modifyCompleteSelect').value = complete;
    //将任务ID赋值给 ID 为 modifyTaskId 的隐藏输入框，以便在提交修改后将该ID传递给后台进行处理
    document.getElementById('modifyTaskId').value = task_id;
}
// btn delete-btn接收一个参数 id，
function deleteTask(id){
    // 如果用户点击对话框中的确认按钮（OK），confirm 函数会返回 true，表示用户确认删除。
    // 如果用户点击对话框中的取消按钮（Cancel），或者直接关闭对话框，confirm 函数会返回 false，表示用户取消了删除操作。
    if (confirm("Are you sure you want to delete this task?")) {
// 使用 window.location.href 将页面重定向到指定的 URL，该 URL 是 "delete-task.php" 并附带了一个参数 task_id
// 重定向后，浏览器会加载 "delete-task.php" 页面，并将task_id作为参数传递给这个页面，以便后台代码处理删除任务的逻辑。
        window.location.href = "delete-task.php?task_id=" + id;
    }

}