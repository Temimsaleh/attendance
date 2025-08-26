<?php include __DIR__ . "/includes/header.php"; ?>
<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-3">تسجيل الدخول</h3>
        <form method="post" action="/attendance-app/public/actions/auth_login.php">
          <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">دخول</button>
        </form>
        <p class="mt-3 text-muted small">يُنشئ المدير حسابات الموظفين من لوحة التحكم.</p>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
