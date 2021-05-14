<?php

///////////////
// PHPパート //
//////////////

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数のセット
$message = array();
$message_array = array();

// セッション開始
session_start();

/*
 *
 *過去に投稿されたメッセージを表示
 *- データベース接続をこのファイルで行う際は、DBへデータを送る時同様に設定を整える
 *  $mysqli = new mysqli( 'localhost:3307', 'root', '', 'hellowordsdb');
 *  でなく
 *  $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
 *- SQL文でDBからデータ取得しブラウザに表示
 *
 */

// 外部ファイルの読み込み:include文(require_onceの方がベター)を使いDBに接続
require_once "DBconnect.php";

// ↓SQL文を用いてメッセージのデータを取得
$sql = "SELECT view_name,message,post_date FROM stockpost ORDER BY post_date DESC";
// query(): DBに対してクエリを実行（=mysqli_query()）
$res = $conn->query($sql);
// connect($sql);

// クエリ実行可能な場合は連想配列で投稿を返す。
// fetch_all():
// すべての結果行をフェッチし、結果セットを
// 連想配列、数値配列、またはその両方として返します。
if( $res ) {
    $message_array = $res->fetch_all(MYSQLI_ASSOC);
}

?>


<!-- HTMLパート -->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- hrefにはキャッシュ対策で?v=2追加してもよい -->
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
            <li><a href="./login.php">ログイン</a></li>
            <li><a href="./newAccount0.php">新規登録</a></li>          
          </ul>
        </nav>
      </header>

      <!-- メイン -->
      <div class="main">
        <div class="introduce">
          <div class="asking">
            <br>
            <h1>語彙力不足による</h1>
            <h1>英語のスキルアップに悩んでいませんか？</h1>
            <br>
            <p>Hello, Words! は、効率よく英語ボキャブラリーを増やすことを目的とした英語学習専用の無料掲示板です。</p>
            <p>アカウント登録を行うと、投稿機能を使うことができるので、仲間と交流しながら効率的に英語学習を</p>
            <p>進めることができます。英語を学ぶ上でのお悩み相談もOK! さあ、気軽な気持ちで始めてみませんか?</p>
          </div>          
        </div>
        <br> 
      <!-- 投稿されたメッセージの表示 -->
        <section>
        <?php if( !empty($message_array) ): ?>
        <?php foreach( $message_array as $value ): ?>
        <article>
          <div class="info">
            <h2><?php echo $value['view_name']; ?></h2>
            <!-- 本来はH:iの前に&nbsp;入れる必要があるかも -->
            <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
          </div>
          <p><?php echo nl2br($value['message']); ?></p>
        </article>
        <br>
        <?php endforeach; ?>
        <?php endif; ?>
        </section>
      </div>
      <br>


      <!-- フッター -->
      <footer>
        <div class="footer-list">
          <ul>
            <li><i class="fab fa-facebook fb"></i></li>
            <li><i class="fab fa-instagram ig"></i></li>
            <li><i class="fab fa-twitter tw"></i></li>
            <li>Copyright (c) All Rights Reserved by Saori Horiuchi</li>
            <li><a href="top.php">ページ先頭に戻る</a></li>
          </ul>
        </div>
      </footer>
    </div>
  </body>
</html>