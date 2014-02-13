<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //大久保先生のID番号
  $teacher_id = 20;

  //大久保先生かどうか判定
  if($_SESSION['id'] != $teacher_id){
	header("Location: mypage.php");
  }

  // クエリを送信する
  $sql = "SELECT IDNo,ID,GOLD,TEAM_ID FROM login"; 
  $result = executeQuery($sql);

  //表示するデータを作成
  while($row = mysql_fetch_array($result)) {
	$point = $_POST["point".$row[IDNo]];
	$sum += $point;
	if($point != 0 || $point != ""){
		$sql_point = "UPDATE login SET GOLD = GOLD + ".$point." WHERE IDNo = ".$row["IDNo"];
		$result_point = executeQuery($sql_point);
		//アクションログの追加
		$sql_point = "INSERT INTO action_log VALUES('".$row[TEAM_ID]."', '".$row["IDNo"]."', '10', '".$row["ID"]."', '".date(ymdHi,time())."', '".$point."')";
		$result_point = executeQuery($sql_point);
		//informationの追加
		$sql_point = "INSERT INTO information VALUES('0','".$row["IDNo"]."', '".$_SESSION['id']."', '".$_SESSION['name']."', '".$point."','', '4', '".date(ymdHi,time())."', '0')";
		$result_point = executeQuery($sql_point);
		$msg .= $row["ID"]."さんに".$point."ゴールド配られました。<br>";
	}
  }

  //ポイント支払い済にする
  $sql_point = "UPDATE login SET GIFT_GOLD = GIFT_GOLD - ".$sum." WHERE IDNo = ".$teacher_id;
  $result_point = executeQuery($sql_point);
  $sql = "SELECT GIFT_GOLD FROM login WHERE IDNo = ".$teacher_id; 
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  $msg .= "<br>今日はあと".$row["GIFT_GOLD"]."ゴールド配れます。";

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>ポイント受け取り完了</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<?= $mystatus ?>
		<div id="centerWrap">
			<?= $msg ?>
		</div><!-- /centerWrap -->

		<div id="sideWrap">
				<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
