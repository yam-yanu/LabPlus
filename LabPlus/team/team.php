<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  // クエリを送信する
  $sql = "SELECT login.IDNo,login.ID,login.LOGIN_NAME,login.LOCAL_P,login.COMMON_P,login.RELATION_P,login.RANKING,login.GOLD,login.TEAM_ID,team.COLOR
	FROM login INNER JOIN team ON login.TEAM_ID=team.ID";
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //メンバー一覧の作成
  if($rows){
	$member_count = 0;
	$others_count = 0;
	while($row = mysql_fetch_array($result)){
		//未公開のプロフィールの個数を調べる
		$sql_info = "SELECT COUNT(*) FROM myinfo WHERE OWNER_ID = ".$row["IDNo"]." AND OPENED_CHECK = '0'";
		$result_info = executeQuery($sql_info);
		list($count) = mysql_fetch_row($result_info);

		//自分のチームメンバーとそれ以外を分ける
		if($row["TEAM_ID"] == $_SESSION['team_id']){
			$member_list .= "<td><a href=\"javascript:document.teamform".$row["IDNo"].".submit()\" onMouseOver=\"status_visible(".$row["IDNo"].");\" onMouseOut=\"status_invisible(".$row["IDNo"].");\">
						<table style=\"text-align:center;\">
							<tr><td><div class=\"team_subimg horizontal\" style=\"background-color: #".$row["COLOR"].";\"><img class=\"sub\" src=\"../img/".$row["LOGIN_NAME"].".png\" alt=\"アバター\"></div></td></tr>
							<tr><td>".$row["ID"]."さん</td></tr>
							<tr><td>".$count."個</td></tr>
							<tr><td>
								<form name=\"teamform".$row["IDNo"]."\" action=\"member.php\" method=\"post\">
									<input type=\"hidden\" name=\"id\" value=\"".$row["IDNo"]."\">
								</form>
							</td></tr>
						</table></a>
					</td>";
			if($member_count%3 == 2){
				$member_list .= "</tr><tr>";
			}
			$member_count += 1; 
		}else{
			$others_list .= "<td><a href=\"javascript:document.teamform".$row["IDNo"].".submit()\" onMouseOver=\"status_visible(".$row["IDNo"].");\" onMouseOut=\"status_invisible(".$row["IDNo"].");\">
						<table style=\"text-align:center;\">
							<tr><td><div class=\"team_subimg horizontal\" style=\"background-color: #".$row["COLOR"].";\"><img class=\"sub\" src=\"../img/".$row["LOGIN_NAME"].".png\" alt=\"アバター\"></div></td></tr>
							<tr><td>".$row["ID"]."さん</td></tr>
							<tr><td>".$count."個</td></tr>
							<tr><td>
								<form name=\"teamform".$row["IDNo"]."\" action=\"member.php\" method=\"post\">
									<input type=\"hidden\" name=\"id\" value=\"".$row["IDNo"]."\">
								</form>
							</td></tr>
						</table></a>
					</td>";
			if($others_count%3 == 2){
				$others_list .= "</tr><tr>";
			}
			$others_count += 1; 
		}

		//leftWrapにステータスを表示させる
		$member_status .= "<div class=\"member\" id =\"member_status".$row["IDNo"]."\" style=\"display:none;position:absolute;top:200px;\">
					<div class=\"title\">".$row["ID"]."さんのステータス</div>
					<div class=\"myimg horizontal\" style=\"background-color: #".$row["COLOR"].";\"><img class=\"main\" src=\"../img/".$row["LOGIN_NAME"].".png\" alt=\"アバター\"></div>
					<table class=\"border\">
						<tr><td>ルームP：</td><td align=\"right\">".$row["LOCAL_P"]."P</td></tr>
						<tr><td>クエストP：</td><td align=\"right\">".$row["COMMON_P"]."P</td></tr>
						<tr><td>インフォP：</td><td align=\"right\">".$row["RELATION_P"]."P</td></tr>
						<tr><td>ゴールド：</td><td align=\"right\">".$row["GOLD"]."G</td></tr>
						<tr><td>ランキング：</td><td align=\"right\">".$row["RANKING"]."位</td></tr>
						<tr><td>未公開情報の数：</td><td align=\"right\">".$count."個</td></tr>
					</table>
				</div>";
	}
	if($member_count != 0){
		$my_member = "<div class=\"title\">自分のチームメンバー</div>";
	}
	if($member_count != 0){
		$other_member = "<div class=\"title\">それ以外のメンバー</div>";
	}
  }else{
	$msg = "メンバーがいません。";
  }

  //チームのステータスを表示
  $team_id = $_SESSION["team_id"];
  $sql_team = "SELECT * FROM team WHERE ID =".$team_id;
  $result_team = executeQuery($sql_team);
  $row_team = mysql_fetch_array($result_team);
  $name = $row["NAME"];
  $lv = $row["LV"];
  $sql_p .= "SELECT SUM(LOCAL_P) AS LOCAL, 
		SUM(COMMON_P) AS COMMON, 
		SUM(RELATION_P) AS RELATION
		FROM login WHERE TEAM_ID =".$team_id;
  $result_p = executeQuery($sql_p);
  $row_p = mysql_fetch_array($result_p);

  $teamstatus = "<div id=\"team_status\"><div class=\"title\">チームのステータス</div>
		<table class=\"border\">
			<tr><td>チーム名：</td><td align=\"right\">".$row_team["NAME"]."</td></tr>
			<tr><td>ルームP：</td><td align=\"right\">".$row_p["LOCAL"]."P</td></tr>
			<tr><td>クエストP：</td><td align=\"right\">".$row_p["COMMON"]."P</td></tr>
			<tr><td>インフォP：</td><td align=\"right\">".$row_p["RELATION"]."P</td></tr>
		</table></div>";

  //結果保持用メモリを開放する
  mysql_free_result($result);

?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>仲間リスト</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function status_visible(id_number){
		visible_name = "member_status"+id_number;
		document.getElementById(visible_name).style.display = "block";
		document.getElementById("team_status").style.display = "none";
		//$("#"+visible_name).show( 'blind', '', 1000 );
	}
	function status_invisible(id_number){
		visible_name = "member_status"+id_number;
		document.getElementById(visible_name).style.display = "none";
		document.getElementById("team_status").style.display = "block";
	}

	//スクロールするたびに実行
	$(window).scroll(function () {
		var winTop = $(this).scrollTop();
		//スクロール位置が200pxより下だったらpositionをfixedにする
		if (winTop >= 200) {
			$('.member').css('position' , 'fixed');
			$('.member').css('top' , '0px');
		} else if (winTop <200) {
			$('.member').css('position' , 'absolute');
			$('.member').css('top' , '200px');
		}
	});
	
</script>
</head>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
		</div><!-- /header -->
		<div id="inner">
			<div id="leftWrap">
				<?= $teamstatus ?>
				<?= $member_status ?>
			</div>
			<div id="centerWrap">
				<?= $msg ?>
				<?= $my_member ?>
					<table><tr><?= $member_list ?></tr></table>
				<?= $other_member ?>
					<table><tr><?= $others_list ?></tr></table>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>