<?php
// سكربت سريع لتعيين أو تحديث حساب المدير.
// نفّذه مرة واحدة عن طريق فتحه في المتصفح ثم احذفه لحماية النظام.
require_once __DIR__ . "/../includes/config.php";

$email = 'hissensaleh1517@gmail.com';
$password_hash = '$2b$12$.sTO/ZB9fPFDgrqsM8qT6.sCoZGpCWbDPj/j0gZWErr17P6SefyKi';
$name = 'المدير';

// هل يوجد مدير؟
$stmt = $pdo->prepare("SELECT * FROM users WHERE role='admin' LIMIT 1");
$stmt->execute();
$admin = $stmt->fetch();

if ($admin) {
    $pdo->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?")->execute([$name, $email, $password_hash, $admin['id']]);
    echo 'تم تحديث حساب المدير إلى: ' . htmlspecialchars($email);
} else {
    $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?, 'admin')")->execute([$name, $email, $password_hash]);
    echo 'تم إنشاء حساب مدير جديد: ' . htmlspecialchars($email);
}

echo "<br>كلمة المرور: 44556677<br>بعد التأكد احذف هذا الملف من المسار /public/actions/set_admin.php";
?>