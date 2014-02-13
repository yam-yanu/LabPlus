<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_id = $_POST['id'];
  $attender_id = $_SESSION['id'];
  $attender_name = $_SESSION['name'];

  // クエリを送信する
  $sql = "SELECT * FROM quest WHERE QUEST_ID = ".$quest_id;
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  //アクションログに追加
  $sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '5', '".$_SESSION['name']."', '".date(ymdHi,time())."', '".$row["QUEST_NAME"]."')";
  $result = executeQuery($sql);
  //attenderに追加
  $sql = "INSERT INTO attender VALUES(".$quest_id.", '".$attender_id."', '".$attender_name."')";
  $result = executeQuery($sql);
  //クエストの参加人数を一人増やす
  $sql = "UPDATE quest SET ATTEND_NUMBER = ATTEND_NUMBER + 1 WHERE QUEST_ID = ".$quest_id;
  $result = executeQuery($sql);
  //informationに追加
  $sql = "INSERT INTO information VALUES('0','".$row["OWNER_ID"]."', '".$_SESSION['id']."', '".$_SESSION['name']."', '".$row["QUEST_NAME"]."', '', '2', '".date(ymdHi,time())."', '0')";
  $result = executeQuery($sql);
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>クエストの参加</title>
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
				<div class="title">クエストの参加</div>
				クエスト名：<?= $row["QUEST_NAME"] ?>に参加しました。<br>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>