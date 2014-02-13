<?php
  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_no = $_POST['id'];

  // クエリを送信する
  $sql = "SELECT * FROM attender WHERE QUEST_NO = ".$quest_no;
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  if($rows){
	$number = 0;
    	while($row = mysql_fetch_array($result)) {
      		$checkbox .= "<p><input type=\"checkbox\" name=\"".$row["ATTENDER_ID"]."\" value=\"".$row["ATTENDER_ID"]."\">".$row["ATTENDER_NAME"]."</p>";
	}
  }

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>ポイントをもらう</title>
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
				<div class="title">参加した人の確認</div>
					実際に参加した人にチェックを入れてください
				<form action="complete_point.php" method="post">
					<?= $checkbox ?>
					<input type="hidden" name="quest_no" value="<?= $quest_no ?>">
					<input type="submit" value="ポイントゲット！">
				</form>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>