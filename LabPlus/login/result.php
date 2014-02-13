<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");

  //cssの切り替え
  $ua = $_SERVER['HTTP_USER_AGENT'];
  $browser = ((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false));
  if ($browser == true){
	$css ="<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/sp_style.css\">";
  }else{
	$css ="<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/style.css\">";
  }

  //データを取得する
  $name = $_POST['name'];
  $pass = $_POST['pass'];

  //表示するデータを作成
  $sql = "SELECT PASS FROM login WHERE LOGIN_NAME LIKE '$name'";//今回は全員の名前が違うためnameで判定
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
   if(empty($name) || empty($pass)){
    	$tempHtml = "<a href=\"login.php\" target=\"_self\">ログイン画面へ</a>\n";
    	$msg = "未入力の項目があります。\n";
  }else if($pass != $row["PASS"]){
    	$tempHtml = "<a href=\"login.php\" target=\"_self\">ログイン画面へ</a>\n";
    	$msg = "ID、パスワードが間違っています。\n";
  }else{
	$sql = "SELECT * FROM login WHERE LOGIN_NAME LIKE '$name'";
  	$result = executeQuery($sql);
  	$row = mysql_fetch_array($result);
    	$_SESSION['id'] = $row["IDNo"];
	$_SESSION['team_id'] = $row["TEAM_ID"];
    	$_SESSION['name'] = $row["ID"];
    	$_SESSION['login_name'] = $row["LOGIN_NAME"];
    	$_SESSION['pass'] = $row["PASS"];
	header("Location: mypage.php");
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
<title>ログイン結果</title>
<?= $css ?>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<div id="leftWrap"></div>
		<div id="centerWrap">
			<?= $tempHtml ?>
			<?= $msg ?>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>