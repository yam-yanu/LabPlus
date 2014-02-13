<?php

  //データを取得するだけのプログラム

  //ファイルを読み込む
  require_once("SampleDB050.php");

 //全員分のステータス、コメント、教室番号取得？

  $sql1 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 1";//矢野
  $result1 = executeQuery($sql1);
  $yano = mysql_fetch_array($result1);

  $sql2 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 2";//村本
  $result2 = executeQuery($sql2);
  $muramoto = mysql_fetch_array($result2);

  $sql3 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 3";//北原
  $result3 = executeQuery($sql3);
  $kitahara = mysql_fetch_array($result3);

  $sql4 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 4";//野村
  $result4 = executeQuery($sql4);
  $nomura = mysql_fetch_array($result4);

  $sql5 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 5";//今入
  $result5 = executeQuery($sql5);
  $imairi = mysql_fetch_array($result5);

  $sql6 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 6";//藤井
  $result6 = executeQuery($sql6);
  $fujii = mysql_fetch_array($result6);

  $sql7 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 7";//高橋
  $result7 = executeQuery($sql7);
  $takahashi = mysql_fetch_array($result7);

  $sql8 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 8";//坂井
  $result8 = executeQuery($sql8);
  $sakai = mysql_fetch_array($result8);

  $sql9 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 9";//申
  $result9 = executeQuery($sql9);
  $shen = mysql_fetch_array($result9);

  $sql10 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 10";//山下
  $result10 = executeQuery($sql10);
  $yamashita = mysql_fetch_array($result10);

  $sql11 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 11";//山田
  $result11 = executeQuery($sql11);
  $yamada = mysql_fetch_array($result11);

  $sql12 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 12";//田村
  $result12 = executeQuery($sql12);
  $tamura = mysql_fetch_array($result12);

  $sql13 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 13";//石川
  $result13 = executeQuery($sql13);
  $ishikawa = mysql_fetch_array($result13);

  $sql14 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 14";//米重
  $result14 = executeQuery($sql14);
  $yoneshige = mysql_fetch_array($result14);

  $sql15 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 15";//小畠
  $result15 = executeQuery($sql15);
  $kobatake = mysql_fetch_array($result15);

  $sql16 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 16";//渡辺
  $result16 = executeQuery($sql16);
  $watanabe = mysql_fetch_array($result16);

  $sql17 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 17";//信田
  $result17 = executeQuery($sql17);
  $nobuta = mysql_fetch_array($result17);

  $sql18 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 18";//辻井
  $result18 = executeQuery($sql18);
  $tsujii = mysql_fetch_array($result18);

  $sql19 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 19";//小寺
  $result19 = executeQuery($sql19);
  $kotera = mysql_fetch_array($result19);

  $sql20 ="SELECT FREE,MESSAGE,PLACE FROM login WHERE IDNo = 20";//大久保
  $result20 = executeQuery($sql20);
  $ookubo = mysql_fetch_array($result20);
  
?>

