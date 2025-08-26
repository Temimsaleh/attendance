<?php
require_once __DIR__ . "/includes/config.php";
session_destroy();
header("Location: /attendance-app/public/login.php?msg=" . urlencode("تم تسجيل الخروج بنجاح"));
exit();
