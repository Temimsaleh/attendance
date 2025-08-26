<?php
require_once __DIR__ . "/../includes/config.php";
require_role('employee');

$uid = $_SESSION['user']['id'];
// تأكد من عدم وجود سجل مفتوح
$stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM attendance WHERE employee_id=? AND checkout_time IS NULL");
$stmt->execute([$uid]);
if ($stmt->fetch()['c'] > 0) {
    header("Location: /attendance-app/public/employee/dashboard.php?msg=" . urlencode("لديك جلسة مفتوحة بالفعل"));
    exit();
}

$pdo->prepare("INSERT INTO attendance (employee_id, checkin_time) VALUES (?, NOW())")->execute([$uid]);
header("Location: /attendance-app/public/employee/dashboard.php");
exit();
