// js code for add and modify button
document.addEventListener('DOMContentLoaded', () => {
    var addTaskBtn = document.getElementById('addTaskBtn');
    var modifyTaskBtns = document.querySelectorAll('.modifyTaskBtn');
    var modalOverlay = document.getElementById('modalOverlay');
    var modifyModalOverlay = document.getElementById('modifyModalOverlay');
    var cancelBtn = document.getElementById('cancelBtn');
    var cancelModifyBtn = document.getElementById('cancelModifyBtn');

    // Function to show the add task modal
    function showAddTaskModal() {
        modalOverlay.style.display = 'block';
    }

    // Function to hide the add task modal
    function hideAddTaskModal() {
        modalOverlay.style.display = 'none';
    }

    // Function to show the modify task modal
    function showModifyTaskModal() {
        modifyModalOverlay.style.display = 'block';
    }

    // Function to hide the modify task modal
    function hideModifyTaskModal() {
        modifyModalOverlay.style.display = 'none';
    }

    // Event listener for the Add Task button
    addTaskBtn.addEventListener('click', showAddTaskModal);

    // Event listener for the Modify Task buttons
    // 因为modify button 有很多，所以用for each
    modifyTaskBtns.forEach(btn => {
        btn.addEventListener('click', showModifyTaskModal);
    });

    // Event listener for the Close button in the add task modal
    cancelBtn.addEventListener('click', hideAddTaskModal);

    // Event listener for the Close button in the modify task modal
    cancelModifyBtn.addEventListener('click', hideModifyTaskModal);
});

//filter Tasks via complete
function filterTasks() {
    var filterOption = document.querySelector(".filter-todo").value;
    var rows = document.querySelectorAll("#taskTableBody tr");
    rows.forEach(function(row) {
        
    var isCompleted = row.querySelectorAll("td")[4].textContent;
    var displayRow = false;

    if (filterOption === "completed") {
        if(isCompleted === "Completed"){
            displayRow = true; // 显示已完成任务行
        }else{
            displayRow = false; // 不显示该行
        }
    } else if (filterOption === "uncompleted") {
        if(isCompleted === "Uncompleted"){
            displayRow = true; // 显示未完成任务行
        }else{
            displayRow = false; // 不显示该行
        }
    } else if (filterOption === "all") {
        displayRow = true; // 显示所有任务行
    }
    // 根据 displayRow 的值来设置行的显示与隐藏
    if (displayRow) {
        row.style.display = "table-row"; // 显示行
    } else {
        row.style.display = "none"; // 隐藏行
    }
    });
}


  