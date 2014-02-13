<?php
  //セッションの開始
  session_start();
  require_once("../common/action_log.php");

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");

  // クエリを送信する
  $sql = "SELECT * FROM myinfo WHERE OWNER_ID =".$_SESSION['id'];
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  if($rows){
	$opened_info = "<table>";
	$closed_info = "<table>";
	while($row = mysql_fetch_array($result)) {
		if($row["OPENED_CHECK"] == 1){
			$opened_info .= "<tr><td>".$row["INFO_NAME"]."：</td><td>".$row["INFO_CONTENT"]."</td></tr>";
		}else{
			$closed_info .= "<tr><td>".$row["INFO_NAME"]."：</td><td>".$row["INFO_CONTENT"]."</td><td>";
			$closed_info .= "<form action=\"change_info.php\" method=\"post\">";
			$closed_info .= "<input type=\"hidden\" name=\"id\" value=\"".$row["INFO_ID"]."\">";
			$closed_info .= "<input type=\"submit\" name=\"submit\" value=\"編集\"></form></td></tr>";
		}
	}
	$opened_info .= "</table>";
	$closed_info .= "</table>";
  }
  
  // クエリを送信する(インフォを作れる回数の制限を設定）
  $sql = "SELECT INFO_LIMIT FROM login WHERE IDNo =".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  if($row["INFO_LIMIT"] > 0){
	$limit_msg = "今日はあと".$row["INFO_LIMIT"]."回情報を作成できます";
	$limit_msg .="
		<form name=\"make_info_form\" action=\"complete_make.php\" method=\"post\">
			<table>
				<tr><td>情報の名前(15文字まで)</td><td><input type=\"text\" name=\"name\" maxlength=\"15\"></td></tr>
				<tr><td>情報の内容(15文字まで)</td><td><input type=\"text\" name=\"content\" maxlength=\"15\"></td></tr>
			</table>
		<input type=\"submit\" name=\"submit\" value=\"作成\" onclick=\"return check()\"></form>";
  }else{
	$limit_msg = "今日はもう情報の作成は出来ません";
  }

  //結果保持用メモリを開放する
  mysql_free_result($result);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>自分の情報</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function check(){
		if(document.make_info_form.name.value == "" || document.make_info_form.content.value == ""){
				alert("情報が正しく入力されていません");
				return false;
		}
	}
</script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<?= $mystatus ?>
		<div id="centerWrap">
			<div class="title">プロフィールの作成</div>
				<?= $limit_msg ?>

			<div class="title">公開されているプロフィール</div>
				<?= $opened_info ?>
			<div class="title">公開されていないプロフィール</div>
				<?= $closed_info ?>

		</div><!-- /mainWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>