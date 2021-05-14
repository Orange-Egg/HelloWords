<?php
  // newAccount.phpに直接アクセスした時に出現するエラーを消すために試しに入れてみる
  // これだとエコーバック画面で「戻る」押したときに入力データが消去されてしまう
  // $err_msg = "";
  // $user_name= "";
  // $user_address = "";
?>

<!doctype html>
  <html>
    <head>
      <title>新規登録</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="login.css?v=3">
      <link rel="icon" href="images/wordcard.png">
    </head>
    <body>
      <div id="container">        
        <h2>Hello! Words 新規ユーザー登録</h2>
        <div id="message" class="err"><?= $err_msg ?></div>
        <!-- 情報の送り先のページを指定 -->
        <form action="checkAccount.php" method="post"> 
          <table>
            <!-- 氏名とメールアドレスをvalueとして初期値に設定することで
            もしパスワード確認で撥ねられても、新規登録画面で入力した氏名とメールアドレスは表示が残る -->
            <tr>
              <th>ユーザー名</th>
              <td><input type="text" name="user_name" value="<?= $user_name ?>"></td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td><input type="text" name="user_address" value="<?= $user_address ?>"></td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td><input type="password" name="user_password"></td>
            </tr>
            <tr>
              <th>パスワード確認</th>
              <td><input type="password" name="user_password2"></td>
            </tr>
            <!-- <tr>
              <th colspan="2"><input type="submit" value="新規登録"></th>
            </tr> -->
          </table>
          <input class="buttons" type="submit" value="新規登録">
        </form>
        <!-- ログイン画面へ戻るためのリンク -->
        <a href="top.php">トップへ戻る</a> 
      </div>
    </body>
  </html>
