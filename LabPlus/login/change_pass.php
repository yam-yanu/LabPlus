<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/action_log.php");
  require_once("../common/SampleDB050.php");

  // クエリを送信する
  $sql = "SELECT PASS FROM login WHERE IDNo =".$_SESSION["id"];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);

  //パスワードがあっているか確認
  $id = $_POST["id"];
  if(empty($id)){
    	$tempHtml .= "<div class=\"title\">パスワード入力結果</div>";
    	$tempHtml .= "<a href=\"confirm_pass.php\" target=\"_self\">もう一度入力</a>\n";
    	$tempHtml .= "パスワードが書かれていません。\n";
  }else if($id != $row["PASS"]){
    	$tempHtml .= "<div class=\"title\">パスワード入力結果</div>";
    	$tempHtml .= "<a href=\"confirm_pass.php\" target=\"_self\">もう一度入力</a>\n";
    	$tempHtml .= "パスワードが間違っています。\n";
  }else{
    	$tempHtml .= "<div class=\"title\">新しいパスワードの入力</div>";
	$tempHtml .= "<form action=\"comp_change_pass.php\" method=\"post\" name = \"newpass\">";
	$tempHtml .= "新しいパスワードを入力してください(12文字まで)<input type=\"text\" maxlength=\"12\" name=\"pass\">";
	$tempHtml .= "<input type=\"submit\" name=\"submit\" value=\"変更する\" onClick=\"return check()\"></form>";
  }

?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>パスワードの変更</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function check(){
		var password = document.newpass.pass.value;
		if(password == ""){
			alert("パスワードを入力してください");
			return false;
		}else{
			return true;
		}
	}
</script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
	</div><!-- /header -->
	<div id="inner">
		<?= $mystatus ?>
		<div id="centerWrap">
			<?= $tempHtml ?>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
