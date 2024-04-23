
document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to the search button
    document.getElementById("searchBtn").addEventListener("click", function() {
        // Get the search input value
        var searchValue = document.getElementById("searchInput").value.trim().toLowerCase();
        
        // Get all rows in the task table
        var rows = document.querySelectorAll("#taskTableBody tr");

        // Loop through rows and hide/show based on search value
        rows.forEach(function(row) {
            var taskName = row.cells[0].innerText.trim().toLowerCase(); // Assuming task name is in the first column
            var taskInfo = row.cells[1].innerText.trim().toLowerCase(); // Assuming task info is in the second column
            var taskPriority = row.cells[2].innerText.trim().toLowerCase(); // Assuming task priority level is in the third column
            var userName = row.cells[4].innerText.trim().toLowerCase(); // Assuming user name is in the fourth column
            // Check if task name contains the search value
            if (taskName.includes(searchValue) | taskInfo.includes(searchValue) | taskPriority.includes(searchValue) | userName.includes(searchValue)) {
                row.style.display = ""; // Show the row
            } else {
                row.style.display = "none"; // Hide the row
            }
        });
    });
});
