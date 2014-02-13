<?php
 //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  // クエリを送信する
  $sql = "SELECT * FROM quest ORDER BY END_TIME";
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

			
  //表示するデータを作成
  if($rows){
	$pre_open .= "<div class=\"title\">開催前のクエスト</div><table><tr>";
	$open .= "<div class=\"title\">開催中のクエスト</div><table><tr>";
	$closed .= "<div class=\"title\">終了したクエスト</div><table><tr>";
	//一行に3つのクエストを表示させるために使用
	$pre_open_count = 0;
	$open_count = 0;
	$closed_count = 0;
	while($row = mysql_fetch_array($result)) {
		// メンバーの名前、チームカラーを抜き出す
		$sql_member = "SELECT login.IDNo,login.LOGIN_NAME,team.COLOR
				FROM login INNER JOIN team ON login.TEAM_ID=team.ID WHERE IDNo = ".$row["OWNER_ID"];
		$result_member = executeQuery($sql_member);
		$row_member = mysql_fetch_array($result_member);

		//スケジュールカレンダーの作成
		if($schedule_count  != 0){
			$schedule .= ",";
		}else{
			$schedule_count = 1;

		}
		$schedule .="{
				title: '".$row["QUEST_NAME"]."',
				start: '".substr($row["START_TIME"] , 0 , 4)."-".substr($row["START_TIME"] , 4 , 2)."-".substr($row["START_TIME"] , 6 , 2)."',
				end: '".substr($row["END_TIME"] , 0 , 4)."-".substr($row["END_TIME"] , 4 , 2)."-".substr($row["END_TIME"] , 6 , 2)."',
				className:'dialog-opener".$row["QUEST_ID"]."',
				backgroundColor:'".$row_member["COLOR"]."',
				textColor: 'black'
			}";

		//開催期間を作成	
		$span = floor(($row["START_TIME"]%10000)/100)."/";
		$span .= ($row["START_TIME"]%100);
		$span .= "～".floor(($row["END_TIME"]%10000)/100)."/";
		$span .= ($row["END_TIME"]%100);

		//クエスト一覧を作成
		if($row["START_TIME"] > date(Ymd,time())){
			$pre_open .= "<td><div class=\"quest_paper dialog-opener".$row["QUEST_ID"]."\">
					<table style=\"text-align:center;\"><tr><td><div class=\"team_subimg horizontal\" style=\"background-color: #".$row_member["COLOR"].";\"><img class=\"sub\" src=\"../img/".$row_member["LOGIN_NAME"].".png\" alt=\"アバター\"></td></tr>
					<tr><td>".$row["QUEST_NAME"]."</td></tr>
					<tr><td>".$span."</td></tr>
					</table>
				</div></td>";
			if($pre_open_count%3 == 2){
				$pre_open .= "</tr><tr>";
			}
			$pre_open_count += 1;
		}else if($row["END_TIME"] >= date(Ymd,time())){
			$open .= "<td><div class=\"quest_paper dialog-opener".$row["QUEST_ID"]."\">
					<table style=\"text-align:center;\"><tr><td><div class=\"team_subimg horizontal\" style=\"background-color: #".$row_member["COLOR"].";\"><img class=\"sub\" src=\"../img/".$row_member["LOGIN_NAME"].".png\" alt=\"アバター\"></td></tr>
					<tr><td>".$row["QUEST_NAME"]."</td></tr>
					<tr><td>".$span."</td></tr>
					</table>
				</div></td>";
			if($open_count%3 == 2){
				$open .= "</tr><tr>";
			}
			$open_count += 1;
		}else{
			$closed .= "<td><div class=\"quest_paper dialog-opener".$row["QUEST_ID"]."\">
					<table style=\"text-align:center;\"><tr><td><div class=\"team_subimg horizontal\" style=\"background-color: #".$row_member["COLOR"].";\"><img class=\"sub\" src=\"../img/".$row_member["LOGIN_NAME"].".png\" alt=\"アバター\"></td></tr>
					<tr><td>".$row["QUEST_NAME"]."</td></tr>
					<tr><td>".$span."</td></tr>
					</table>
				</div></td>";
			if($closed_count%3 == 2){
				$closed .= "</tr><tr>";
			}
			$closed_count += 1;
		}
		$java_script .= "<script>jQuery( function() {
									jQuery( '#jquery-ui-dialog".$row["QUEST_ID"]."' ) . dialog( {
										autoOpen: false,
										draggable: false,
										modal: true,
										show: 'clip',
										hide: 'clip'
									} );
									jQuery( '.dialog-opener".$row["QUEST_ID"]."' ) . click( function() {
										jQuery( '#jquery-ui-dialog".$row["QUEST_ID"]."' ) . dialog( 'open' );
										return false;
									} );
						} );</script>";

		if($row["OWNER_ID"] == $_SESSION["id"] && $row["END_TIME"] >= date(Ymd,time())){
			if($owner_check == 0){
				$myquest = "<div class=\"title\">主催しているクエスト</div><table style=\"text-align:left;\">";
			}
			$myquest .= "<tr><td><div class=\"dialog-opener".$row["QUEST_ID"]."\">".$row["QUEST_NAME"]."</div></td></tr>";
			$owner_check += 1;
		}
		//参加者の探索
		$attender = "";
		$attend_flag = 0;
		$count = 0;
  		//attender読み込み用
  		$sql_attend = "SELECT * FROM attender";
  		$result_attend = executeQuery($sql_attend);
		while($row_attend = mysql_fetch_array($result_attend)) {
			if($row["QUEST_ID"] == $row_attend["QUEST_NO"]){
				if($count == 0){
					$attender.= "<tr><td>参加者：</td><td>";
					$count = 1;
				}else{
					$attender .= "<tr><td></td><td>";
				}
				$attender .= $row_attend["ATTENDER_NAME"]."</td></tr>";
				if($row_attend["ATTENDER_ID"] == $_SESSION["id"]){
					$attend_flag = 1;
					if($row["END_TIME"] >= date(Ymd,time())){
						if($attend_check == 0){
							$ourquest = "<div class=\"title\">参加しているクエスト</div><table style=\"text-align:left;\">";
						}
							$ourquest .= "<tr><td><div class=\"dialog-opener".$row["QUEST_ID"]."\">".$row["QUEST_NAME"]."</div></td></tr>";
							$attend_check += 1;
					}
				}
			}
		}
		//ユーザーがどんな状況かによって表示するボタンを変更
		$msg = "";
		$msg2 = "";
		if($row["OWNER_NAME"] == $_SESSION['name'] ){
			if(date(Ymd,time()) <= $row["END_TIME"]){
				$msg .="<form action=\"delete.php\" method=\"post\">";
				$msg .="<input type=\"hidden\" name=\"id\" value=\"".$row["QUEST_ID"]."\">";
				$msg .="<input type=\"hidden\" name=\"cd\" value=\"".$row["QUEST_NAME"]."\">";
				$msg .="<input type=\"submit\" name=\"submit\" value=\"クエスト削除\"></form>";
				$msg2 .="<form action=\"change_detail.php\" method=\"post\">";
				$msg2 .="<td><input type=\"hidden\" name=\"id\" value=\"".$row["QUEST_ID"]."\"><td>";
				$msg2 .="<input type=\"submit\" name=\"submit\" value=\"詳細変更\"></form>";
			}else if($row["COMPLETE"] == 0 && $row["ATTEND_NUMBER"] > 0){
				$msg .="<form action=\"point.php\" method=\"post\">";
				$msg .="<input type=\"hidden\" name=\"id\" value=\"".$row["QUEST_ID"]."\">";
				$msg .="<input type=\"submit\" name=\"submit\" value=\"ポイントをもらう\"></form>";
			}
		}else if(date(Ymd,time()) <= $row["END_TIME"]){
			if($attend_flag == 0 && $row["ATTEND_NUMBER"] < $row["ATTEND_LIMIT"]){
				$msg .="<form action=\"attend.php\" method=\"post\">";
				$msg .="<input type=\"hidden\" name=\"id\" value=\"".$row["QUEST_ID"]."\">";
				$msg .="<input type=\"submit\" name=\"submit\" value=\"参加する\"></form>";
			}else if($attend_flag == 1){
				$msg .="<form action=\"withdraw_attend.php\" method=\"post\">";
				$msg .="<input type=\"hidden\" name=\"id\" value=\"".$row["QUEST_ID"]."\">";
				$msg .="<input type=\"submit\" name=\"submit\" value=\"参加をやめる\"></form>";
			}
		}
		$dialog_msg .= "<div id=\"jquery-ui-dialog".$row["QUEST_ID"]."\" title=\"".$row["QUEST_NAME"]."の詳細\">";
		$dialog_msg .= "<table><tr><td>クエスト名：</td><td>".$row["QUEST_NAME"]."</td></tr>";
		$dialog_msg .= "<tr><td>主催者：</td><td>".$row["OWNER_NAME"]."</td></tr>";
		$dialog_msg .= "<tr><td>期間：</td><td>".$span."</td></tr>";
		$dialog_msg .= $attender;
		$dialog_msg .= "<tr><td>人数制限：</td><td>".$row["ATTEND_LIMIT"]."人まで</td></tr></table>";
		$dialog_msg .= "【詳細】<br>".$row["DETAIL"]."<br>";
		$dialog_msg .= $msg;
		$dialog_msg .= $msg2."</div>";
	}

	//該当するクエストが存在しない場合タイトルを消す
	if($pre_open_count == 0){
		$pre_open = "";
	}else{
		$pre_open .= "</tr></table>";
	}
	if($open_count == 0){
		$open = "";
	}else{
		$open .= "</tr></table>";
	}
	if($closed_count == 0){
		$closed = "";
	}else{
		$closed .= "</tr></table>";
	}
  }else{
	$msg = "クエストがありません。";
  }

  //自分の各ステータスを取り出す
  $sql = "SELECT LOGIN_NAME,LOCAL_P,COMMON_P,RELATION_P,GOLD,GIFT_GOLD,RANKING,PLACE,TEAM_ID FROM login WHERE IDNo = ".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  $mystatus = "<div id=\"leftWrap\"><div class=\"title\">".$_SESSION['name']."さんの情報</div>
		<div class=\"myimg horizontal\" style=\"background-color: #".$row_team["COLOR"].";\"><img class=\"main\" src=\"../img/".$row["LOGIN_NAME"].".png\" alt=\"アバター\"></div>
		<table class=\"border\">
			<tr><td>ルームP：</td><td align=\"right\">".$row["LOCAL_P"]."P</td></tr>
			<tr><td>クエストP：</td><td align=\"right\">".$row["COMMON_P"]."P</td></tr>
			<tr><td>インフォP：</td><td align=\"right\">".$row["RELATION_P"]."P</td></tr>
			<tr><td>ゴールド：</td><td align=\"right\">".$row["GOLD"]."G</td></tr>
			<tr><td>ランキング：</td><td align=\"right\">".$row["RANKING"]."位</td></tr>
			<tr><td>現在地：</td><td align=\"right\">".$place."</td></tr>
			<tr><td>チーム：</td><td align=\"right\">".$row_team["NAME"]."</td></tr>
		</table>";
  
  // クエリを送信する(クエストを作れる回数の制限を設定）
  $sql = "SELECT QUEST_LIMIT FROM login WHERE IDNo =".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  if($row["QUEST_LIMIT"] > 0){
	$limit_msg = "今日はあと".$row["QUEST_LIMIT"]."回クエストを作成できます";
	$limit_msg .="<br><form action=\"make_quest.php\">
					<input type=\"submit\" name=\"submit\" value=\"新しくクエストを作る\">
				</form><br>";
  }else{
	$limit_msg = "今日はもうクエストの作成は出来ません";
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
<title>クエスト一覧</title>
<?= $css ?>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<link type="text/css" href="fullcalendar/fullcalendar.css" rel="stylesheet" />
<link type="text/css" href="fullcalendar/fullcalendar.print.css" rel="stylesheet" media='print' />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
<script type='text/javascript' src='fullcalendar/fullcalendar.min.js'></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
			dayNamesShort: ['日','月','火','水','木','金','土'],

			titleFormat: {
				month: 'yyyy年 M月',
				week: '[yyyy年 ]M月 d日{ —[yyyy年 ][ M月] d日}',
				day: 'yyyy年 M月 d日 dddd'
			},

			buttonText: {
				today: '今日'
			},
    events: [<?= $schedule ?>]
		});
	});

</script>
</head>
<?= $java_script ?>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
		</div><!-- /header -->
		<div id="inner">
			<?= $mystatus ?>
			<?= $myquest ?></table>
			<?= $ourquest ?></table></div>
			<div id="centerWrap">
				<?= $dialog_msg ?>
				<div class="title">クエストの作成</div>
				<?= $limit_msg ?>
				<div class="title">クエストスケジュール</div>
				<?= $schedule1 ?>
				<div id="calendar"></div>

				<?= $pre_open ?>
				<?= $open ?>
				<?= $closed ?>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>