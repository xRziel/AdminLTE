<?php

if (empty($_SESSION['username'])) {
    header("Location: /036/project1/login.php");
    exit();
}
?>
