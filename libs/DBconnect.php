<?php
    // DBに繋ぐためのファイル

    /*
    // サーバへの接続情報を登録
    $DBSERVER = "localhost:3307";
    $DBUSER = "root";
    $DBPASSWORD = "";
    $DBNAME  = "hellowordsdb";

    //MySQLへの接続
    $conn = mysqli_connect($DBSERVER , $DBUSER , $DBPASSWORD , $DBNAME);

    //接続時にエラーが発生していれば、エラーメッセージを表示
    if(mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit();
    } else {
        // 下のコードは削除(表示があるとページ遷移ができないため)
        // echo "Connect OK";
    }
    */


    // 上のコード（DB接続）は関数化してまとめると便利
    function connect()
    {
        $DBSERVER = "localhost:3307";
        $DBUSER = "root";
        $DBPASSWORD = "";
        $DBNAME  = "hellowordsdb";
        //
        $con = mysqli_connect($DBSERVER , $DBUSER , $DBPASSWORD , $DBNAME);
        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
            // 接続error時はnullを返す
            return null;
        }
        // errorがなければDB接続を返す
        return $con;
    }