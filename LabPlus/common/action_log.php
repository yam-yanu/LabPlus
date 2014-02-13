<?php
  //セッションの開始
  session_start();
  //ファイルを読み込み
  require_once("SampleDB050.php");

  //セッション情報が存在しなければログイン画面に遷移
  if(empty($_SESSION['id'])){
	header("Location: ../login/login.php");
  }

  //自分のステータスの表示
  //自分の各ステータスを取り出す
  $sql = "SELECT LOGIN_NAME,LOCAL_P,COMMON_P,RELATION_P,GOLD,GIFT_GOLD,RANKING,PLACE,TEAM_ID FROM login WHERE IDNo = ".$_SESSION['id'];
  $result = executeQuery($sql);
  $row = mysql_fetch_array($result);
  //自分のチーム名,チームカラーを取り出す
  $sql_team = "SELECT NAME,COLOR FROM team WHERE ID = ".$row["TEAM_ID"];
  $result_team = executeQuery($sql_team);
  $row_team = mysql_fetch_array($result_team);
  if($row["PLACE"] == 0){
	$place = "研究室";
  }else if($row["PLACE"] == 1){
	$place = "ゼミ室";
  }else if($row["PLACE"] == 2){		
	$place = "その他";
  }

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
		</table></div>";
  
  //cssの切り替え
  $ua = $_SERVER['HTTP_USER_AGENT'];
  $browser = ((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false));
  if ($browser == true){
	$css ="<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/sp_style.css\">";
  }else{
	$css ="<link rel=\"stylesheet\" type=\"text/css\" href=\"../common/style.css\">";
  }
  
  //ランダムで突然クイズボタンを出現させる
  if($_SESSION['quiz'] == 0){
	$random = rand(1,5);
	if($random == 1){
		$quiz_form = "<form action=\"../common/quiz.php\" method=\"post\">
						<input type=\"hidden\" name=\"quiz_check\" value=\"1\">
					<input type=\"submit\" name=\"submit\" value=\"ラッキー！突然クイズへ\"></form>";	
	}
  }
  
  //クイズ中に違うページヘ飛ぶと注意する
  if(empty($_POST['quiz_check']) && $_SESSION["quiz"] == 1){
	$quiz_warning="alert(\"クイズ中に違うページ遷移することはできません。クイズに答えることができなくなりました。\");";
	$_SESSION['quiz'] = 0;
	unset($_SESSION['quiz_sql']);
  }

  // クエリを送信する
  if($_SESSION["team_id"] != 0){
	$team_id = " (TEAM_ID =".$_SESSION["team_id"]." OR TEAM_ID = 0) AND";
  }
  $sql = "SELECT * FROM action_log WHERE ".$team_id." EVENT_NUMBER BETWEEN '3' AND '11' ORDER BY TIME DESC LIMIT 15";
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  $side_msg ="<div class=\"title\">メンバーの情報</div>";
  if($rows){
	while($row = mysql_fetch_array($result)) {
		$judge = $row["EVENT_NUMBER"];//イベントの種類を判断
		if($judge >= 3 && $judge <=11){
			//日付が変わっていると日付を書く
			if(floor($row["TIME"]/10000) != $day){
      				$side_msg .= floor(($row["TIME"]%100000000)/1000000)."月";
      				$side_msg .= floor(($row["TIME"]%1000000)/10000)."日";
      				$day = floor($row["TIME"]/10000);
			}
			//時間を表示(時間が一桁の時は0を足して2桁にする)
		if($judge != 9){
    			$side_msg .= "<form name=memberform".$count." method=POST action=\"../team/member.php\">
								<input type=hidden name=id value=".$row["MEMBER_ID"].">
					</form>";
		}
    		$side_msg .= "<a href=\"javascript:document.memberform".$count.".submit()\"><div class=\"side-msg\"><table><tr><td>【";
    		if(floor(($row["TIME"]%10000)/100) < 10){
      			$side_msg .= "0";
    		}
    		$side_msg .= floor(($row["TIME"]%10000)/100)."：";
    		if(($row["TIME"]%100) < 10){
      			$side_msg .= "0";
    		}    
    		$side_msg .= $row["TIME"]%100;
    		$side_msg .= "】";
    		$side_msg .= "</td></tr>";
    		$side_msg .= "<tr><td><a href=\"javascript:document.memberform".$count.".submit()\">".$row["MEMBER_NAME"]."さん</a>が";

			//行動の種類を判断して表示
			if($judge == 0){
   				$side_msg .= "研究室に入りました。";
			}else if($judge == 1){
      			$side_msg .= "ゼミ室に入りました。";
			}else if($judge == 2){
      			$side_msg .= "外に出ました。";
			}else if($judge == 3){
      			$side_msg .= "クエスト<br>『".$row["REMARKS"]."』<br>を作成しました。";
    		}else if($judge == 4){
      			$side_msg .= "情報<br>『".$row["REMARKS"]."』<br>を作成しました。";
      		}else if($judge == 5){
      			$side_msg .= "クエスト<br>『".$row["REMARKS"]."』<br>に参加しました。";
    		}else if($judge == 6){
      			$side_msg .= "クエスト<br>『".$row["REMARKS"]."』<br>をクリアしました。";
			}else if($judge == 7){
      			$side_msg .= $row["REMARKS"]."さんの<br>情報を書き込みました。";
    		}else if($judge == 8){
      			$side_msg .= "個人ランク<br>".$row["REMARKS"]."位になりました。";
 			}else if($judge == 9){
      			$side_msg .= "チームランク<br>".$row["REMARKS"]."位になりました。";
    		}else if($judge == 10){
      			$side_msg .= "大久保先生に<br>".$row["REMARKS"]."ゴールドをもらいました。";
    		}else if($judge == 11){
      			$side_msg .= "突然クイズ<br>に正解しました。";
			}
    		$side_msg .= "</td></tr></table></div></a>";
    		$count += 1;
    	}
	}
  }else{
    $side_msg .= "最近のログはありません。";
  }
  

  //結果保持用メモリを開放する
  mysql_free_result($result);

?>
