<?php
  //セッションの開始
  session_start();
  
  //クイズ開始の宣言
  $_SESSION['quiz'] = 1;

  //ファイルを読み込み
  require_once("SampleDB050.php");
  require_once("action_log.php");


  //直接ページに来たらマイページに飛ぶ
  if($_POST['quiz_check'] == 0){
	header("Location: ../login/mypage.php");
  }


  // クエリを送信する(info用)
  //リロード対策でセッションが存在していればそのセッションに保存されているクエリを使用
  if(empty($_SESSION['quiz_sql'])){
	$sql_info = "SELECT * FROM myinfo WHERE OPENED_CHECK = 1 AND OWNER_ID !=".$_SESSION['id']." ORDER BY RAND() LIMIT 1"; 
  }else{
	$sql_info = "SELECT * FROM myinfo WHERE INFO_ID = ".$_SESSION['quiz_sql'];
  }
  $result_info = executeQuery($sql_info);
  $row_info = mysql_fetch_array($result_info);
  $owner_id = $row_info["OWNER_ID"];
  $info_id = $row_info["INFO_ID"];
  $info_name = $row_info["INFO_NAME"];
  //リロード対策としてセッションにinfo_idを保存
  $_SESSION['quiz_sql'] = $info_id;

  //表示するデータ（メンバーの名前用）を作成
  $sql = "SELECT LOGIN_NAME,ID,TEAM_ID FROM login WHERE IDNo =".$owner_id;
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  $login_name = $row["LOGIN_NAME"];
  $name = $row["ID"];
  //チーム名、チームカラーを抜き出す
  $sql_team = "SELECT NAME,COLOR FROM team WHERE ID = ".$row["TEAM_ID"];
  $result_team = executeQuery($sql_team);  

  //結果保持用メモリを開放する
  mysql_free_result($result);

?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?= $name ?>さんからの問題</title>
<?= $css ?>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<?= $mystatus ?>
		<div id="centerWrap">
			<div class="title">突然クイズ</div>
			既に公開されている情報からの出題です。<br>
			正解するとインフォPを3Pゲットできます。
			<table><tr>
				<td><div class="quizimg horizontal" style="background-color: #<?= $row_team["COLOR"] ?>;"><img class="quiz" src="../img/<?= $login_name ?>.png" alt="アバター"></div></td>
				<td><?= $name ?>さんの情報<br>からの出題です</td>
			</tr></table>
			<form action="writed_answer.php" method="post">
				<div class="balloon">
					<div class="question">Question</div>
					<div class="question_content"><?= $info_name ?>は?</div>
				</div>
				<div class="balloon">
					<div class="question">Answer</div>
					<div class="question_content"><input type="text" name="content"></div>
				</div>
				<input type="hidden" name="info_id" value="<?= $info_id ?>">
				<input type="hidden" name="quiz_check" value="1">
				<input type="submit" name="submit" value="答えを送信">
			</form>				
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
