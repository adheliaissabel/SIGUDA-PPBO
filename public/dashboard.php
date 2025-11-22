<?php
session_start();

// Cegah akses tanpa login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Path absolut ke root folder
$root = dirname(__DIR__);

// Panggil view dashboard
require_once $root . "/App/views/dashboard.php";
