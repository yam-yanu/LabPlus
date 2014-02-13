<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");
  
  //大久保先生のID番号
  $teacher_id = 20;

  //大久保先生かどうか判定
  if($_SESSION['id'] != $teacher_id){
	header("Location: mypage.php");
  }

  //データを取得する
  $new_team = $_POST['team'];
  $sql = "SELECT TEAM_ID FROM login WHERE IDNo = ".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  $team = $row["TEAM_ID"];


  //取得したデータを使って何をするか判断
  if($new_team == $team){//チームが変更されているか判断
	$msg = "前の所属チームと変わっていません。";
  }else{
    //所属チームの変更
	$sql = "UPDATE login SET TEAM_ID = '".$new_team."'  WHERE IDNo = ".$_SESSION["id"];
	$result = executeQuery($sql);
	//チーム名の取得
    $sql = "SELECT NAME FROM team WHERE ID = ".$new_team;
    $result = executeQuery($sql);
    $row = mysql_fetch_array($result);
    $team_name = $row["NAME"];
    //セッションの書き換え
    $_SESSION['team_id'] = $new_team; 
	$msg = "所属チームを【".$team_name."】に変更しました。<br>";

  }


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>所属チームの更新</title>
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
			<div class="title">チームの変更</div>
			<?= $msg ?>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>