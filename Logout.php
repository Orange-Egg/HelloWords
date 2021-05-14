<?php
  // ログアウトを行うための操作
  session_start();
  // session破壊
  session_destroy();

  // ログイン画面に転送を行う
  $host = $_SERVER['HTTP_HOST'];
  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = "top.php";
  header("Location: http://$host$uri/$extra");
?>
