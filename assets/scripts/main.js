import { TaskManager } from './task_manager.js';

document.addEventListener("DOMContentLoaded", () => {

    function printUserNameIn(userNameElId) {
        let userNameEl = document.getElementById(userNameElId);
        let userName = localStorage.getItem('username');
        let userId = localStorage.getItem('userId');
        userNameEl.innerText = userName + '!';
    }
    function handelAddTaskModal(taskModelObj) {

        let taskNameElement = document.getElementById("taskName");

        let task = new TaskManager();
        task.setName(taskNameElement.value);
        task.createTask(localStorage.getItem('userId'));
        taskNameElement.value = '';
        taskModelObj.hide();
    }
    function addNewTaskWehnClickOn(saveTaskBtnId) {

        let addTaskModalElement = document.getElementById("addTaskModal");
        let saveTaskBtn = document.getElementById(saveTaskBtnId);
        const addTaskModal = new bootstrap.Modal(addTaskModalElement);

        saveTaskBtn.addEventListener("click", () => {
            handelAddTaskModal(addTaskModal);
        });
    }
    function getAllTasks(userId) {
        TaskManager.addAllTasks(userId);
    }
    function deleteAllTasksWhenClickOn(deleteAllTasksBtnId) {

        let deleteAllTaskModalElement = document.getElementById("deleteAllTaskModal");
        const deleteAllTaskModal = new bootstrap.Modal(deleteAllTaskModalElement);
        let deleteAllTasksBtn = document.getElementById(deleteAllTasksBtnId);

        deleteAllTasksBtn.addEventListener("click", () => {
            TaskManager.deleteAllTasks(localStorage.getItem('userId'));
            deleteAllTaskModal.hide();
        });
    }
    function filterTasks(filterType = "all") {
        let tasks = document.querySelectorAll(".task");
        filterType = filterType.toLowerCase();

        tasks.forEach(task => {
            let isTaskComplete = task.classList.contains("task--checked");

            if (filterType === "active" && isTaskComplete) {
                task.classList.remove("d-block");
                task.classList.add("d-none");
            }
            else if (filterType === "complete" && !isTaskComplete) {
                task.classList.remove("d-block");
                task.classList.add("d-none");
            }
            else {
                task.classList.remove("d-none");
                task.classList.add("d-block");
            }
        });
    }
    function handleTasksFilter() {
        let filterBtns = document.querySelectorAll(".filter-btn");

        filterBtns.forEach(filterBtn => {
            filterBtn.addEventListener("click", event => {
                filterTasks(filterBtn.getAttribute("filter"));

                filterBtns.forEach(filterBtnInside => {
                    filterBtnInside.classList.remove("dashbaord__tab--active");
                });

                filterBtn.classList.add("dashbaord__tab--active");
            });
        });

    }

    printUserNameIn("userName");

    getAllTasks(localStorage.getItem('userId'));

    handleTasksFilter();

    deleteAllTasksWhenClickOn("deleteAllTasksBtn");

    addNewTaskWehnClickOn("SaveTaskBtn");
});