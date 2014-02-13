<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  // クエリを送信する
  $sql = "SELECT * FROM 
		quest LEFT OUTER JOIN attender ON quest.QUEST_ID = attender.QUEST_NO
		WHERE ATTENDER_NAME LIKE '".$_SESSION['name']."' OR OWNER_NAME LIKE '".$_SESSION['name']."'
		ORDER BY END_TIME";
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  if($rows){
	$i = 0;
    while($row = mysql_fetch_array($result)) {
      if($row["OWNER_NAME"] == $_SESSION["name"]){
		if($repeat_check != $row["QUEST_ID"]){
			if($row["END_TIME"] < date(Ymd,time()) && $row["COMPLETE"] == 0 && $row["ATTEND_NUMBER"] > 0){
      				$maked_quest1 .= "<tr><td>";
					$span = floor(($row["START_TIME"]%10000)/100)."/";
					$span .= ($row["START_TIME"]%100);
					$span .= "～".floor(($row["END_TIME"]%10000)/100)."/";
					$span .= ($row["END_TIME"]%100);
					$maked_quest1 .= $span;
      				$maked_quest1 .= "</td><td>".$row["QUEST_NAME"]."</td><td>".$row["OWNER_NAME"]."</td>";
      				$maked_quest1 .= "<td><button id=\"jquery-ui-dialog-opener".$i."\">詳細</button></td>";
      				$maked_quest1 .= "</tr>\n";
				$repeat_check = $row["QUEST_ID"];
			}else if($row["END_TIME"] >= date(Ymd,time())){
      				$maked_quest2 .= "<tr><td>";
					$span = floor(($row["START_TIME"]%10000)/100)."/";
					$span .= ($row["START_TIME"]%100);
					$span .= "～".floor(($row["END_TIME"]%10000)/100)."/";
					$span .= ($row["END_TIME"]%100);
					$maked_quest2 .= $span;
      				$maked_quest2 .= "</td><td>".$row["QUEST_NAME"]."</td><td>".$row["OWNER_NAME"]."</td>";
      				$maked_quest2 .= "<td><button id=\"jquery-ui-dialog-opener".$i."\">詳細</button></td>";
      				$maked_quest2 .= "</tr>\n";
				$repeat_check = $row["QUEST_ID"];
			}
		}
      }else{
		if($row["END_TIME"] < date(Ymd,time()) && $row["COMPLETE"] == 0 && $row["ATTEND_NUMBER"] > 0){
      			$attend_quest1 .= "<tr><td>";
				$span = floor(($row["START_TIME"]%10000)/100)."/";
				$span .= ($row["START_TIME"]%100);
				$span .= "～".floor(($row["END_TIME"]%10000)/100)."/";
				$span .= ($row["END_TIME"]%100);
				$attend_quest1 .= $span;
      			$attend_quest1 .= "</td><td>".$row["QUEST_NAME"]."</td><td>".$row["OWNER_NAME"]."</td>";
      			$attend_quest1 .= "<td><button id=\"jquery-ui-dialog-opener".$i."\">詳細</button></td>";
      			$attend_quest1 .= "</tr>\n";
		}else if($row["END_TIME"] >= date(Ymd,time())){
      			$attend_quest2 .= "<tr><td>";
				$span = floor(($row["START_TIME"]%10000)/100)."/";
				$span .= ($row["START_TIME"]%100);
				$span .= "～".floor(($row["END_TIME"]%10000)/100)."/";
				$span .= ($row["END_TIME"]%100);
				$attend_quest2 .= $span;
      			$attend_quest2 .= "</td><td>".$row["QUEST_NAME"]."</td><td>".$row["OWNER_NAME"]."</td>";
      			$attend_quest2 .= "<td><button id=\"jquery-ui-dialog-opener".$i."\">詳細</button></td>";
      			$attend_quest2 .= "</tr>\n";
		}
	  }
	  $java_script .= "<script>jQuery( function() {
								jQuery( '#jquery-ui-dialog".$i."' ) . dialog( {
									autoOpen: false,
									draggable: false,
									modal: true,
									show: 'clip',
									hide: 'clip'
								} );
								jQuery( '#jquery-ui-dialog-opener".$i."' ) . click( function() {
									jQuery( '#jquery-ui-dialog".$i."' ) . dialog( 'open' );
									return false;
								} );
					} );</script>";

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
		$dialog_msg .= "<div id=\"jquery-ui-dialog".$i."\" title=\"".$row["QUEST_NAME"]."の詳細\">";
		$dialog_msg .= "<table><tr><td>クエスト名：</td><td>".$row["QUEST_NAME"]."</td></tr>";
		$dialog_msg .= "<tr><td>主催者：</td><td>".$row["OWNER_NAME"]."</td></tr>";
		$dialog_msg .= "<tr><td>期間：</td><td>".$span."</td></tr>";
		$dialog_msg .= $attender;
		$dialog_msg .= "<tr><td>人数制限：</td><td>".$row["ATTEND_LIMIT"]."人まで</td></tr></table>";
		$dialog_msg .= "【詳細】<br>".$row["DETAIL"]."<br>";
		$dialog_msg .= $msg;
		$dialog_msg .= $msg2."</div>";
		$i += 1;
    }
  }else{
    $msg = "クエストがありません。";
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
<title>クエスト管理</title>
<?= $css ?>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
</head>
<?= $java_script ?>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
		</div><!-- /header -->
		<div id="inner">
			<?= $mystatus ?>
			<div id="centerWrap">
			    <?= $dialog_msg ?>
			    <?= $msg ?>
				<p>◆自分が主催したクエスト</p>
　　				<U>ポイントをまだもらっていないクエスト</U>
					<table width = "390" border = "1">
      						<tr  bgcolor=\"#9ACD32\"><td>期間</td><td>クエスト名</td><td>主催者</td><td>詳細</td></tr>
      						<?= $maked_quest1 ?>
    					</table><br>
　　				<U>開催中のクエスト</U>
					<table width = "390" border = "1">
      						<tr  bgcolor=\"#9ACD32\"><td>期間</td><td>クエスト名</td><td>主催者</td><td>詳細</td></tr>
      						<?= $maked_quest2 ?>
    					</table><br>
    				<p>◆自分が参加したクエスト</p>
　　				<U>ポイントをまだもらっていないクエスト</U>
					<table width = "390" border = "1">
      						<tr  bgcolor=\"#9ACD32\"><td>期間</td><td>クエスト名</td><td>主催者</td><td>詳細</td></tr>
     						<?= $attend_quest1 ?>
    					</table><br>
　　				<U>開催中のクエスト</U>
					<table width = "390" border = "1">
      						<tr  bgcolor=\"#9ACD32\"><td>期間</td><td>クエスト名</td><td>主催者</td><td>詳細</td></tr>
      						<?= $attend_quest2 ?>
    					</table><br>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>