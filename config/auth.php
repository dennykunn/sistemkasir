<?php
if (!isset($_SESSION['user'])) {
    header("Location: /sistemkasir/login.php");
    exit;
}
