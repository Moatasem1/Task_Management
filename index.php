<?php
session_start();
if (!(isset($_SESSION["isauthenticat"]) && $_SESSION["isauthenticat"])) {
    header('Location: views/sign-in.html');
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>To Do List</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/6c455eb206.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/styles/global.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>

<body class="">
    <div class="page d-flex">
        <section class="sidebar sticky-top text-center py-4 px-3">
            <img src="assets/images/logo.png" alt="">
            <button type="button" data-bs-toggle="modal" data-bs-target="#addTaskModal" name="add task" id="addTaskBtn" class="add-task-btn btn shadow-sm mt-5 mx-auto d-flex align-items-center gap-4 py-2 px-3">
                <span class="d-block text-capitalize fw-medium">add task</span>
                <div class="add-task-icon bg-main-red rounded-pill d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-plus fa-beat text-main-white"></i>
                </div>
            </button>
            <ul class="text-capitalize list-unstyled mt-5 d-flex flex-column gap-3">
                <li>
                    <a class="d-block text-decoration-none text-black p-3 text-start dashbaord__tab dashbaord__tab--active rounded" href="">
                        <i class="fa-solid fa-chart-line me-2"></i>
                        <span>dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="d-block text-decoration-none text-black p-3 text-start dashbaord__tab rounded" href="">
                        <i class="fa-solid fa-clock me-2"></i>
                        <span>active</span>
                    </a>
                </li>
                <li>
                    <a class="d-block text-decoration-none text-black p-3 text-start dashbaord__tab  rounded" href="">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <span>completed</span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="main w-100">
            <header class="header sticky-top py-3 px-4 d-flex justify-content-between align-items-center">
                <h1 class="fs-3 text-capitalize">dashboard</h1>
                <a href="controllers/sign_out.php" type="button" name="" id="" class="btn text-white main-btn-red d-flex align-items-center gap-2">
                    <span class="text-capitalize">Sign out</span>
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </header>
            <section class="content px-4 py-5">
                <div class="hero bg-main-white shadow-sm position-relative px-5 rounded d-flex align-items-center">
                    <div class="text-box">
                        <h2 class="fs-1 fw-bold text-capitalize">Hello, Beautiful <span id="userName" class="text-main-red">Human!</span></h2>
                        <span class="d-block mt-3">What do you want to do today?</span>
                    </div>
                    <div class="hero-img-holder">
                        <img class="img-fluid" src="assets/images/hero-img.png" alt="hero img">
                    </div>
                </div>
                <section class="tasks mt-5">
                    <div class="tasks__text-wrapper text-capitalize d-flex align-items-center justify-content-between">
                        <h3 class="">Today's Tasks</h3>
                        <span id="DeleteAllTasks" role="button" class="text-main-red">Delete all</span>
                    </div>
                    <ul id="TasksParent" class="list-unstyled mt-3">
                        <li class="task shadow-sm bg-main-white rounded mb-3 d-flex align-items-center">
                            <input id="taskid1" type="checkbox" class="task__input d-none" value="Buy monthly groceries">
                            <label role="button" for="taskid1" class="w-100 p-3 d-flex align-items-center gap-2">
                                <i class="task-icon text-main-orange fa-regular fa-square"></i>
                                <span class="task-text w-100">Buy monthly groceries</span>
                            </label>
                            <i role="button" class="fa-solid fa-pen-to-square text-main-orange me-3 edit-task-btn"></i>
                            <i role="button" class="fa-solid fa-trash text-main-orange me-3 delete-task-btn"></i>
                        </li>
                    </ul>
                </section>
            </section>
        </section>
    </div>

    <!-- Modals -->
    <div class="modal fade" data-bs-backdrop="static" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-capitalize fs-5 fw-semibold" id="addTaskModal">add task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="group mb-3">
                        <label for="taskName" class="form-label">Task Name:</label>
                        <input type="text" class="form-control form-control-md border border-secondary-subtle" name="task name" id="taskName" aria-describedby="taskNameHelp" placeholder="" />
                        <small id="taskNameHelp" class="form-text text-body-secondary"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button id="SaveTaskBtn" type="button" class="btn main-btn-red">add task</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/scripts/home.js"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>