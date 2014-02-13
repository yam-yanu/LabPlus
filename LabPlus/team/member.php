<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");


  //表示するデータ（メンバーの名前、ポイント）を作成
  $sql = "SELECT LOGIN_NAME,IDNo,ID,LOCAL_P,COMMON_P,RELATION_P,GOLD,RANKING,TEAM_ID FROM login WHERE IDNo =".$_POST["id"];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  //チーム名、チームカラーを抜き出す
  $sql_team = "SELECT NAME,COLOR FROM team WHERE ID = ".$row["TEAM_ID"];
  $result_team = executeQuery($sql_team);
  $row_team = mysql_fetch_array($result_team);
  //ステータステーブルの作成
  $member_status = "<div class=\"title\">".$row["ID"]."さんの情報</div>
			<div class=\"myimg horizontal\" style=\"background-color: #".$row_team["COLOR"].";\"><img class=\"main\" src=\"../img/".$row["LOGIN_NAME"].".png\" alt=\"アバター\"></div>
			<table class=\"border\">
				<tr><td>ルームP：</td><td align=\"right\">".$row["LOCAL_P"]."P</td></tr>
				<tr><td>クエストP：</td><td align=\"right\">".$row["COMMON_P"]."P</td></tr>
				<tr><td>インフォP：</td><td align=\"right\">".$row["RELATION_P"]."P</td></tr>
				<tr><td>ゴールド：</td><td align=\"right\">".$row["GOLD"]."G</td></tr>
				<tr><td>ランキング：</td><td align=\"right\">".$row["RANKING"]."位</td></tr>
				<tr><td>チーム：</td><td align=\"right\">".$row_team["NAME"]."</td></tr>
			</table>";

  //プロフィール一覧を作成 
  $sql_info = "SELECT * FROM myinfo WHERE OWNER_ID =".$_POST["id"];
  $result_info = executeQuery($sql_info);
  $rows_info = mysql_num_rows($result_info);
  //公開されているかいないかで分ける
  if($row["IDNo"] == $_SESSION['id']){
	header("Location: ../login/mypage.php");
  }else if($rows_info){
	$opened .= "<div class=\"title\">公開されているプロフィール</div><table>";
	$pre_open .= "<div class=\"title\">公開されていないプロフィール</div><form action=\"writed_info.php\" method=\"post\"><table>";
	while($row_info = mysql_fetch_array($result_info)) {
		if($row_info["OPENED_CHECK"] == 1){
			$opened .= "<tr><td>".$row_info["INFO_NAME"]."</td><td>".$row_info["INFO_CONTENT"]."</td></tr>";
			$opened_count += 1;
		}else{
			$pre_open .= "<tr><td>".$row_info["INFO_NAME"]."</td><td><input type=\"text\" name=\"".$row_info["INFO_ID"]."\"></td></tr>";
			$pre_open_count += 1;
		}
	}
	
	if($opened_count == 0){
		$opened = "";
	}else{
		$opened .= "</table>";
	}
	if($pre_open_count == 0){
		$pre_open = "";
	}else{
		$pre_open .= "
			</table>
				<input type=\"hidden\" name=\"id\" value=\"".$_POST['id']."\">
				<input type=\"submit\" name=\"submit\" value=\"情報を書き込む\">
			</form>";
	}	
  }else{
	$msg = "<div class=\"title\">プロフィール一覧</div>".$row["ID"]."さんの情報はまだありません";
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
<title><?= $row["ID"] ?>さんのページ</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function check(){
		if(document.commentForm.comment.value == ""){
				alert("何か入力してください");
				return false;
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
		<div id="leftWrap">
			<?= $member_status ?>
		</div>
		<div id="centerWrap">
				<div id="mystatus" >
					<div class="title"><?= $row["ID"] ?>さんの情報</div>
					<table class="border">
						<tr><td  width="220" rowspan=7><div class="myimg horizontal" style="background-color: #<?= $row_team["COLOR"] ?>;"><img class="main" src="../img/<?= $row["LOGIN_NAME"] ?>.png" alt="アバター"></div></td>
						<tr><td>ルームP：</td><td align="right"><?= $row["LOCAL_P"] ?>P</td></tr>
						<tr><td>クエストP：</td><td align="right"><?= $row["COMMON_P"] ?>P</td></tr>
						<tr><td>インフォP：</td><td align="right"><?= $row["RELATION_P"] ?>P</td></tr>
						<tr><td>ゴールド：</td><td align="right"><?= $row["GOLD"] ?>G</td></tr>
						<tr><td>ランキング：</td><td align="right"><?= $row["RANKING"] ?>位</td></tr>
						<tr><td>チーム：</td><td align="right"><?= $row_team["NAME"] ?></td></tr>
					</table>
				</div>
			<div class="title">コメントの作成</div>
			<form action="writed_comment.php" method="post" name="commentForm">
				<textarea name="comment" rows="4" cols="40"></textarea>
				<input type="hidden" name="id" value="<?= $_POST['id'] ?>">
				<input type="hidden" name="name" value="<?= $row["ID"] ?>"><br>
				<input type="submit" value="<?= $row["ID"] ?>さんにコメントを残す" onclick="return check()"><input type="reset" value="リセット">
			</form>
			<?= $msg ?>
				<?= $opened ?>
				<?= $pre_open ?>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
