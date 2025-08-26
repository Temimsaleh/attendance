<?php
require_once __DIR__ . "/../includes/config.php";
require_role('admin');
include __DIR__ . "/../includes/auth.php";

// حذف
if (isset($_GET['delete'])) {
    $del = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM users WHERE id=? AND role='employee'")->execute([$del]);
    header("Location: employees.php");
    exit();
}

// معالجة إنشاء/تحديث موظف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $email) {
        // تحديث
        if ($id) {
            if ($password) {
                $hash = password_hash_safe($password);
                $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=? AND role='employee'");
                $stmt->execute([$name, $email, $hash, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET name=?, email=? WHERE id=? AND role='employee'");
                $stmt->execute([$name, $email, $id]);
            }
        } else {
            // إنشاء جديد - كلمة المرور الافتراضية إذا لم تُعطَ
            $hash = password_hash_safe($password ? $password : '123456');
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?, 'employee')");
            $stmt->execute([$name, $email, $hash]);
        }
    }

    header("Location: employees.php");
    exit();
}

// جلب الكل
$rows = $pdo->query("SELECT id,name,email FROM users WHERE role='employee' ORDER BY id DESC")->fetchAll();
include __DIR__ . "/../includes/header.php";
?>
<h3 class="mb-3">إدارة الموظفين</h3>
<div class="row">
  <div class="col-md-5">
    <div class="card p-3 shadow-sm">
      <h5>إضافة موظف جديد</h5>
      <form method="post">
        <div class="mb-2"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">البريد الإلكتروني</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">كلمة المرور</label><input type="text" name="password" class="form-control" placeholder="افتراضي 123456"></div>
        <button class="btn btn-primary w-100">إضافة</button>
      </form>
    </div>
  </div>
  <div class="col-md-7">
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead><tr><th>#</th><th>الاسم</th><th>البريد</th><th>إجراءات</th></tr></thead>
        <tbody>
          <?php foreach ($rows as $i=>$r): ?>
          <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo htmlspecialchars($r['name']); ?></td>
            <td><?php echo htmlspecialchars($r['email']); ?></td>
            <td>
              <a class="btn btn-sm btn-outline-primary" href="employees.php?edit=<?php echo (int)$r['id']; ?>">تعديل</a>
              <a class="btn btn-sm btn-outline-danger" href="employees.php?delete=<?php echo (int)$r['id']; ?>" onclick="return confirm('حذف الموظف؟');">حذف</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php if (isset($_GET['edit'])):
      $eid = (int)$_GET['edit'];
      $emp = $pdo->prepare("SELECT * FROM users WHERE id=? AND role='employee'");
      $emp->execute([$eid]);
      $emp = $emp->fetch();
      if ($emp):
    ?>
    <div class="card p-3 shadow-sm mt-3">
      <h5>تعديل بيانات موظف</h5>
      <form method="post">
        <input type="hidden" name="id" value="<?php echo (int)$emp['id']; ?>">
        <div class="mb-2"><label class="form-label">الاسم</label><input name="name" class="form-control" value="<?php echo htmlspecialchars($emp['name']); ?>" required></div>
        <div class="mb-2"><label class="form-label">البريد الإلكتروني</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($emp['email']); ?>" required></div>
        <div class="mb-2"><label class="form-label">كلمة المرور (اتركه فارغًا للإبقاء عليها)</label><input type="text" name="password" class="form-control"></div>
        <button class="btn btn-success w-100">حفظ التعديلات</button>
      </form>
    </div>
    <?php endif; endif; ?>
  </div>
</div>
<?php include __DIR__ . "/../includes/footer.php"; ?>
