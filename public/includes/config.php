<?php
// إعدادات قاعدة البيانات (عدّل القيم حسب XAMPP لديك)
$DB_HOST = "localhost";
$DB_NAME = "attendance_db";
$DB_USER = "root";
$DB_PASS = ""; // الافتراضي في XAMPP

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

session_start();

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: /attendance-app/public/login.php");
        exit();
    }
}

function require_role($role) {
    require_login();
    if ($_SESSION['user']['role'] !== $role) {
        header("Location: /attendance-app/public/index.php");
        exit();
    }
}
?>
