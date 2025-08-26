<?php
require_once __DIR__ . "/../includes/config.php";
require_role('admin');
// إحصاءات بسيطة
$total_employees = $pdo->query("SELECT COUNT(*) AS c FROM users WHERE role='employee'")->fetch()['c'];
$total_records = $pdo->query("SELECT COUNT(*) AS c FROM attendance")->fetch()['c'];
$open_shifts = $pdo->query("SELECT COUNT(*) AS c FROM attendance WHERE checkout_time IS NULL")->fetch()['c'];
include __DIR__ . "/../includes/header.php";
?>
<h3 class="mb-4">لوحة تحكم المدير</h3>
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card stat-card p-3 shadow-sm"><div class="h5">عدد الموظفين</div><div class="display-6"><?php echo (int)$total_employees; ?></div></div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card p-3 shadow-sm"><div class="h5">سجلات الحضور</div><div class="display-6"><?php echo (int)$total_records; ?></div></div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card p-3 shadow-sm"><div class="h5">جلسات مفتوحة</div><div class="display-6"><?php echo (int)$open_shifts; ?></div></div>
  </div>
</div>
<div class="d-flex gap-2">
  <a href="/attendance-app/public/admin/employees.php" class="btn btn-primary">إدارة الموظفين</a>
  <a href="/attendance-app/public/admin/attendance.php" class="btn btn-outline-secondary">سجل الحضور</a>
</div>
<?php include __DIR__ . "/../includes/footer.php"; ?>
