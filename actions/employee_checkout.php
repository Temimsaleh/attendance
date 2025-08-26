<?php
require_once __DIR__ . "/../includes/config.php";
require_role('employee');

$uid = $_SESSION['user']['id'];
$attendance_id = (int)($_POST['attendance_id'] ?? 0);
// تأكد أن السجل يعود لنفس الموظف
$stmt = $pdo->prepare("SELECT * FROM attendance WHERE id=? AND employee_id=? AND checkout_time IS NULL");
$stmt->execute([$attendance_id, $uid]);
if (!$stmt->fetch()) {
    header("Location: /attendance-app/public/employee/dashboard.php?msg=" . urlencode("سجل غير صالح"));
    exit();
}

$pdo->prepare("UPDATE attendance SET checkout_time = NOW() WHERE id=?")->execute([$attendance_id]);
header("Location: /attendance-app/public/employee/dashboard.php");
exit();
