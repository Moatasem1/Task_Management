export class TaskUI {

    #taskElement;
    static parentElement = document.getElementById("TasksParent");

    constructor() {
        this.#taskElement = null;
    }

    setTaskElement(taskElement) {
        this.#taskElement = taskElement;
    }

    getTaskElement() {
        return this.#taskElement;
    }

    #createTaskElement(taskId, taskName) {
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = `<li class="task shadow-sm bg-main-white rounded mb-3 d-flex align-items-center">
                                    <input id="${taskId}" type="checkbox" class="task__input d-none" value="${taskId}">
                                    <label role="button" for="${taskId}" class="w-100 p-3 d-flex align-items-center gap-2">
                                        <i class="task-icon text-main-orange fa-regular fa-square"></i>
                                        <span class="task-text w-100">${taskName}</span>
                                    </label>
                                    <i role="button" class="fa-solid fa-pen-to-square text-main-orange me-3 edit-task-btn"></i>
                                    <i role="button" class="fa-solid fa-trash text-main-orange me-3 delete-task-btn"></i>
                                 </li>`;
        let taskElement = tempDiv.firstChild;

        return taskElement;
    }

    createTask(taskId, taskName) {
        this.#taskElement = this.#createTaskElement(taskId, taskName);

        TaskUI.parentElement.appendChild(this.#taskElement);
    }

    removeTask() {
        TaskUI.parentElement.removeChild(this.#taskElement);
    }

    editTask() {
        let taskText = this.#taskElement.querySelector(".task-text");

        taskText.contentEditable = true;
        taskText.focus();
        this.#taskElement.classList.add("task--edit-mode");

        taskText.addEventListener("blur", () => {
            taskText.contentEditable = false;
            this.#taskElement.classList.remove("task--edit-mode");
        });

        return taskText.innerText;
    }

    static deteletAllTasks() {
        TaskUI.parentElement.innerHTML = '';
    }
}