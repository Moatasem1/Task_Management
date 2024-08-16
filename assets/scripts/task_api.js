export class TaskApi {

    async addTask(taskName, userId) {

        return fetch("http://localhost/GitHub/toDoListApp/controllers/add_task.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                task_name: taskName,
                user_id: userId,
            }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    return data.task_id;
                } else
                    return null;
            })
            .catch(error => {
                console.error('Error:', error)
                return null;
            });
    }

    async getAllTasks(userId) {
        return fetch(`http://localhost/GitHub/toDoListApp/controllers/get_all_tasks.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    return data.tasks;
                }
                return null;
            })
            .catch(error => {
                console.error('Error:', error);
                return null;
            });

    }
}