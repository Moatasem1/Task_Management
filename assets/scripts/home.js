document.addEventListener("DOMContentLoaded", () => {

    //show username
    let userNameEl = document.getElementById("userName");
    let userName = localStorage.getItem('username');
    userNameEl.innerText = userName + '!';


    //control checkbox icon
    let taskIsnputs = document.querySelectorAll(".task__input");

    taskIsnputs.forEach(taskInput => {
        taskInput.addEventListener("click", () => {

            let taskInputParent = taskInput.parentElement;
            let taskIcon = taskInputParent.querySelector(".task-icon");

            if (taskInput.checked) {
                taskIcon.classList.remove('fa-regular', 'fa-square');
                taskIcon.classList.add('fa-solid', 'fa-square-check');
            } else {
                taskIcon.classList.remove('fa-solid', 'fa-square-check');
                taskIcon.classList.add('fa-regular', 'fa-square');
            }
            taskInputParent.classList.toggle('task--checked');
        });
    });

    //delete all tasks
    let DeleteAllTasks = document.getElementById("DeleteAllTasks");
    let TasksParent = document.getElementById("TasksParent");
    let allTasks = document.querySelectorAll(".task");

    DeleteAllTasks.addEventListener("click", () => {
        allTasks.forEach(task => {
            TasksParent.removeChild(task);
        });
    });


});