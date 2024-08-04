document.addEventListener("DOMContentLoaded", () => {

    class Task {
        #name;
        static parentElement
        constructor(taskName) {
            this.#name = taskName;
        }

        setName(taskName) {
            this.#name = taskName;
        }

        getName() {
            return this.#name;
        }

        addTask() {
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = `<li class="shadow-sm bg-main-white rounded mb-3 d-flex align-items-center task">
                                    <input id="taskid2" type="checkbox" class="task__input d-none" value="Buy monthly groceries">
                                    <label role="button" for="taskid2" class="w-100 p-3">
                                        <i class="task-icon text-main-orange fa-regular fa-square me-2"></i>
                                        <span class="">${this.#name}</span>
                                    </label>
                                    <i role="button" class="fa-solid fa-pen-to-square text-main-orange me-3 edit-task-btn"></i>
                                    <i role="button" class="fa-solid fa-trash text-main-orange me-3 delete-task-btn"></i>
                                </li>`;
            let taskElement = tempDiv.firstChild;
            Task.parentElement.appendChild(taskElement);
            handelTaskClicked(taskElement);
            addDeleteListner(taskElement);
            return taskElement;
        }

        static deleteTask(taskElement) {
            Task.parentElement.removeChild(taskElement);;
        }

        static deleteAllTasks() {
            let allTasks = document.querySelectorAll(".task");
            allTasks.forEach(task => {
                Task.parentElement.removeChild(task);
            });
        }

    }

    function handelTaskClicked(taskElement) {

        let taskLabe = taskElement.querySelector("label");

        taskLabe.addEventListener("click", () => {

            let taskIcon = taskElement.querySelector(".task-icon");
            let taskInput = taskElement.querySelector(".task__input");

            if (taskInput.checked) {
                taskIcon.classList.remove('fa-solid', 'fa-square-check');
                taskIcon.classList.add('fa-regular', 'fa-square');
            } else {
                taskIcon.classList.remove('fa-regular', 'fa-square');
                taskIcon.classList.add('fa-solid', 'fa-square-check');
            }
            taskElement.classList.toggle('task--checked');
        });
    }

    function addDeleteListner(taskElement) {
        let deleteTaskBtn = taskElement.querySelector(".delete-task-btn");
        deleteTaskBtn.addEventListener("click", () => {
            Task.deleteTask(taskElement);
        });
    }

    function addEditListner(taskElement, newTaskName) {
        let editTaskBtn = taskElement.querySelector(".edut-task-btn");
        editTaskBtn.addEventListener("click", () => {
            taskElement.innerText = newTaskName;
        });
    }

    //show username
    let userNameEl = document.getElementById("userName");
    let userName = localStorage.getItem('username');
    userNameEl.innerText = userName + '!';


    //handel clicked tasks
    let tasksElements = document.querySelectorAll(".task");
    tasksElements.forEach(taskElement => {
        handelTaskClicked(taskElement);
    });


    //set tasks parent elemet
    let TasksParent = document.getElementById("TasksParent");
    Task.parentElement = TasksParent;

    //delete all tasks
    let DeleteAllTasks = document.getElementById("DeleteAllTasks");

    DeleteAllTasks.addEventListener("click", () => {
        Task.deleteAllTasks();
    });


    //add new task
    let addTaskModalElement = document.getElementById("addTaskModal");
    const addTaskModal = new bootstrap.Modal(addTaskModalElement);
    let SaveTaskBtn = document.getElementById("SaveTaskBtn");
    let taskNameElement = document.getElementById("taskName");

    SaveTaskBtn.addEventListener("click", () => {
        let task = new Task(taskNameElement.value);
        task.addTask();
        taskNameElement.value = '';
        addTaskModal.hide();
    });


    //delete task
    let tasks = document.querySelectorAll(".task");

    tasks.forEach(task => {
        addDeleteListner(task);
    });


    //edit task

});