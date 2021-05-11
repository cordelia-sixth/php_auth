<?php
// ログイン処理をするページ

session_start();

// DBに接続する
try {
  $pdo = new PDO(
    "mysql:host=127.0.0.1;port=3306;dbname=php_dev",
    "root",
    "password"
  );
} catch (PDOExeption $e) {
  exit("DB error");
}

// 送信されたユーザ名とパスワードを取得する
$userName = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");

// POSTで送信されてきた時のみ実行する
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (empty($userName) || empty($password) ) {
    $message = "ユーザー名とパスワードを入力してください";
  } else {
    try {
      $stmt = $pdo -> prepare("SELECT * FROM users WHERE name=?");
      $stmt -> bindParam(1, $userName, PDO::PARAM_STR, 10);
      $stmt -> execute();
      $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    } catch (PDOExeption $e) {
      exit("DB error");
    }
    if (!password_verify($password, $result["pass"])) {
      $message = "ユーザー名かパスワードが違います";
    } else {
      session_regenerate_id(true);
      $_SESSION["username"] = $userName;
      header("Location: /");
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
</head>
<body>
  <h2>ログイン</h2>

  <form method="post" action="">
    <p>ユーザー名: <input type="text" name="username" /></p>
    <p>パスワード: <input type="password" name="password" /></p>
    <input type="submit" value="ログイン">
  </form>

  <?php if ($message) : ?>
    <p><?php echo($message) ?></p>
  <?php endif; ?>
</body>
</html>
