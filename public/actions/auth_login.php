<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/auth.php";

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify_safe($password, $user['password'])) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ];
    if ($user['role']==='admin') {
        header("Location: /attendance-app/public/admin/dashboard.php");
    } else {
        header("Location: /attendance-app/public/employee/dashboard.php");
    }
    exit();
}

header("Location: /attendance-app/public/login.php?msg=" . urlencode("بيانات الدخول غير صحيحة"));
exit();
