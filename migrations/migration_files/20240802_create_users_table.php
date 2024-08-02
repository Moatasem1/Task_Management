<?php

/**
 * file name:
 * 20240802_create_users_table.php
 */

function up($pdo)
{
    $sql = "
        create table users(
        id int auto_increment primary key,
        username varchar(20) unique not null,
        password_hash varchar(225) not null,
        constraint username_length check (char_length(username) between 3 and 20),
        constraint username_formate check (username regexp '^[a-zA-Z0-9_]+$')
        );
    ";
    $pdo->exec($sql);
}

function down($pdo)
{
    $sql = "DROP TABLE users";
    $pdo->exec($sql);
}
