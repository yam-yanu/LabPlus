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

  //ゲットした称号を表示
  $sql_degree = "SELECT degree.MASTERNAME from get_degree INNER JOIN degree ON get_degree.DEGREEID = degree.ID WHERE get_degree.OBTAINID = ".$_POST["id"];
  $result_degree = executeQuery($sql_degree);
  $rows_degree = mysql_num_rows($result_degree);
  if($rows_degree){
  	$degree_msg = "<table>";
  	while($row_degree = mysql_fetch_array($result_degree)){
  		$degree_msg .= "<tr><td>".$row_degree["MASTERNAME"]."</td></tr>";
  	}
  	$degree_msg .= "</table>";
  }else{
  	$degree_msg = "まだ".$row["ID"]."さんは称号を得ていません";
  }
  //ほめる部分一覧を表示
  $sql_praise = "SELECT ID,PRAISENAME,NUMBER FROM degree";
  $result_praise = executeQuery($sql_praise);
  $rows_praise = mysql_num_rows($result_praise);
  if($rows_praise){
  	$praise_msg = "<table>"; 
  	while($row_praise = mysql_fetch_array($result_praise)){
  		//あと何人でマスターするか確認し、０以下であれば表示しない
  		$sql_count = "SELECT  COUNT(*) FROM praise WHERE TOID = ".$row["IDNo"]." AND DEGREEID = ".$row_praise["ID"];
		$result_count = executeQuery($sql_count);
		list($count) = mysql_fetch_row($result_count);
		$remain = $row_praise["NUMBER"] - $count;
		if($remain > 0){
			$praise_msg .= "<tr>
								<td>".$row_praise["PRAISENAME"]."</td>
								<td>(あと".$remain."人)</td>
								<td>
									<form name=memberform".$form_count." method=POST action=\"praise.php\">
										<input type=hidden name=id value=".$row_praise["ID"].">
										<input type=hidden name=toid value=".$row["IDNo"].">
										<input type=hidden name=toidname value=".$row["ID"].">
										<input type=hidden name=remain value".$remain.">
										<input type=submit value=\"すごい！\">
									</form></td>
							</tr>";
		}
		$form_count += 1;
  	}
  	$praise_msg .= "</table>";
  }else{
  	$praise_msg = "ほめる部分が設定されていません。<br>『ほめる』のぺーじでほめる部分を設定してください。";
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
	//function check(){
	//	if(document.commentForm.comment.value == ""){
	//			alert("何か入力してください");
	//			return false;
	//	}
	//}

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
			<div class="title">得ている称号</div>
				<?= $degree_msg ?>
			<div class="title"><?= $row["ID"] ?>さんをほめる</div>
				<?= $praise_msg ?>
		</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>
