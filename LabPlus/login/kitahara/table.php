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

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '98', '".$_SESSION['name']."', '".$now_time."','','1','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==0){//pcなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '98', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==2){//androidなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '98', '".$_SESSION['name']."', '".$now_time."','','2','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==3){//ガラケーなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '98', '".$_SESSION['name']."', '".$now_time."','','3','".$ipAddress."')";
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
<title>メンバーの情報</title>


</head>
<body bgcolor="#000000" text="#ffffff" LINK="#008800" VLINK="#ffffff">



<script type="text/javascript">
<!--


// -->
</script>

<style>
.floating { float: left; width: 100px; height: 100px; margin-right: 10px; }
</style>

<a color:#000000; href="http://49.212.200.39/login/kitahara/phpver.php">TOPへ</a><br><br>
<a color:#000000; href="http://49.212.200.39/login/kitahara/form.php">ステータス変更画面へ</a>

<br><br>
<table  class="floating" style="table-layout:fixed;" style="border-collapse: collapse;border:3px double #00ffff;background-color:#ffff00;color:#000000;text-align:left;">
<tbody>
<tr>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#00ffff;color:#000000;text-align:center;">メンバー&nbsp;</th>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#00ffff;color:#000000;text-align:center;">コメント&nbsp;</th>
</tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/ookubo.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $ookubo[1]; ?>&nbsp;</td></tr>

</tbody></table>




<table  class="floating" style="table-layout:fixed;" style="border-collapse: collapse;border:3px double #00ffff;background-color:#ffff00;color:#000000;text-align:left;">
<tbody>
<tr>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FF00FF;color:#000000;text-align:center;">メンバー&nbsp;</th>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FF00FF;color:#000000;text-align:center;">コメント&nbsp;</th>
</tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/fujii.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $fujii[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/yamashita.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $yamashita[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/watanabe.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $watanabe[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/nomura.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $nomura[1]; ?>&nbsp;</td></tr>


</tbody></table>


<table  class="floating" style="table-layout:fixed;" style="border-collapse: collapse;border:3px double #00ffff;background-color:#ffff00;color:#000000;text-align:left;">
<tbody>
<tr>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FF00FF;color:#000000;text-align:center;">メンバー&nbsp;</th>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FF00FF;color:#000000;text-align:center;">コメント&nbsp;</th>
</tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/nobuta.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $nobuta[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/ishikawa.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $ishikawa[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/shen.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $shen[1]; ?>&nbsp;</td></tr>



</tbody></table>


</tbody></table>


<table  class="floating" style="table-layout:fixed;" style="border-collapse: collapse;border:3px double #00ffff;background-color:#ffff00;color:#000000;text-align:left;">
<tbody>
<tr>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FFFF00;color:#000000;text-align:center;">メンバー&nbsp;</th>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FFFF00;color:#000000;text-align:center;">コメント&nbsp;</th>
</tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/yano.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $yano[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/muramoto.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $muramoto[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/kitahara.png"width="50" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $kitahara[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/imairi.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $imairi[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/yamada.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $yamada[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/sakai.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $sakai[1]; ?>&nbsp;</td></tr>

</tbody></table>


<table  class="floating" style="table-layout:fixed;" style="border-collapse: collapse;border:3px double #00ffff;background-color:#ffff00;color:#000000;text-align:left;">
<tbody>
<tr>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FFFF00;color:#000000;text-align:center;">メンバー&nbsp;</th>
<th width=100 height=40 style="border:3px double #00ffff;background-color:#FFFF00;color:#000000;text-align:center;">コメント&nbsp;</th>
</tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/tamura.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $tamura[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/yoneshige.png"width="50" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $yoneshigeo[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/kobatake.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $kobetake[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/tsujii.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $tsujii[1]; ?>&nbsp;</td></tr>

<tr><td width=100 height=100 style="border:3px double #00ffff;text-align:center;"><img src="./img/kotera.png"width="60" height="90">&nbsp;</td>
<td width=100 height=100 style="border:3px double #00ffff;text-align:left;"><?php echo $kotera[1]; ?>&nbsp;</td></tr>



</tbody></table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<a color:#000000; href="http://49.212.200.39/login/kitahara/phpver.php">TOPへ</a><br><br>
<a color:#000000; href="http://49.212.200.39/login/kitahara/form.php">ステータス変更画面へ</a>

</body>

