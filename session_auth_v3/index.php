<?php
// ログイン後のページ

require_once __DIR__ . '/auth.php';
not_logged_in();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ユーザ専用ページ</title>
</head>
<body>
  <h3>ようこそ <?= ($_SESSION['username'])?>さん</h3>
  <a href="/logout.php">ログアウト</a>
</body>
</html>
