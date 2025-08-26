<?php require_once __DIR__ . "/config.php"; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>نظام حضور الموظفين</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/attendance-app/public/assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/attendance-app/public/index.php">حضور+</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <?php if (is_logged_in()): ?>
            <?php if ($_SESSION['user']['role']==='admin'): ?>
                <li class="nav-item"><a class="nav-link" href="/attendance-app/public/admin/dashboard.php">لوحة التحكم</a></li>
                <li class="nav-item"><a class="nav-link" href="/attendance-app/public/admin/employees.php">الموظفون</a></li>
                <li class="nav-item"><a class="nav-link" href="/attendance-app/public/admin/attendance.php">سجل الحضور</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/attendance-app/public/employee/dashboard.php">لوحة الموظف</a></li>
                <li class="nav-item"><a class="nav-link" href="/attendance-app/public/employee/attendance.php">حضوري</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="/attendance-app/public/logout.php">تسجيل الخروج</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/attendance-app/public/login.php">تسجيل الدخول</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="py-4">
<div class="container">
