
import { TaskManager } from './TaskManager.js';

document.addEventListener("DOMContentLoaded", () => {

    function printUserNameIn(userNameElId) {
        let userNameEl = document.getElementById(userNameElId);
        let userName = localStorage.getItem('username');
        userNameEl.innerText = userName + '!';
    }
    function handelAddTaskModal() {
        let addTaskModalElement = document.getElementById("addTaskModal");
        const addTaskModal = new bootstrap.Modal(addTaskModalElement);
        let taskNameElement = document.getElementById("taskName");

        let task = new Task(taskNameElement.value);
        task.addTask();
        taskNameElement.value = '';
        addTaskModal.hide();
    }
    function deleteAllTasksWhenClickOn(deleteAllTasksBtnID) {
        let deleteAllTasksBtn = document.getElementById(deleteAllTasksBtnID);

        deleteAllTasksBtn.addEventListener("click", () => {
            Task.deleteAllTasks();
        });
    }
    function addNewTaskWehnClickOn(addNewTaskElId) {
        let SaveTaskBtn = document.getElementById(SaveTaskBtn);
        SaveTaskBtn.addEventListener("click", () => {
            handelAddTaskModal();
        });
    }

    printUserNameIn("userName");

    Task.parentElement = document.getElementById("TasksParent");

    deleteAllTasksWhenClickOn("DeleteAllTasks");

    addNewTaskWehnClickOn("SaveTaskBtn");
});