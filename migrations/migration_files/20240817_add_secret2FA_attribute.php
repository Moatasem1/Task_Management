<?php

/**
 * file name:
 * 20240817_add_secret2FA_attribute
 */

function up($pdo)
{
    $sql = "
       ALTER TABLE users
    ADD COLUMN two_factor_secret_key VARCHAR(255) not null;
    ";
    $pdo->exec($sql);
}

function down($pdo)
{
    $sql = "ALTER TABLE users DROP COLUMN two_factor_secret_key;
        ";
    $pdo->exec($sql);
}
