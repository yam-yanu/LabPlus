<?php
  //セッションの開始
  session_start();

  //cssの切り替え
  $ua = $_SERVER['HTTP_USER_AGENT'];
  $browser = ((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false));
  if ($browser == true){
	$css ="<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/sp_style.css\">";
  }else{
	$css ="<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/style.css\">";
  }
  
  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  
  //現在地をその他に変更
  $sql = "UPDATE login SET PLACE = '2'  WHERE IDNo = ".$_SESSION["id"];
  $result = executeQuery($sql);
  
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

  // セッション変数を全て解除する
  $_SESSION = array();
  

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>ログイン結果</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<div id="leftWrap"></div>
		<div id="centerWrap">
			<div class="title">ログアウト</div>
			ログアウトしました。<br>
			<form action="login.php">
				<input type="submit" name="submit" value=" ログイン画面へ ">
			</form>
		</div><!-- /centerWrap -->
		<div id="leftWrap">
		</div>
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>