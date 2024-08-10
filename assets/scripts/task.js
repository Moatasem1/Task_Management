

    static deleteAllTasks() {
    let allTasks = document.querySelectorAll(".task");
    allTasks.forEach(task => {
        Task.parentElement.removeChild(task);
    });
}
//delete all
