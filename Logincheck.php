<?php
  // session機能を追加
  session_start();

  ///////////////
  // DBと連結  //
  //////////////

  require_once "libs/DBconnect.php";

  $con = connect();
  if (is_null($con))
  {
    header('Location: localhost/top.php');
    return;
  }

  // デフォルト文字セットを設定
  mysqli_set_charset($conn, 'utf8');

  // もとはuser_addressで判定してたがうまくいかないのでuser_nameを使用
  // user_nameに入力された文字列内の特殊文字はエスケープする（セキュアにする）
  $user_name = $_POST["user_name"];
  $user_name_escape = mysqli_real_escape_string($conn, $user_name);
  $user_password = $_POST["user_password"];


  ///////////////////
  // ここから改造   //
  ///////////////////

  // 【実装したい機能】入力パスワードと暗号化したDBパスワードが一致した場合に
  // ログイン処理を進める

  // DB内でユーザ名が一致するレコードを$sqlに代入
  // もとはuser_nameでなくuser_addressを使用
  $sql  = "SELECT * FROM stockuser WHERE user_name = '$user_name_escape'";


  // SQLを発行 (このif文はSQL文がDBに通ったかどうかのみを判別)
  if($result = mysqli_query($conn , $sql)) {

    // 目的のレコードを取り出す
    $row = mysqli_fetch_assoc($result);
    // $sqlで目的のレコードが取り出されているかをチェック
    // echo implode($row);
    // echo $row["user_password"];

    // password_verifyで入力したパスワードと
    // DB内にある暗号化されたパスワードとの一致が確認されれば、ログインを許可する
    if(password_verify($user_password, $row["user_password"])) {
      // echo "ログインＯＫ  " . $row["user_name"] . "様";
      // $flagを使ってログインOK/NGのときの動作を定義する
      $flag = true;
    }
    else {
      // echo "ログインＮＧ";
      $flag = false;
    }
  }
  else {
    echo mysqli_error($conn)."<BR>";
  }


  //////////////////
  // もとのコード  //
  //////////////////

  // // DB内のユーザ名とパスワードが一致するレコードを$sqlに代入
  // // もとはuser_nameでなくuser_addressを使用
  // $sql  = "SELECT * FROM stockuser WHERE user_name = '$user_name' AND ";
  // $sql .= " user_password = '$user_password'";

  // // SQLを発行 (このif文はSQL文がDBに通ったかどうかのみを判別)
  // if($result = mysqli_query($conn , $sql)) {
  //   // 下のfetch文で1行のレコードが取り出せれば、ログインを許可する
  //   if($row = mysqli_fetch_assoc($result)) {
  //     // echo "ログインＯＫ  ". $row["user_name"] . "様";
  //     // $flagを使ってログインOK/NGのときの動作を定義する
  //     $flag = true;
  //   }
  //   else {
  //     // echo "ログインＮＧ";
  //     $flag = false;
  //   }
  // }
  // else {
  //   echo mysqli_error($conn)."<BR>";
  // }


  // MySQLの切断
  mysqli_close($conn);

  /////////////////////
  // ここから画面遷移 //
  ////////////////////

  // このように変数を使ってサーバ情報を記述すれば、if文で繰り返し描かなくても楽。
  $host = $_SERVER['HTTP_HOST'];
  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

  // $flagがtrueなら、main.phpに遷移する
  if($flag){
    // user_idとuser_nameで連想配列を作り、sessionに載せる
    $user = array("user_id" => $row["user_id"] , "user_name" => $row["user_name"]);
    $_SESSION["user"] = $user;
    $extra = "main.php";
    header("Location: http://$host$uri/$extra");
    exit();
  }
  // $flagがfalseなら、login2.html(ログインできませんでした のページ)に遷移
  else{
    // sessionを破壊
    session_destroy();
    // session破壊後に遷移先ページへの移動を行う
    $extra = "login2.php";
    header("Location: http://$host$uri/$extra");
    exit();
  }

?>
