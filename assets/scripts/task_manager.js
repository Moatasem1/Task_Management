
import { TaskUI } from "./task_UI.js";
import { TaskApi } from "./task_api.js";

export class TaskManager {

    #taskId;
    #taskName;
    #taskUI;
    #taskApi;

    constructor() {
        this.#taskUI = new TaskUI();
        this.#taskApi = new TaskApi();
        this.#taskId = null;
    }

    setName(taskName) {
        this.#taskName = taskName;
    }

    getName() {
        return this.#taskName;
    }

    getTaskApi() {
        return this.#taskApi;
    }

    getTaskUI() {
        return this.#taskUI;
    }

    createTask(userId) {
        this.#taskApi.addTask(this.#taskName, userId).then(taskId => {
            this.#taskId = taskId;
            this.#taskUI.createTask(this.#taskId, this.#taskName);
            this.addAllListners();
        });
    }

    deleteTask() {
        //call delete api
        this.#taskUI.removeTask();
    }

    updateTask() {
        this.#taskName = this.#taskUI.editTask();
        //call edit api
    }

    static addAllTasks(userId) {

        let taskApi = new TaskApi();
        let tasks = taskApi.getAllTasks(userId).then(tasks => {

            if (!tasks)
                return;

            tasks.forEach(task => {
                let taskManger = new TaskManager();
                taskManger.getTaskUI().createTask(task["id"], task["task_name"]);
                taskManger.addAllListners();
            });
        });

    }

    static deleteAllTasks() {
        //call api to delete all tasks
        TaskUI.deteletAllTasks();
    }

    //listners
    #addCheckedkListner() {

        let taskElement = this.#taskUI.getTaskElement();
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

    #addDeleteListener() {
        let taskElement = this.#taskUI.getTaskElement();
        let deleteTaskBtn = taskElement.querySelector(".delete-task-btn");
        deleteTaskBtn.addEventListener("click", () => {
            this.deleteTask();
        });
    }

    #addEditListner() {
        let taskElement = this.#taskUI.getTaskElement();
        console.log(taskElement);
        let editTaskBtn = taskElement.querySelector(".edit-task-btn");

        editTaskBtn.addEventListener("click", () => {
            this.updateTask();
        });

    }

    addAllListners() {
        this.#addCheckedkListner();
        this.#addDeleteListener();
        this.#addEditListner();
    }
}