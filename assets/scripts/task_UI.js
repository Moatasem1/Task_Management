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

    createTask(taskId, taskName, taskStatus) {
        this.#taskElement = this.#createTaskElement(taskId, taskName);

        let taskInput = this.#taskElement.querySelector(".task__input");

        if (taskStatus === '1') {
            this.checkedTask();
            taskInput.checked = true;
        }

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

        return new Promise((resolve) => {
            taskText.addEventListener("blur", () => {
                taskText.contentEditable = false;
                this.#taskElement.classList.remove("task--edit-mode");
                resolve(taskText.innerText);
            }, { once: true });
        });
    }

    checkedTask() {
        let taskIcon = this.#taskElement.querySelector(".task-icon");
        taskIcon.classList.remove('fa-regular', 'fa-square');
        taskIcon.classList.add('fa-solid', 'fa-square-check');
        this.#taskElement.classList.add('task--checked');
    }

    uncheckedTask() {
        let taskIcon = this.#taskElement.querySelector(".task-icon");
        taskIcon.classList.remove('fa-solid', 'fa-square-check');
        taskIcon.classList.add('fa-regular', 'fa-square');
        this.#taskElement.classList.remove('task--checked');
    }

    handelCheckedTask() {
        let taskInput = this.#taskElement.querySelector(".task__input");
        let checkedStatusValue = 1;

        if (taskInput.checked) {
            this.uncheckedTask();
            checkedStatusValue = 0;

        } else {
            this.checkedTask();
        }

        return checkedStatusValue;
    }

    static deteletAllTasks() {
        TaskUI.parentElement.innerHTML = '';
    }
}