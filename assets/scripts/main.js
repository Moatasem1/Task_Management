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
    function deleteAllTasksWhenClickOn(deleteAllTasksBtnID) {
        let deleteAllTasksBtn = document.getElementById(deleteAllTasksBtnID);

        deleteAllTasksBtn.addEventListener("click", () => {
            TaskManager.deleteAllTasks();
        });
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

    printUserNameIn("userName");

    getAllTasks(localStorage.getItem('userId'));

    deleteAllTasksWhenClickOn("DeleteAllTasks");

    addNewTaskWehnClickOn("SaveTaskBtn");
});