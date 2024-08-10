
import { TaskUI } from "./task_UI";
import { TaskApi } from "./task_api";

class TaskManager {

    #taskId;
    #taskName;
    #taskUI;
    #taskApi;

    constructor(tasksParent) {
        TaskManager.tasksParent = tasksParent;
        this.#taskUI = new TaskUI();
        this.#taskApi = new TaskApi();
    }

    createTask(userId) {
        this.#taskId = this.#taskApi.addTask(this.#taskName, userId);
        this.#taskUI.createTask();
    }

    deleteTask() {
        //call delete api
        this.#taskUI.removeTask();
    }

    updateTask() {

    }
}

