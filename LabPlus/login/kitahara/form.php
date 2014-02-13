<?php
  //セッションの開始
  session_start();

  include('view.php');

  //ファイルを読み込む
  //require_once("SampleDB050.php");

  //現在時刻の取得
  $now_time = date(ymdHi,time());

  // IPアドレスを取得して変数にセットする
  $ipAddress = $_SERVER["REMOTE_ADDR"];



  $agent = $_SERVER['HTTP_USER_AGENT'];

  if(ereg("^DoCoMo", $agent)){//docomo
  
  $tanmatu=3;

  }else if(ereg("^J-PHONE|^Vodafone|^SoftBank", $agent)){//SB

  $tanmatu=3;

  }else if(ereg("^UP.Browser|^KDDI", $agent)){//au

    $tanmatu=3;

  }else if(ereg("iPhone", $agent)){//iPhone

   $tanmatu=1;

  }else if(ereg("Android", $agent)){//android

   $tanmatu=2;

  }else{

    $tanmatu=0;

  }



if($tanmatu==1){//iphoneなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '99', '".$_SESSION['name']."', '".$now_time."','','1','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==0){//pcなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '99', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==2){//androidなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '99', '".$_SESSION['name']."', '".$now_time."','','2','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==3){//ガラケーなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '99', '".$_SESSION['name']."', '".$now_time."','','3','".$ipAddress."')";
 $result = executeQuery($sql);

}
 

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script
       src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"
       type="text/javascript"
        ></script>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel=stylesheet href="style1.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>lab view</title>

<style type="text/css">

input, select, textarea {
background-color: #FFC0CB;
}
option.example2 {
background-color: #F5F5F5;
}

</style>

</head>
<body bgcolor="#FF00FF"  background="./img/kaminari.png" text="#ffffff">

<br>●ステータスの更新●<br><br>
<form action="insert.php" method="POST">

<input type="radio" name="status" value="0"/>暇<br/>
<input type="radio" name="status" value="1"/>普通<br/>
<input type="radio" name="status" value="2"/>忙しい<br/>
<br><br>
コメント：<input type="text" name="comment" value="" size="32" />
<input type="submit" value="変更"/><input type="reset" value="クリア">
<br><br>
<a href="http://49.212.200.39/login/kitahara/phpver.php">戻る</a>
</form>

</body>
</html>

