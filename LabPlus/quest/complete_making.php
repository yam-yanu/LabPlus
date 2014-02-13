<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_name = $_POST['quest_name'];
  $owner_id = $_SESSION['id'];
  $owner_name = $_SESSION['name'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $attend_limit = $_POST['attend_limit'];
  $detail = $_POST['detail'];

  // 設定した内容が正しければクエリを送信する
  if(empty($quest_name)||empty($start_time)||empty($end_time)){
    $jump = "<a href=\"#\" onClick=\"history.back(); return false;\">作成し直す</a>\n";
    $msg = "必要な情報が入力されていません。\n";
	//クイズフォームを消す
	$quiz_form = "";
  }else if($end_time < date(Ymd,time()) || $end_time < $start_time){
    $jump = "<a href=\"#\" onClick=\"history.back(); return false;\">作成し直す</a>\n";
    $msg = "設定した期間が正しくありません。";
	//クイズフォームを消す
	$quiz_form = "";
  }else{
	$sql = "INSERT INTO quest VALUES('0', '".$quest_name."', '".$owner_id."', '".$owner_name."', '".$start_time."', '".$end_time."', '0', '".$detail."', '".$attend_limit."', '0')";
	$result = executeQuery($sql);
	$sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '3', '".$_SESSION['name']."', '".date(ymdHi,time())."', '".$quest_name."')";
	$result = executeQuery($sql);
	$sql = "UPDATE login SET QUEST_LIMIT = QUEST_LIMIT - 1 WHERE IDNo = ".$_SESSION['id'];
	$result = executeQuery($sql);
	$msg = "クエスト名：".$quest_name."を追加しました。";
  }
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>クエスト追加</title>
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
				<div class="title">クエストの作成</div>
			　　<?= $msg ?><br>
				<?= $jump ?><br>
				<?= $quiz_form ?>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>