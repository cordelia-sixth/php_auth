<?php
// ログイン後のページ

require_once __DIR__ . '/function.php';

// 未ログインならログインページへ移動する
require_logined_session();

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
<title>会員限定ページ</title>
<h1>ようこそ,<?=h($_SESSION['username'])?>さん</h1>
<a href="/logout.php?token=<?=h(generate_token())?>">ログアウト</a>
