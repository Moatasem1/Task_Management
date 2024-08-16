<?php

/**
 * file name:
 * 20240817_add_email_to_users
 */

function up($pdo)
{
    $sql = "
        ALTER TABLE users
        ADD COLUMN email VARCHAR(255) not null;

        ALTER TABLE users
        ADD CONSTRAINT email_format CHECK (email regexp '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$');
    ";
    $pdo->exec($sql);
}

function down($pdo)
{
    $sql = "ALTER TABLE users DROP COLUMN email;
            ALTER TABLE users DROP CONSTRAINT email_format;
        ";
    $pdo->exec($sql);
}
