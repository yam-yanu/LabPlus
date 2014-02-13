<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $info_id = $_POST['id'];

  // クエリを送信する
  $sql = "SELECT * FROM myinfo WHERE INFO_ID = ".$info_id;
  $result = executeQuery($sql);


  //表示するデータを作成
  $row = mysql_fetch_array($result);
  $name = $row["INFO_NAME"];
  $content = $row["INFO_CONTENT"];


  //結果保持用メモリを開放する
  mysql_free_result($result);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<?= $css ?>
<script type="text/javascript">
	function check(){
		if(document.changeForm.info_name.value == "" || document.changeForm.info_content.value == ""){
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
			<div class="title">プロフィールの変更</div>
				<form name="changeForm" action="complete_change_info.php" method="post">
					<table><tr>
						<td>情報の名前(15文字まで)：</td>
						<td><input type="text" name="info_name" value="<?= $name ?>" maxlength="15"></td></tr>
					<tr>
						<td>情報の内容(15文字まで)：</td>
						<td><input type="text" name="info_content" value="<?= $content ?>" maxlength="15"></td></tr>
					</table>
					<input type="hidden" name="info_id" value="<?= $info_id ?>">
					<input type="submit" value="情報を変更する" onclick=\"return check()\">
				</form>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>