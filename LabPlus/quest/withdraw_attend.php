<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_no = $_POST['id'];

  // クエリを送信する
  $sql = "DELETE FROM attender WHERE QUEST_NO = ".$quest_no." AND ATTENDER_ID = ".$_SESSION['id'];
  $result = executeQuery($sql);
  $sql = "UPDATE quest SET ATTEND_NUMBER = ATTEND_NUMBER -1 WHERE QUEST_ID = ".$quest_no;
  $result = executeQuery($sql);
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>参加取り消し</title>
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
				<div class="title">クエストの参加取り消し</div>
				このクエストの参加を取り消しました。
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>