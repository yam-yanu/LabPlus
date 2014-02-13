<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_no = $_POST['id'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $attend_limit = $_POST['attend_limit'];
  $detail = $_POST['detail'];
  $quest_name = $_POST['quest_name'];
  $promotor = $_POST['promotor'];

  // 設定した内容が正しければクエリを送信する
  if(empty($quest_name)||empty($start_time)||empty($end_time)){
    $jump = "<a href=\"#\" onClick=\"history.back(); return false;\">作成し直す</a>\n";
    $msg = "必要な情報が入力されていません。\n";
  }else if($end_time < date(Ymd,time()) || $end_time < $start_time){
    $jump = "<a href=\"#\" onClick=\"history.back(); return false;\">作成し直す</a>\n";
    $msg = "設定した期間が正しくありません。";
  }else{
	// クエリを送信する
	$sql = "UPDATE quest SET QUEST_NAME = '".$quest_name."',START_TIME = '".$start_time."' ,END_TIME = '".$end_time."' ,ATTEND_LIMIT = '".$attend_limit."',DETAIL = '".$detail."' WHERE QUEST_ID = ".$quest_no;
	$result = executeQuery($sql);
	//informationの追加
	$sql = "SELECT ATTENDER_ID FROM attender WHERE QUEST_NO = ".$quest_no;
	$result = executeQuery($sql);
	//結果セットの行数を取得する
	$rows = mysql_num_rows($result);
	//表示するデータを作成
	if($rows){
  		while($row = mysql_fetch_array($result)) {
    			$dear_id = $row["ATTENDER_ID"];
				$sql = "INSERT INTO information VALUES('0','".$dear_id."', '".$_SESSION['id']."', '".$promotor."', '$quest_name', '', '1', '".date(ymdHi,time())."', '0')";
				$result_info = executeQuery($sql);
			}
	}
	$msg="クエスト『".$quest_name."』の詳細を変更しました。";
  }
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>クエスト内容の変更完了</title>
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
				<div class="title">詳細の変更</div>
					<?= $msg ?>
					<?= $jump ?>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
