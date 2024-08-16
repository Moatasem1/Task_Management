
import { TaskUI } from "./task_UI.js";
import { TaskApi } from "./task_api.js";

export class TaskManager {

    #userId;
    #taskId;
    #taskName;
    #taskUI;
    #taskApi;

    constructor(userId = null, taskId = null) {
        this.#taskUI = new TaskUI();
        this.#taskApi = new TaskApi();
        this.#userId = userId;
        this.#taskId = taskId;
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
        this.#taskApi.deleteTask(this.#taskId, this.#userId);
        this.#taskUI.removeTask();
    }

    async updateTask() {
        this.#taskName = await this.#taskUI.editTask();
        let result = this.#taskApi.updateTaskName(this.#taskName, this.#taskId, this.#userId);
    }

    static addAllTasks(userId) {

        let taskApi = new TaskApi();
        let tasks = taskApi.getAllTasks(userId).then(tasks => {

            if (!tasks)
                return;

            tasks.forEach(task => {
                let taskManger = new TaskManager(userId, task["id"]);
                taskManger.getTaskUI().createTask(task["id"], task["task_name"], task['status']);
                taskManger.addAllListners();
            });
        });

    }

    static deleteAllTasks(userId) {

        let taskApi = new TaskApi();
        if (taskApi.deleteAllTasks(userId)) {

            TaskUI.deteletAllTasks(userId);
        }
    }

    handelCheckedTask() {
        let checkedStatusValue = this.#taskUI.handelCheckedTask();

        this.#taskApi.updateTaskStatus(checkedStatusValue, this.#taskId, this.#userId);
    }

    //listners
    #addCheckedkListner() {
        let taskElement = this.#taskUI.getTaskElement();
        let taskLabe = taskElement.querySelector("label");

        taskLabe.addEventListener("click", () => {
            this.handelCheckedTask();
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