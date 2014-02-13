<?php
  //セッションの開始
  session_start();

  //ファイルを読み込む
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //セッションが存在しなければログインに飛ばす
  if(is_null($_SESSION['id'])){
	  header("Location: login.php");
  }
  
  //自分の各ステータスを取り出す
  $sql = "SELECT LOGIN_NAME,LOCAL_P,COMMON_P,RELATION_P,GOLD,GIFT_GOLD,RANKING,PLACE,TEAM_ID FROM login WHERE IDNo = ".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  //自分のチーム名,チームカラーを取り出す
  $sql_team = "SELECT NAME,COLOR FROM team WHERE ID = ".$row["TEAM_ID"];
  $result_team = executeQuery($sql_team);
  $row_team = mysql_fetch_array($result_team);
  //取り出したデータを変数に入れる
  $login_name = $row["LOGIN_NAME"];
  $local = $row["LOCAL_P"];
  $common = $row["COMMON_P"];
  $relation = $row["RELATION_P"];
  $gold = $row["GOLD"];
  $ranking = $row["RANKING"];
  $gift_gold = $row["GIFT_GOLD"];
  $team = $row_team["NAME"];
  $team_color = $row_team["COLOR"];
  if($row["PLACE"] == 0){
	$place = "研究室";
  }else if($row["PLACE"] == 1){
	$place = "ゼミ室";
  }else if($row["PLACE"] == 2){		
	$place = "その他";
  }
	
  //自分のランキングに近い人を表示
  $sql = "SELECT login.IDNo,login.ID,login.LOGIN_NAME,login.LOCAL_P,login.COMMON_P,login.RELATION_P,login.RANKING,team.COLOR
	FROM login INNER JOIN team ON login.TEAM_ID=team.ID
           	WHERE login.RANKING BETWEEN ".($ranking-1)." AND ".($ranking+1)." ORDER BY login.RANKING LIMIT 5";
  $result = executeQuery($sql);
  $rows = mysql_num_rows($result);
  if($rows){
	$rank_table .= "<div class=\"title\">ランキングが近い人</div>
			<form name=\"memberifno\" method=POST action=\"../team/member.php\">
				<input type=hidden name=id value=\"\">
			</form>";
	while($row = mysql_fetch_array($result)) {
    		if($row["IDNo"] != $_SESSION['id']){
    			$rank_table .= $hr;
    			$rank_table .= "<a href=\"#\" onclick=\"return member_jump(".$row["IDNo"].")\">
    						<table><tr><td rowspan=3><div class=\"subimg horizontal\" style=\"background-color: #".$row["COLOR"].";\"><img class=\"sub\" src=\"../img/".$row["LOGIN_NAME"].".png\"></div></td>
							<td>".$row["RANKING"]."位</td></tr>
							<tr><td><a href=\"#\" onclick=\"return member_jump(".$row["IDNo"].")\">".$row["ID"]."さん</a></td></tr>
							<tr><td>".($row["LOCAL_P"]+$row["COMMON_P"]+$row["RELATION_P"])."P</tr>
						</table>
					</a>";
			$hr = "<hr class=\"gradient\">";
		}
	}
  }
	
  //見せるべきお知らせがあれば表示
  $sql = "SELECT * FROM information WHERE READED = 0 AND DEAR_ID = ".$_SESSION['id']." ORDER BY INFO_ID DESC";
  $result = executeQuery($sql); 	
  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);
  if($rows){
	$start_info = "<div class=\"title\">インフォメーション</div>";
	$start_info .= "確認したものにチェックを入れてください<form action=\"change_info_readed.php\" method=\"post\" name=\"informationForm\">";
	$quest = "<div class=\"content_wrap\"><table>";
	$quiz = "<div class=\"content_wrap display_none\"><table>";
	$comment = "<div class=\"content_wrap display_none\"><table>";
	$quest_count = 0;
	$quiz_count = 0;
	$comment_count = 0;
	while($row = mysql_fetch_array($result)){
			if($row["EVENT_NUMBER"] == 0){
				$quest_count += 1;
				$quest .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$quest .= $row["NAME"]."さんのクエスト「".$row["CONTENT"]."」がクリアされました。</td></tr>";
				$quest_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true; ";
			}else if($row["EVENT_NUMBER"] == 1){
				$quest_count += 1;
				$quest .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$quest .= $row["NAME"]."さんのクエスト「".$row["CONTENT"]."」の詳細が変更されました。</td></tr>";
				$quest_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
			}else if($row["EVENT_NUMBER"] == 2){
				$quest_count += 1;
				$quest .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$quest .= $row["NAME"]."さんがクエスト「".$row["CONTENT"]."」に参加しました。</td></tr>";
				$quest_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
			}else if($row["EVENT_NUMBER"] == 3){
				$quiz_count += 1;
				$quiz .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$quiz .= $row["NAME"]."さんが情報「".$row["CONTENT"]."」を書き込みました。</td></tr>";
				$quiz_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
			}else if($row["EVENT_NUMBER"] == 4){
				$comment_count += 1;
				$comment .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$comment .= $row["NAME"]."さんから".$row["CONTENT"]."ゴールドもらいました。</td></tr>";
				$comment_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
			}else if($row["EVENT_NUMBER"] == 5){
				$quiz_count += 1;
				$quiz .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$quiz .= $row["NAME"]."さんが情報「".$row["CONTENT"]."」を「".$row["REMARKS"]."」と書き込んで間違えました。</td></tr>";
				$quiz_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
				$wrong_quiz_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
			}else if($row["EVENT_NUMBER"] == 6){
				$comment_count += 1;
				$comment .= "<tr><td><input type=\"checkbox\" name=\"check".$row["INFO_ID"]."\" value=\"".$row["INFO_ID"]."\"></td><td>";
				$comment .= $row["NAME"]."さんがあなたに【".$row["CONTENT"]."】とコメントしています。</td></tr>";
				$comment_check .= "document.informationForm.check".$row["INFO_ID"].".checked = true;";
			}
	}
    	$info ="<div id = \"tab\">
		<ul id = \"tabs\">
			<li class=\"select\"><a href=\"#quest\">クエスト(".$quest_count.")</a></li>
			<li><a href=\"#quiz\">クイズ(".$quiz_count.")</a></li>
			<li><a href=\"#comment\">コメント(".$comment_count.")</a></li>
		</ul>";
   	if($quest_count == 0){
		$quest = "<div class=\"content_wrap\">クエストのお知らせはありません</div>";
	}else{
		$quest .= "</table><input type=\"button\" value=\"クエストのお知らせにチェックを入れる\" onclick=\"return allcheck(1)\"></div>";
	}
    	if($quiz_count == 0){
      		$quiz = "<div class=\"content_wrap display_none\">クイズのお知らせはありません</div>";
   	}else{
      		$quiz .= "</table><input type=\"button\" value=\"間違えのみチェックを入れる\" onclick=\"return allcheck(2)\"><input type=\"button\" value=\"クイズのお知らせにチェックを入れる\" onclick=\"return allcheck(3)\"></div>";
   	}
    	if($comment_count == 0){
      		$comment = "<div class=\"content_wrap display_none\">コメントはありません</div>";
    	}else{
      		$comment .= "</table><input type=\"button\" value=\"コメントのお知らせにチェックを入れる\" onclick=\"return allcheck(4)\"></div>";
    	}
    	$info .= $quest.$quiz.$comment."</div>";
	$end_info .= "<br><input type=\"button\" value=\"全てにチェックを入れる\" onclick=\"return allcheck(0)\"><input type=\"submit\" value=\"もう読んだ\"></form>";
    	$info = $start_info.$info.$end_info;
  }
  
   
  // IPアドレスを取得して学校からのアクセスなら場所変更を可能にする
  $ipAddress = $_SERVER["REMOTE_ADDR"];
  $change_place ="<div class=\"title\">今どこにいる？</div>";
  if(preg_match("/^202.11/",$ipAddress)){
	  $change_place .="<form action=\"change_place.php\" method=\"post\">";
	  $change_place .="<select name=\"place\">";
	  $change_place .="<option value=\"0\">研究室</option>";
	  $change_place .="<option value=\"1\">ゼミ室</option>";
	  $change_place .="<option value=\"2\">その他</option>";
	  $change_place .="</select><input type=\"submit\" value=\"更新\"></form>";
  }else{
	  $change_place .= "学校以外からのアクセスなので<br>その他にのみ場所の変更ができます。";
	  $change_place .="<form action=\"change_place.php\" method=\"post\">";
	  $change_place .="<select name=\"place\">";
	  $change_place .="<option value=\"2\">その他</option>";
	  $change_place .="</select><input type=\"submit\" value=\"更新\"></form>";
  }

  //もしログインした人が大久保先生ならポイント配布ページを表示
  if($_SESSION["id"] == 20){
	$sp_page = "<div class=\"title\">ポイントの配布</div>
				今日配布できるゴールドは".$gift_gold."ゴールドです。
				<form action=\"sp_point.php\" method=\"post\">
					<input type=\"hidden\" name=\"gold\" value=\"".$gift_gold."\">
					<input type=\"submit\" name=\"submit\" value=\"ポイントを配る\">
				</form>
				<div class=\"title\">所属チームの変更</div>
				<form action=\"change_team.php\" method=\"post\">
					<select name=\"team\">
					<option value=\"0\">所属しない</option>
					<option value=\"1\">醒魑琥ワ虚無</option>
					<option value=\"2\">ITsky3</option>
					<option value=\"3\">NisX</option>
					</select>
					<input type=\"submit\" value=\"チームの変更\">
				</form>";
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
<title>マイページ</title>
<?= $css ?>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">

  //メンバーのアバターをクリックしたらそのメンバーの情報に飛ぶ
  function member_jump(member_id){
	var f = document.forms["memberifno"];
	f.id.value = member_id;
	f.submit();
	return false;
  }

  //インフォメーションをまとめてチェックする
  function allcheck(check) {
	if(check == 0){
		var ElementsCount = document.informationForm.elements.length;//チェックボックスの数
		for( i=0 ; i<ElementsCount ; i++ ) {
			document.informationForm.elements[i].checked = true;//全てonにする
		}
	}else if(check == 1){
		<?php echo $quest_check; ?>
	}else if(check == 2){
		<?php echo $wrong_quiz_check; ?>
	}else if(check == 3){
		<?php echo $quiz_check; ?>
	}else if(check == 4){
		<?php echo $comment_check; ?>
  	}
  }

  //インフォメーションのタブ切り替え用
  $(function() {
   	    $("#tabs li").click(function() {
   	        var num = $("#tabs li").index(this);
   	        $(".content_wrap").addClass('display_none');
 	          $(".content_wrap").eq(num).removeClass('display_none');
   	        $("#tabs li").removeClass('select');
   	        $(this).addClass('select')
  	    });
  });

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
				<div id="mystatus" >
					<div class="title"><?= $_SESSION['name'] ?>さんの情報</div>
					<table class="border">
						<tr><td  width="220" rowspan=7><div class="myimg horizontal" style="background-color: #<?= $team_color ?>;"><img class="main" src="../img/<?= $login_name ?>.png" alt="アバター"></div></td>
						<td>ルームP：</td><td align="right"><?= $local ?>P</td></tr>
						<tr><td>クエストP：</td><td align="right"><?= $common ?>P</td></tr>
						<tr><td>インフォP：</td><td align="right"><?= $relation ?>P</td></tr>
						<tr><td>ゴールド：</td><td align="right"><?= $gold ?>G</td></tr>
						<tr><td>ランキング：</td><td align="right"><?= $ranking ?>位</td></tr>
						<tr><td>現在地：</td><td align="right"><?= $place ?></td></tr>
						<tr><td>チーム：</td><td align="right"><?= $team ?></td></tr>
					</table>
				</div>
				<?= $change_place ?>
				<?= $sp_page ?><br>
        				<?= $info ?>
				<?= $rank_table ?><br>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->

		</div><!-- /inner -->
  	</div><!-- /wrap -->
</body>
</html>
