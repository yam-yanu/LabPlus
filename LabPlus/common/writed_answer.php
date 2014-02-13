<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("SampleDB050.php");
  require_once("action_log.php");
  
  //quizが0ならマイページへ
  if($_SESSION['quiz'] == 0){
	header("Location: ../login/mypage.php");
  }else{
	//データを受け取る
	$info_id = $_POST["info_id"];
	$answer = $_POST["content"];

	//クエリ送信（myinfo用）
	$sql = "SELECT INFO_CONTENT FROM myinfo WHERE INFO_ID = ".$info_id;
	$result = executeQuery($sql);
	$row = mysql_fetch_array($result);

	//正解すると正解した人のインフォポイントを＋３P、アクションログの追加
	if((string)$row["INFO_CONTENT"] == (string)$answer){
			//インフォP＋３P
			$sql_point = "UPDATE login SET RELATION_P = RELATION_P + 3 WHERE IDNo = ".$_SESSION['id'];
			$result_point = executeQuery($sql_point);
			//アクションログ追加
			$sql_point = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '11', '".$_SESSION['name']."', '".date(ymdHi,time())."', '')";
			$result_point = executeQuery($sql_point);
			//正解した時のメッセージ
			$msg = "おめでとうございます！<br>クイズに正解したので<br>インフォPを３Pゲットしました。";
	 }else{
			//不正解した時のメッセージ
			$msg = "不正解です…<br>正解は".$row["INFO_CONTENT"]."でした。";
	 }
  
	 //quiz=0にしてもう一度入れないようにする
	$_SESSION['quiz'] = 0;
	// リロード対策用セッションを解除する
	$_SESSION['quiz_sql'] = array();
  }
  

?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>クイズの結果</title>
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
			<div class="title">突然クイズの結果</div>
			<?= $msg ?><br>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
