<?php

  $flag = true;

  // 最初はエラーメッセージ無し
  $err_msg = "";

  // 氏名記載がないとき
  if($_POST["user_name"] == ""){
    $err_msg .= "ユーザ名を入れてください<br>";
    $flag = false;
  }

  // メールアドレス記載がないとき
  if($_POST["user_address"] == ""){
    // .= は文字列の追加
    $err_msg .= "メールアドレスを入れてください<br>";
    $flag = false;
  }

  // パスワードの記載がないとき
  if ($_POST["user_password"] == ""){
    $err_msg .= "パスワードを入れてください<br>";
    $flag = false;
  }

  // パスワード(確認用)がパスワードと一致しないとき
  if($_POST["user_password"] != $_POST["user_password2"]){
    $err_msg .= "パスワードが一致していません<br>";
    $flag = false;
  }

  $host = $_SERVER['HTTP_HOST'];
  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

  // $flag(新規登録欄が問題なく埋まっている)がtrueなら、エコーバック画面を表示
  if($flag) {
    include "confirmAccount.php";
  }
  else {
    // 新規登録画面に戻る際も入力した氏名とメールアドレスはそのまま残る
    $user_name = $_POST["user_name"];
    $user_address = $_POST["user_address"];

    // 転送を削除し、新規登録画面をinclude
    include "newAccount.php";
  }

?>
