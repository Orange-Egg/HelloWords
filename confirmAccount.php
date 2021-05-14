<!doctype html>
  <html>
    <head>
      <title>新規登録</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="login.css?v=3">
    </head>
    <body>
      <div id="container">
        <h2>Hello！Words 新規ユーザー登録</h2>
        <!-- action要素で情報の送り先のページを指定 -->
        <form action="registAccount.php" method="post">
          <table>
            <tr>
              <th>氏名</th>
              <td><?= $_POST["user_name"]; ?></td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td><?= $_POST["user_address"]; ?></td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td>表示しません</td>
            </tr>
            <tr>
              <th colspan="2">
                <input type="hidden" name="user_name" value="<?= $_POST["user_name"] ?>">
                <input type="hidden" name="user_address" value="<?= $_POST["user_address"] ?>">
				        <input type="hidden" name="user_password" value="<?= $_POST["user_password"] ?>">

              </th>
            </tr>
          </table>
          <input class="buttons" type="submit" name="return" value="戻る">
          <input class="buttons" type="submit" name="register" value="登録">
        </form>
        <!-- ログイン画面へ戻るためのリンク -->
        <a href="top.php">トップへ戻る</a>
      </div>
    </body>
  </html>
