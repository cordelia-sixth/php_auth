<?php
require_once __DIR__ . '/auth.php';
not_logged_in();

// セッションidのCookieを破棄
setcookie(session_name(), '', 1);

// セッションファイルを破棄
session_destroy();
// ログインページへ移動
header('Location: /login.php');
?>
