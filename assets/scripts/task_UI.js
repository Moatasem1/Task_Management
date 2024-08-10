export class TaskUI {

    #taskElement;
    static parentElement = document.getElementById("TasksParent");

    constructor() {
        this.#taskElement = null;
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

    createTask() {
        this.#taskElement = this.#createTaskElement();

        TaskUI.parentElement.appendChild(this.#taskElement);

        this.#addAllListners();
    }

    removeTask() {
        TaskUI.parentElement.removeChild(this.#taskElement);
    }

    addCheckedkListner() {

        let taskLabe = this.#taskElement.querySelector("label");

        taskLabe.addEventListener("click", () => {

            let taskIcon = this.#taskElement.querySelector(".task-icon");
            let taskInput = this.#taskElement.querySelector(".task__input");

            if (taskInput.checked) {
                taskIcon.classList.remove('fa-solid', 'fa-square-check');
                taskIcon.classList.add('fa-regular', 'fa-square');
            } else {
                taskIcon.classList.remove('fa-regular', 'fa-square');
                taskIcon.classList.add('fa-solid', 'fa-square-check');
            }
            this.#taskElement.classList.toggle('task--checked');
        });
    }

    addDeleteListener() {
        let deleteTaskBtn = this.#taskElement.querySelector(".delete-task-btn");
        deleteTaskBtn.addEventListener("click", () => {
            this.removeTask();
        });
    }

    addEditListner() {
        let editTaskBtn = this.#taskElement.querySelector(".edit-task-btn");
        let taskText = this.#taskElement.querySelector(".task-text");

        editTaskBtn.addEventListener("click", () => {
            taskText.contentEditable = true;
            taskText.focus();
            this.#taskElement.classList.add("task--edit-mode");
        });

        taskText.addEventListener("blur", () => {
            taskText.contentEditable = false;
            this.#taskElement.classList.remove("task--edit-mode");
        });
    }

    #addAllListners() {
        this.addCheckedkListner();
        this.addDeleteListener();
        this.addEditListner();
    }
}