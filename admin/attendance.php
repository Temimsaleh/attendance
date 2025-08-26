<?php
require_once __DIR__ . "/../includes/config.php";
require_role('admin');

// حذف سجل
if (isset($_GET['delete'])) {
    $del = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM attendance WHERE id=?")->execute([$del]);
    header("Location: attendance.php");
    exit();
}

// تحديث سجل
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id = (int)($_POST['id'] ?? 0);
    $checkin = $_POST['checkin_time'] ?? null;
    $checkout = $_POST['checkout_time'] ?? null;
    if ($id && $checkin) {
        $stmt = $pdo->prepare("UPDATE attendance SET checkin_time=?, checkout_time=? WHERE id=?");
        $stmt->execute([$checkin, $checkout ?: null, $id]);
    }
}

$rows = $pdo->query("SELECT a.*, u.name FROM attendance a JOIN users u ON a.employee_id=u.id ORDER BY a.id DESC")->fetchAll();
include __DIR__ . "/../includes/header.php";
?>
<h3 class="mb-3">سجل الحضور</h3>
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead><tr><th>#</th><th>الموظف</th><th>دخول</th><th>انصراف</th><th>ساعات</th><th>إجراءات</th></tr></thead>
  <tbody>
    <?php foreach ($rows as $i=>$r):
      $hours = null;
      if ($r['checkin_time'] && $r['checkout_time']) {
        $hours = round((strtotime($r['checkout_time']) - strtotime($r['checkin_time']))/3600, 2);
      }
    ?>
    <tr>
      <td><?php echo $i+1; ?></td>
      <td><?php echo htmlspecialchars($r['name']); ?></td>
      <td><?php echo htmlspecialchars($r['checkin_time']); ?></td>
      <td><?php echo htmlspecialchars($r['checkout_time'] ?? '-'); ?></td>
      <td><?php echo $hours !== null ? $hours : '-'; ?></td>
      <td>
        <!-- زر تعديل يفتح مودال -->
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $r['id']; ?>">تعديل</button>
        <a class="btn btn-sm btn-outline-danger" href="attendance.php?delete=<?php echo (int)$r['id']; ?>" onclick="return confirm('حذف السجل؟');">حذف</a>
      </td>
    </tr>
    <!-- Modal -->
    <div class="modal fade" id="editModal<?php echo $r['id']; ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" class="modal-content">
          <div class="modal-header"><h5 class="modal-title">تعديل السجل</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
          <div class="modal-body">
            <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
            <div class="mb-2"><label class="form-label">وقت الدخول</label><input type="datetime-local" name="checkin_time" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($r['checkin_time'])); ?>" required></div>
            <div class="mb-2"><label class="form-label">وقت الانصراف</label><input type="datetime-local" name="checkout_time" class="form-control" value="<?php echo $r['checkout_time'] ? date('Y-m-d\TH:i', strtotime($r['checkout_time'])) : ''; ?>"></div>
          </div>
          <div class="modal-footer"><button class="btn btn-success">حفظ</button></div>
        </form>
      </div>
    </div>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . "/../includes/footer.php"; ?>
