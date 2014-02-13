<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $praise = $_POST['praise'];
  $degree = $_POST['degree'];

  //今までの情報と入力された情報を比較する
  $sql = "SELECT PRAISENAME FROM degree ";
  $result = executeQuery($sql);
  $rows = mysql_num_rows($result);
  if($rows){
	while($row = mysql_fetch_array($result)) {
		if($row["PRAISENAME"] == $praise){
			$repeat_check += 1;
		}
	}
  }

  // 設定した内容が正しければクエリを送信する
  if($repeat_check >= 1){
    $msg = "設定したことがある称号です。\n";
  }else if($info_name == "id"){
    $msg = "情報の名前が正しくありません。\n";
  }else{
  	//praiseにほめる部分、称号を追加
	$sql = "INSERT INTO degree VALUES ('0','".$praise."', '".$degree."', '6','".date("Y-m-d H:i:s", time())."')";
	$result = executeQuery($sql);
	// $sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."' ,'4', '".$_SESSION['name']."', '".date(ymdHi,time())."','".$info_name."')";
	// $result = executeQuery($sql);
	$msg = "称号：".$degree."を追加しました。";
  }
?>



<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>情報追加完了</title>
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
				<div class ="title">ほめる部分の追加</div>
				<p><?= $msg ?></p>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>