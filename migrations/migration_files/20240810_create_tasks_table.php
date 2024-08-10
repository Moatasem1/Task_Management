<?php

/**
 * file name:
 * 20240810_create_tasks_table.php
 */

function up($pdo)
{
    $sql = "
            create table tasks(
                id int primary key AUTO_INCREMENT ,
                task_name varchar(400) not null,
                user_id int not null,
                foreign key (user_id) references users(id),
                index(user_id)
            );
    ";
    $pdo->exec($sql);
}

function down($pdo)
{
    $sql = "DROP TABLE tasks";
    $pdo->exec($sql);
}
