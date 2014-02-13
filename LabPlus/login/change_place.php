<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $new_place = $_POST['place'];
  $now_time = date(ymdHi,time());
  $sql = "SELECT PLACE,LAB_TIME,ZEMI_TIME FROM login WHERE IDNo = ".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  $place = $row["PLACE"];
  $lab_time = $row["LAB_TIME"];
  $lab_time += 1200;
  if(($lab_time%10000) > 2359){
	 $lab_time += 7600;
  }
  $zemi_time = $row["ZEMI_TIME"];
  $zemi_time += 1200;
  if(($zemi_time%10000) > 2359){
	 $zemi_time += 7600;
  }


  //取得したデータを使って何をするか判断
  if($new_place == $place){//場所が変更されているか判断
	if($new_place == 0 && ($now_time - $lab_time) > 0){//場所が変更されていなくても一日以上経過していたら更新
		$sql = "UPDATE login SET PLACE = '".$new_place."'  WHERE IDNo = ".$_SESSION["id"];
		$result = executeQuery($sql);
		$sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '".$new_place."', '".$_SESSION['name']."', '".$now_time."', '')";
		$result = executeQuery($sql);
		$sql = "UPDATE login SET LOCAL_P = LOCAL_P + 1,LAB_TIME = ".$now_time." WHERE IDNo = ".$_SESSION['id'];
		$result = executeQuery($sql);
		$point_info = "ルームPを1ポイントゲットしました！";
		$msg = "次からはログアウトか場所の変更をしてから帰ってほしいです。<br>"; 
	}else if($new_place == 1 && ($now_time - $zemi_time) > 0){//場所が変更されていなくても一日以上経過していたら更新
		$sql = "UPDATE login SET PLACE = '".$new_place."'  WHERE IDNo = ".$_SESSION["id"];
		$result = executeQuery($sql);
		$sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '".$new_place."', '".$_SESSION['name']."', '".$now_time."', '')";
		$result = executeQuery($sql);
		$sql = "UPDATE login SET LOCAL_P = LOCAL_P + 1,ZEMI_TIME = ".$now_time." WHERE IDNo = ".$_SESSION['id'];
		$result = executeQuery($sql);
		$point_info = "ルームPを1ポイントゲットしました！";
		$msg = "次からはログアウトか場所の変更をしてから帰ってほしいです。<br>";
	}else{//場所が変更されていなくて一日も経過していない場合は何もしない
		$msg = "前の場所と変わっていません。";
		//クイズフォームを消す
		$quiz_form = "";
	}
  }else{
	$sql = "UPDATE login SET PLACE = '".$new_place."'  WHERE IDNo = ".$_SESSION["id"];
	$result = executeQuery($sql);
	$sql = "INSERT INTO action_log VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '".$new_place."', '".$_SESSION['name']."', '".$now_time."', '')";
	$result = executeQuery($sql);
	if($new_place == 0){
		$place_name = "研究室";
		if(($now_time - $lab_time) > 0){//前にポイントを得てから1日以上たっているかどうか判断
			$sql = "UPDATE login SET LOCAL_P = LOCAL_P + 1,LAB_TIME = ".$now_time." WHERE IDNo = ".$_SESSION['id'];
			$result = executeQuery($sql);
			$point_info = "ルームPを1ポイントゲットしました！";
		}else{
			//クイズフォームを消す
			$quiz_form = "";
		}
	}else if($new_place == 1){
		$place_name = "ゼミ室";
		if(($now_time - $zemi_time) > 0){//前にポイントを得てから1日以上たっているかどうか判断
			$sql = "UPDATE login SET LOCAL_P = LOCAL_P + 1,ZEMI_TIME = ".$now_time." WHERE IDNo = ".$_SESSION['id'];
			$result = executeQuery($sql);
			$point_info = "ルームPを1ポイントゲットしました！";
		}else{
			//クイズフォームを消す
			$quiz_form = "";
		}
	}else if($new_place == 2){		
		$place_name = "家など";
		//クイズフォームを消す
		$quiz_form = "";
	}
	$msg = "現在地を【".$place_name."】に変更しました。<br>";

	//csvデータの作成
	// CSVファイル名の設定
	$csv_file = "../kitahara/data2.csv";

	// CSVデータの初期化
	$csv_data = "";

	// クエリを送信する
	$sql = "SELECT LOGIN_NAME,PLACE,FREE,MESSAGE FROM login";
	$result = executeQuery($sql);

	//結果セットの行数を取得する
	$rows = mysql_num_rows($result);

	//表示するデータを作成
	if($rows){
		while($row = mysql_fetch_array($result)) {
			$csv_data .= " ".$row["LOGIN_NAME"].",".$row["PLACE"].",".$row["FREE"].",".$row["MESSAGE"]."\r\n";
		}
	}

	// ファイルを追記モードで開く
	$fp = fopen($csv_file, 'ab');
	// ファイルを排他ロックする
	flock($fp, LOCK_EX);
	// ファイルの中身を空にする
	ftruncate($fp, 0);
	// データをファイルに書き込む
	fwrite($fp, $csv_data);
	// ファイルを閉じる
	fclose($fp);
  }


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>現在地の更新</title>
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
			<div class="title">現在位置の変更結果</div>
			<?= $msg ?>
			<?= $point_info ?>
			<br><?= $quiz_form ?>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>