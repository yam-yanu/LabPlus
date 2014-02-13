<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $id = $_POST['id'];
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  
  //informationに追加
  $sql_comment = "INSERT INTO information VALUES('0','".$id."', '".$_SESSION['id']."', '".$_SESSION['name']."', '".$comment."','', '6', '".date(ymdHi,time())."', '0')";
  $result_comment = executeQuery($sql_comment);
  $msg = $name."さんにコメントを書き残しました。";

  //表示するデータ（メンバーの名前、ポイント）を作成
  $sql = "SELECT LOGIN_NAME,IDNo,ID,LOCAL_P,COMMON_P,RELATION_P,GOLD,RANKING,TEAM_ID FROM login WHERE IDNo =".$_POST["id"];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  //チーム名、チームカラーを抜き出す
  $sql_team = "SELECT NAME,COLOR FROM team WHERE ID = ".$row["TEAM_ID"];
  $result_team = executeQuery($sql_team);
  $row_team = mysql_fetch_array($result_team);
  //ステータステーブルの作成
  $member_status = "<div class=\"title\">".$row["ID"]."さんの情報</div>
			<div class=\"myimg horizontal\" style=\"background-color: #".$row_team["COLOR"].";\"><img class=\"main\" src=\"../img/".$row["LOGIN_NAME"].".png\" alt=\"アバター\"></div>
			<table class=\"border\">
				<tr><td>ルームP：</td><td align=\"right\">".$row["LOCAL_P"]."P</td></tr>
				<tr><td>クエストP：</td><td align=\"right\">".$row["COMMON_P"]."P</td></tr>
				<tr><td>インフォP：</td><td align=\"right\">".$row["RELATION_P"]."P</td></tr>
				<tr><td>ゴールド：</td><td align=\"right\">".$row["GOLD"]."G</td></tr>
				<tr><td>ランキング：</td><td align=\"right\">".$row["RANKING"]."位</td></tr>
				<tr><td>チーム：</td><td align=\"right\">".$row_team["NAME"]."</td></tr>
			</table>";

?>



<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>コメントを書き残しました</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<div id="leftWrap">
			<?= $member_status ?>
		</div>
		<div id="centerWrap">
			<div class="title">コメントの書き込み</div>
			<p><?= $msg ?></p>
			<form action="member.php" method="post">
				<input type="hidden" name="id" value="<?= $id ?>">
				<input type="submit" name="submit" value="<?= $name ?>さんのページへ">
			</form>
			</centerWrap>
		</div><!-- /mainWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
