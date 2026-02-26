<?php
session_start();

if (isset($_POST['confirm_logout'])) {

    $_SESSION = [];
    session_destroy();
    header("Location: login.php");
    exit();
}
