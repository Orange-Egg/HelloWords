<?php
/* DBにユーザを新規登録
*  するためのファイル
*/

// セッション開始
session_start();

// 新規登録ボタンが押された時の確認項目
if(isset($_POST["register"])){

    // DB接続のためのファイルを読み込み
    include "DBconnect.php";

    $user_name = $_POST["user_name"];
    $user_address = $_POST["user_address"];

    // パスワードはハッシュ化するので下のコードは不要
    // $user_password = $_POST["user_password"];

    // デフォルト文字セットを設定
    mysqli_set_charset($conn, 'utf8');

    // 登録前にパスワードをハッシュ化しセキュアにする ※$_SESSIONではなく$_POSTを使用
    $hash = password_hash($_POST["user_password"], PASSWORD_DEFAULT);

    // $hashに含まれる特殊文字をエスケープする
    $hashed = mysqli_real_escape_string($conn, $hash);

    // insert文の組み立て・sql文を発行し$sqlに代入
    $sql = "INSERT INTO stockUser (user_name , user_address , user_password , enable) ";
    $sql .= " VALUES ('$user_name' , '$user_address' , '$hashed' , 1)";

    // プレースホルダーを使ってSQLインジェクション対策してもよい
    // プレースホルダーとして?を使用する
    // $sql = "INSERT INTO stockUser (user_name , user_address , user_password , enable) ";
    // $sql .= " VALUES (? , ? , ? , 1)";


  // 必要な情報が揃っていれば、ユーザ情報を登録
  // カッコ内、挿入できたか？をif文で条件分岐
  if($result = mysqli_query($conn , $sql) ){

      // 挿入できていれば、sessionに積む
      $user = array("user_id" => mysqli_insert_id($conn) , "user_name" => $user_name);
      $_SESSION["user"] = $user;
      $host = $_SERVER['HTTP_HOST'];
      $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = "main.php";

      // 一覧画面に転送
      header("Location: http://$host$uri/$extra");
      exit();
  }
  // 挿入できなかった時(入力不足)
  else {
      // 入力画面に戻す
      $err_msg = mysqli_error($conn);
      $user_name = $_POST["user_name"];
      $user_address = $_POST["user_address"];
      include "newAccount.php";
  }
}
// 戻るボタンが押された時、ひとつ前の入力画面へ戻す処理
else {
    $err_msg = "";
    $user_name = $_POST["user_name"];
    $user_address = $_POST["user_address"];
    include "newAccount.php";

}
?>
