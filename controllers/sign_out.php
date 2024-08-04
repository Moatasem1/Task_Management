<?php
session_start();
session_destroy();
header('Location: ../views/sign-in.html');
exit();
