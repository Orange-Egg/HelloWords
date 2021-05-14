<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css?v=5">
    <link rel="icon" href="images/wordcard.png">
    <title>Hello！Words ログイン</title>
</head>
<body>
  <div id="container">
    <h2>Hello! Words ログイン画面</h2>
    <p>ログイン情報を入力してください</p>
    <!-- action属性で情報の送り先となるページ(Logincheck.php)を指定 -->
    <form action="Logincheck.php" method="post"> 
      <table>
        <tr>
          <th>ユーザー名</th>
          <td><input type="text" name="user_name"></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" name="user_password"></td>
        </tr>
      </table>
      <input class="buttons" type="submit" href="main.php" value="ログイン">
    </form>
    <a href="top.php">トップへ戻る</a> 
  </div>
</body>
</html>