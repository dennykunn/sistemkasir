<?php
if (!isset($_SESSION['user'])) {
    header("Location: /x/login.php");
    exit;
}
