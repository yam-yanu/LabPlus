<?php
  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");
  
  //大久保先生のID番号
  $teacher_id = 20;

  //大久保先生かどうか判定
  if($_SESSION['id'] != $teacher_id){
	header("Location: mypage.php");
  }
  
  //データを受け取る
  $gold = $_POST["gold"];
  
  // クエリを送信する
  $sql = "SELECT IDNo,ID,RANKING,GOLD FROM login ORDER BY RANKING";
  $result = executeQuery($sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  if($rows){
    	while($row = mysql_fetch_array($result)) {
    		if($row["IDNo"] != $teacher_id){
      				$member_list .= "<tr><td>".$row["RANKING"]."</td>";
				$member_list .= "<td>".$row["ID"]."</td>";
				$member_list .= "<td>".$row["GOLD"]."</td>";
				$member_list .="<td><input type=\"text\" name=\"point".$row["IDNo"]."\"></td></tr>";
		}
	}
  }
  

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=320, initial-scale=0.7, user-scalable=yes, maximum-scale=2.0, minimum-scale=0.3, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>ポイントをもらう</title>
<?= $css ?>
<script type="text/javascript" src="../common/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function check(){
		var sum = 0;
		for(i=0;i<document.pointForm.length-1;i++){
			var point = document.pointForm.elements[i].value;
			if(point != ""){
				if(point.match(/[^0-9]/g) || parseInt(point,10) +"" != point){
					alert("正しい整数を入力してください");
					return false;
				}else{
					sum+= eval(document.pointForm.elements[i].value);
				}
			}
		}
		if(sum > <?= $gold ?>){
			alert("配るポイントが限界を超えています");
			return false;
		}else if(sum == 0){
			alert("誰かにポイントを配ってください");
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
			<div class="title">ゴールドの配布</div>
			今日配布できるゴールド：<?= $gold ?>
		    	<form action="complete_sp_point.php" method="post" name="pointForm">
				<table frame="box" rules="all"><tr bgcolor="#FFFACD"><td>前回の順位</td><td>名前</td><td>ゴールド</td><td>配るゴールド</td></tr>
					<?= $member_list ?>
				</table>
				<input type="submit" value="ゴールドを配る" onclick="return check()">
			</form>
		</div><!-- /centerWrap -->
		<div id="sideWrap">
			<?= $side_msg ?>
		</div><!-- /sideWrap -->
	</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>