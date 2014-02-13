<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  // クエリを送信する
  $sql = "SELECT ID,TEAM_ID FROM login WHERE IDNo =".$_POST["id"];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  $name = $row["ID"];
  $team_id = $row["TEAM_ID"];
  $sql_info = "SELECT * FROM myinfo WHERE OWNER_ID = ".$_POST["id"];
  $result_info = executeQuery($sql_info);

  //結果セットの行数を取得する
  $rows_info = mysql_num_rows($result_info);

  if($rows_info){
	while($row_info = mysql_fetch_array($result_info)){
		if($row_info["OPENED_CHECK"] == 0 && (string)$row_info["INFO_CONTENT"] == (string)$_POST["".$row_info["INFO_ID"].""]){
			//正解した人とされた人両方にポイントプラス
			//同じチーム同士ならポイント増加
			if($team_id == $_SESSION['team_id']){
				$sql_point = "UPDATE login SET RELATION_P = RELATION_P + 2 WHERE IDNo = ".$_POST["id"]." OR IDNo = ".$_SESSION['id'];
				$result_point = executeQuery($sql_point);
				$point_count += 2;
			}else{
				$sql_point = "UPDATE login SET RELATION_P = RELATION_P + 1 WHERE IDNo = ".$_POST["id"]." OR IDNo = ".$_SESSION['id'];
				$result_point = executeQuery($sql_point);
				$point_count += 1;
			}
			//情報を公開された情報にする
			$sql_point = "UPDATE myinfo SET OPENED_CHECK = '1' WHERE INFO_ID = ".$row_info["INFO_ID"];
			$result_point = executeQuery($sql_point);
			//アクションログを追加
			$sql_point = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '7', '".$_SESSION['name']."', '".date(ymdHi,time())."', '".$name."')";
			$result_point = executeQuery($sql_point);
			//informationを追加
			$sql_point = "INSERT INTO information VALUES('0','".$row_info["OWNER_ID"]."', '".$_SESSION['id']."', '".$_SESSION['name']."', '".$row_info["INFO_NAME"]."','', '3', '".date(ymdHi,time())."', '0')";
			$result_point = executeQuery($sql_point);
			$info_list .= "【".$row_info["INFO_NAME"]."】<br>";
		}else if($row_info["OPENED_CHECK"] == 0 && (string)$_POST["".$row_info["INFO_ID"].""] != ""){
			//informationを追加
			$sql_point = "INSERT INTO information VALUES('0','".$row_info["OWNER_ID"]."', '".$_SESSION['id']."', '".$_SESSION['name']."', '".$row_info["INFO_NAME"]."','".$_POST["".$row_info["INFO_ID"].""]."', '5', '".date(ymdHi,time())."', '0')";
			$result_point = executeQuery($sql_point);
			//quiz_formを消す
			$quiz_form = "";
		}
	}
  }

  if(is_null($info_list)){
	$msg = "正解した情報はありませんでした。";
  }else if($team_id == $_SESSION['team_id']){
	$msg .= $name."さんの情報<br>".$info_list."が正解でした！<br>";
	$msg .= $name."さんと".$_SESSION['name']."さんは同じチームなので両方のインフォPが＋".$point_count."ポイントされました！<br>";
  }else{
	$msg .= $name."さんの情報<br>".$info_list."が正解でした！<br>";
	$msg .= $name."さんと".$_SESSION['name']."さんのインフォPが＋".$point_count."ポイントされました！<br>";
  }

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
<title>ポイント受け取り</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
		</div><!-- /header -->
		<div id="inner">
			<div id="leftWrap"><?= $member_status ?></div>
			<div id="centerWrap">
				<div class="title">クイズ結果</div>
				<?= $msg ?><br>
				<form action="member.php" method="post">
					<input type="hidden" name="id" value="<?= $_POST["id"] ?>">
					<input type="submit" name="submit" value="<?= $name ?>さんのページへ">
				</form>
				<br><br><br><br><?= $quiz_form ?>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
