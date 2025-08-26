<?php
require_once __DIR__ . "/../includes/config.php";
require_role('employee');

$user = $_SESSION['user'];
// جلب آخر سجل مفتوح (لم يُسجّل انصراف)
$stmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? AND checkout_time IS NULL ORDER BY id DESC LIMIT 1");
$stmt->execute([$user['id']]);
$open_record = $stmt->fetch();
include __DIR__ . "/../includes/header.php";
?>
<h3 class="mb-3">مرحبًا، <?php echo htmlspecialchars($user['name']); ?></h3>
<div class="card p-3 shadow-sm mb-3">
  <div>الحالة الحالية:
    <?php if ($open_record): ?>
      <span class="badge bg-success">مسجّل دخول منذ <?php echo htmlspecialchars($open_record['checkin_time']); ?></span>
    <?php else: ?>
      <span class="badge bg-secondary">غير مسجّل</span>
    <?php endif; ?>
  </div>
  <div class="mt-3 d-flex gap-2">
    <?php if (!$open_record): ?>
      <form method="post" action="/attendance-app/public/actions/employee_checkin.php">
        <button class="btn btn-success">تسجيل دخول (حضور)</button>
      </form>
    <?php else: ?>
      <form method="post" action="/attendance-app/public/actions/employee_checkout.php">
        <input type="hidden" name="attendance_id" value="<?php echo (int)$open_record['id']; ?>">
        <button class="btn btn-danger">تسجيل انصراف</button>
      </form>
    <?php endif; ?>
  </div>
</div>
<a class="btn btn-outline-primary" href="/attendance-app/public/employee/attendance.php">عرض حضوري</a>
<?php include __DIR__ . "/../includes/footer.php"; ?>
