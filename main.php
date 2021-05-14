<?PHP

/*
 * PHPパート
 */

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$now_date = null; // 日時を入れる変数
$data = null; // 扱うデータを入れる変数
$split_data = null;
$message = array();
$message_array = array();
$success_message = null; // htmlにメッセージがあるかどうかの判断を入れる変数
$error_message = array(); // エラーメッセージの配列
$clean = array(); // 投稿されたデータのサニタイズ(コードの無害化)

// セッション開始
session_start();

// ユーザ情報がDBにあるかをチェック(LoginCheck.phpで作った連想配列を使ってチェック)
// ユーザ情報がある時
if(isset($_SESSION["user"])){
	  // セッションからユーザ情報を取り出す
	  $user = $_SESSION["user"];
// ユーザ情報がないとき
} else {
	  // まずsessionを破壊
	  session_destroy();
	  // ログイン画面に転送要求を出してページを遷移
	  $host = $_SERVER['HTTP_HOST'];
	  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	  $extra = "top.php";
	  header("Location: http://$host$uri/$extra");
	  // プログラムを終了する
    exit();
}


///////////////////////////////////
// メッセージを投稿できるようにする //
///////////////////////////////////

// 書き込むボタンが押されたときの条件分岐
if( !empty($_POST['btn_submit'])) {
    // 表示名の入力チェック
    if( empty($_POST['view_name'])) {
        $error_message[] = '表示名を入力してください。';
    } else {
        //コードをサニタイズし無害化する
        $clean['view_name'] = htmlspecialchars( $_POST['view_name'], ENT_QUOTES);
        // 掲示板に書き込みを行うタイミングで「表示名」の入力があるときにセッションに表示名を保存
        $_SESSION['view_name'] = $clean['view_name'];
    }

    // メッセージの入力チェック
    if( empty($_POST['message'])) {
        $error_message[] = '投稿内容を入力してください。';
    } else {
        //コードをサニタイズし無害化する(XSS対策)
        $clean['message'] = htmlspecialchars( $_POST['message'], ENT_QUOTES);
        // メッセージ中に改行があった場合はbr要素を加える
        $clean['message'] = preg_replace( '/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
    }

    // エラーメッセージが無い場合は、SQL文で入力データをDBに送る処理へ進む
    if( empty($error_message)) {

        // 外部ファイルの読み込み:include文を使用してDBにつなぐ
        include "DBconnect.php";

        // 接続エラーの確認 $conn->connect_errno: 直近の接続コールに関するエラーコードを返す
        if( $conn->connect_errno ) {

            //エラー時の処理 $conn->connect_error: 直近の接続エラーの内容を文字列で返す
            $error_message[] = '書き込みに失敗しました。 エラー番号 '.$conn->connect_errno.' : '.$conn->connect_error;

        } else {

            // 接続エラーが無い場合、データ登録の処理を記述
            // DBにアクセスする文字コード設定
            $conn->set_charset('utf8');

            // 書き込み日時を取得
            $now_date = date("Y-m-d H:i:s");

            // データを登録するSQL作成
            $sql = "INSERT INTO stockpost (view_name, message, post_date) VALUES ( '$clean[view_name]', '$clean[message]', '$now_date')";

            // データを登録 queryメソッドの返り値は$resに入る。クエリ成功:true、失敗:false
            $res = $conn->query($sql);


        if( $res ) {
            $_SESSION['success_message'] = 'メッセージを書き込みました。';
        } else {
            $error_message[] = '書き込みに失敗しました。';
        }

      // データベースの接続を閉じる
      // $mysqli->close();
      }
      // header関数(進むリンク先を指定)
      header('Location: ./main.php');
    }
}


///////////////////////////////////////////////////////////////////////////////
// 過去に投稿されたメッセージを表示                                             //
// -データベースに接続 DBへデータを送る時同様に設定を整える                       //
//  $mysqli = new mysqli( 'localhost:3307', 'root', '', 'hellowordsdb');     //
//  $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);               //
// -SQL文でDBからデータ取得しブラウザに表示                                     //
///////////////////////////////////////////////////////////////////////////////


// 外部ファイルの読み込み:include文を使用してDBにつなぐ
include "DBconnect.php";

// ↓データを取得する処理
$sql = "SELECT view_name,message,post_date FROM stockpost ORDER BY post_date DESC";
$res = $conn->query($sql);
// SQLに接続
// connect($sql);

if( $res ) {
  $message_array = $res->fetch_all(MYSQLI_ASSOC);
}

?>


<!------------------
      HTMLパート
-------------------->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="stylesheet.css?v=4">
  <link rel="stylesheet" type="text/css" href="responsive.css?v=2">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="icon" href="images/wordcard.png">
  <title>Hello, Words!</title>
</head>

<body>
  <div class="container">

    <!-- ヘッダー -->
    <header>
      <nav id="entnav">
        <h1>&nbsp;Hello, Words!</h1>
        <ul class="header-list">
          <li><a href="Logout.php">ログアウト</a></li>
        </ul>
      </nav>
      <!-- sessionから取得したユーザ名を表示させる -->
    </header>

    <!-- メイン -->
    <div class="main">

      <div id="header_user">こんにちは、 <?= $user["user_name"] ?> さん</div>

      <!-- メッセージの入力フォーム -->
      <form method="post">
        <div class="contents">
          <label for="view_name">表示名</label><br>
          <!-- セッションに「表示名」があったら入力された状態になるように設定 -->
          <input id="view_name" type="text" name="view_name" value="<?php if( !empty($_SESSION['view_name'])){ echo $_SESSION['view_name']; } ?>">
        </div>
        <div class="contents">
          <label for="message">投稿内容</label><br>
          <textarea id="message" name="message"></textarea>
        </div>
        <input class="buttons" type="submit" name="btn_submit" value="書き込む">
      </form>
      <hr>

      <!-- 投稿されたメッセージの表示 -->
      <section>
      <?php if( !empty($message_array)): ?>
      <?php foreach( $message_array as $value ): ?>
      <article>
          <div class="info">
              <h2><?php echo $value['view_name']; ?></h2>
              <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
          </div>
          <p><?php echo nl2br($value['message']); ?></p>
      </article>
      <br>
      <?php endforeach; ?>
      <?php endif; ?>
      </section>
    </div>



    <!-- フッター -->
    <footer>
      <div class="footer-list">
        <ul>
          <li><i class="fab fa-facebook fb"></i></li>
          <li><i class="fab fa-instagram ig"></i></li>
          <li><i class="fab fa-twitter tw"></i></li>
          <li>Copyright (c) All Rights Reserved by Saori Horiuchi</li>
          <li><a href="top.php">ページTOPに戻る</a></li>
        </ul>
      </div>
    </footer>
  </div>
</body>
</html>