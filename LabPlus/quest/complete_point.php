<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_no = $_POST['quest_no'];

  // クエリを送信する
  $sql = "SELECT * FROM login 
		RIGHT OUTER JOIN attender ON login.IDNo = attender.ATTENDER_ID 
		WHERE QUEST_NO = ".$quest_no;
  $result = executeQuery($sql);
  $sql_point = "SELECT QUEST_NAME,COMPLETE FROM quest WHERE QUEST_ID = ".$quest_no;
  $result_point = executeQuery($sql_point);
  $row_point = mysql_fetch_array($result_point);
  $quest_name = $row_point["QUEST_NAME"];

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  if($row_point["COMPLETE"] == 0){
  	while($row = mysql_fetch_array($result)) {
		if($row["ATTENDER_ID"] == $_POST[$row["ATTENDER_ID"]]){
			$sql_point = "UPDATE login SET COMMON_P = COMMON_P + 1 WHERE IDNo = ".$row["IDNo"];
			$result_point = executeQuery($sql_point);
			$sql_point = "INSERT INTO action_log VALUES('".$row["TEAM_ID"]."', '".$row["IDNo"]."', '6', '".$row["ID"]."', '".date(ymdHi,time())."', '".$quest_name."')";
			$result_point = executeQuery($sql_point);
			$sql_point = "INSERT INTO information VALUES('0','".$row["IDNo"]."', '".$_SESSION['id']."', '".$_SESSION['name']."', '".$row_point["QUEST_NAME"]."', '', '0', '".date(ymdHi,time())."', '0')";
			$result_point = executeQuery($sql_point);
			$attender_list .= $row["ID"]."さん　";
		}
  	}
	$msg = "主催者と参加者　".$attender_list."がクエストPを1ポイント受け取りました。";

	//主催者にポイントを払う
	$sql_point = "UPDATE login SET COMMON_P = COMMON_P + 1 WHERE IDNo = ".$_SESSION['id'];
	$result_point = executeQuery($sql_point);

	//ポイント支払い済にする
	$sql_point = "UPDATE quest SET COMPLETE = '1' WHERE QUEST_ID = ".$quest_no;
	$result_point = executeQuery($sql_point);
	
	//アクションログに追加
	$sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '6', '".$_SESSION['name']."', '".date(ymdHi,time())."', '".$quest_name."')";
    $result = executeQuery($sql);

  }else{
	$msg = "すでにポイントを受け取っています。";
	//quiz_formを消す
	$quiz_form = "";
  }

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
				<div class="title">ポイントの受け取り</div>
				<?= $msg ?>
				<br><?= $quiz_form ?>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
