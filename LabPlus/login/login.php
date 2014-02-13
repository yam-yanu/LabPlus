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

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>ログイン</title>
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
			<div class="title">ログイン</div><br><br>
			<form action="result.php" method="post" name="loginForm">
				ログインネーム<br>
				<input type="text" name="name" value="<?= $_SESSION['login_name'] ?>"><br>
				パスワード<br>
				<input type="password" name="pass" value="<?= $_SESSION['pass'] ?>"><br><br>
				<input type="submit" name="submit" value="ログイン">   <input type="reset" value="リセット">
			</form>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
		</div>
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
