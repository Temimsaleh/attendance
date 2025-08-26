<?php
require_once __DIR__ . "/../includes/config.php";
require_role('employee');
$user = $_SESSION['user'];
$stmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? ORDER BY id DESC");
$stmt->execute([$user['id']]);
$rows = $stmt->fetchAll();
include __DIR__ . "/../includes/header.php";
?>
<h3 class="mb-3">سجلات حضوري</h3>
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead><tr><th>#</th><th>دخول</th><th>انصراف</th><th>عدد الساعات</th></tr></thead>
  <tbody>
    <?php foreach ($rows as $i=>$r): 
      $hours = null;
      if ($r['checkin_time'] && $r['checkout_time']) {
        $hours = round((strtotime($r['checkout_time']) - strtotime($r['checkin_time']))/3600, 2);
      }
    ?>
      <tr>
        <td><?php echo $i+1; ?></td>
        <td><?php echo htmlspecialchars($r['checkin_time']); ?></td>
        <td><?php echo htmlspecialchars($r['checkout_time'] ?? '-'); ?></td>
        <td><?php echo $hours !== null ? $hours : '-'; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . "/../includes/footer.php"; ?>
