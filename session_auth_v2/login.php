<?php

require_once __DIR__ . '/function.php';
require_unlogined_session();

// 事前に生成したユーザごとのパスワードハッシュの配列。これはこの実装の為をテストするためのものです。
// つまりDBの代わりです。
$hashes = [
    'test' => '$2y$10$h9f8xS7/KhIisz/ERy8YAu8TgAFUVY/jU8ot/9OWqn0gGuFFjLHXq',
]; 

// 入力フォームから受け取ったユーザ名とパスワード
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// POSTメソッドで送信されてきた時のみ実行する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        // 送信されてきたcsrfトークンと、それを生成したセッションidが一致するか確認して、
        validate_token(filter_input(INPUT_POST, 'token')) &&

        // パスワードも一致するか確認する
        password_verify(
            $password, // 送信されてきたパスワード
            isset($hashes[$username]) // ユーザー名が存在するか
                ? $hashes[$username] // 存在する場合はパスワードハッシュを返す
                : '$2y$10$TThG3fsMJegLJHzVQb' // ユーザ名が存在しないときだけ極端に速くなるのを防ぐ
        )
    ) {
        // 認証が成功したとき
        // セッションIDの追跡を防ぐためにセッションidを再生成する
        session_regenerate_id(true);
        // ユーザ名をセット
        $_SESSION['username'] = $username;
        // ログイン完了後に / に遷移
        header('Location: /');
        exit;
    }
    // 認証が失敗したとき
    // 「403 Forbidden」
    http_response_code(403);
}

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
  <title>ログインページ</title>

  <h1>ログインしてください</h1>
  <form method="post" action="">
    <p>ユーザ名: <input type="text" name="username" value=""></p>
    <p>パスワード: <input type="password" name="password" value=""></p>

    <!-- csrfトークンを生成して送信する。この時点でセッションIDは生成されている -->
    <input type="hidden" name="token" value="<?= h(generate_token()) ?>">
    <input type="submit" value="ログイン">
  </form>

  <?php if (http_response_code() === 403): ?>
    <p style="color: red;">ユーザ名またはパスワードが違います</p>
  <?php endif; ?>
</html>
