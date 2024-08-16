<?php

/**
 * file name:
 * 20240816_add_clicked_attribue
 */

function up($pdo)
{
    $sql = "
        ALTER TABLE tasks
        ADD status CHAR(1) DEFAULT '0',
        ADD CONSTRAINT chk_status CHECK (status IN ('0', '1')); 
    ";
    $pdo->exec($sql);
}

function down($pdo)
{
    $sql = "ALTER TABLE tasks
            DROP COLUMN status;
        ";
    $pdo->exec($sql);
}
