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

    async updateTaskName(newTaskName, taskId, userId) {
        return fetch("http://localhost/GitHub/toDoListApp/controllers/update_task_name.php", {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                newTaskName: newTaskName,
                taskId: taskId,
                userId: userId
            }),
        })
            .then(response => response.json())
            .then(data => {
                return data.success;
            })
            .catch(error => {
                console.error('Error:', error)
                return false;
            });
    }

    async deleteTask(taskId, userId) {
        return await fetch(`http://localhost/GitHub/toDoListApp/controllers/delete_task.php/?taskId=${taskId}&userId=${userId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                return data.success;
            })
            .catch(error => {
                console.error('Error:', error)
                return false;
            });
    }

    async deleteAllTasks(userId) {
        return await fetch(`http://localhost/GitHub/toDoListApp/controllers/delete_all_tasks.php/?userId=${userId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                return data.success;
            })
            .catch(error => {
                console.error('Error:', error)
                return false;
            });
    }

    async updateTaskStatus(newTaskStatus, taskId, userId) {
        return await fetch("http://localhost/GitHub/toDoListApp/controllers/update_task_status.php", {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                newTaskStatus: newTaskStatus,
                taskId: taskId,
                userId: userId
            }),
        })
            .then(response => response.json())
            .then(data => {
                return data.success;
            })
            .catch(error => {
                console.error('Error:', error)
                return false;
            });
    }
}