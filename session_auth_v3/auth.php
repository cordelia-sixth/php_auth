<?php

// 関数をまとめたやつ

// ログイン済みならルートページへ移動
function logged_in() {
    @session_start();
    if(isset($_SESSION["username"])) {
        header("Location: /");
        exit;
    }
}

// 未ログインならログインページへ移動
function not_logged_in() {
    @session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: /logout.php");
        exit;
    }
}
?>
