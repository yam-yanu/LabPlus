<?php
  function executeQuery($sql){
    $url = "localhost";
    $user = "root";
    $pass = "amilab123";
    $db = "sampledb050";

    // MySQLへ接続する
    $link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");
    
    //MySQLのクライアントの文字コードをutf8に設定
    mysql_query("SET NAMES utf8")
    or die("can not SET NAMES utf8");

    // データベースを選択する
    $sdb = mysql_select_db($db,$link) or die("データベースの選択に失敗しました。");

    // クエリを送信する
    $result = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);

    // MySQLへの接続を閉じる
    mysql_close($link) or die("MySQL切断に失敗しました。");

    //戻り値
    return($result);
  }
?>