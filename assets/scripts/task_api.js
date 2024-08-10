export class TaskApi {

    addTask(taskName, userId) {
        fetch("http://localhost/GitHub/toDoListApp/controllers/add_task.php", {
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
                }
            })
            .catch(error => console.error('Error:', error));

        return null;
    }
}