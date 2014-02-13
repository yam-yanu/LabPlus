<?php
  //セッションの開始
  session_start();

  //ファイルを読み込み
  require_once("../common/SampleDB050.php");
  require_once("../common/action_log.php");

  //データを取得する
  $quest_id = $_POST['id'];

  // クエリを送信する
  $sql = "SELECT * FROM quest WHERE QUEST_ID = ".$quest_id;
  $result = executeQuery($sql);


  //表示するデータを作成
  $row = mysql_fetch_array($result);
  $quest_name = $row["QUEST_NAME"];
  $start_time = $row["START_TIME"];
  $end_time = $row["END_TIME"];
  $detail = $row["DETAIL"];

  for($i = 1 ; $i <= 25 ; $i++){
			if($i == $row["ATTEND_LIMIT"]){
				$attend_limit .= "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
			}else{
				$attend_limit .= "<option value=\"".$i."\">".$i."</option>";
			}
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
<title>クエストの変更</title>
<?= $css ?>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
</head>
<script>
	jQuery( function() {
		jQuery( '.datepicker' ).datepicker({
			dateFormat: 'yymmdd',
			minDate: '-0d',
			beforeShow: function(input, inst){
				inst.dpDiv.css('margin-left','-120px');
			}
		});
	} );

	function check(){
		f = document.forms["questForm"];
		if(f.quest_name.value == "" || f.start_time.value == "" || f.end_time.value == ""){
			alert("必要な情報を入力してください");
			return false;
		}else if( f.start_time.value > f.end_time.value){
			alert("設定した時間が正しくありません");
			return false;
		}
	}
</script>
<body>
  <div id="wrap">
    	<div id="header">
		<?php include("../common/top_tab.html"); ?>
		</div><!-- /header -->
		<div id="inner">
			<?= $mystatus ?>
			<div id="centerWrap">
					<div class="title">クエストの変更</div>
					<form name="questForm" action="change_detail2.php" method="post">
						<table><tr><td>クエスト名</td><td>
						<input type="text" name="quest_name" size="30" maxlength="15" value="<?= $quest_name ?>"></td></tr>
						<tr><td>開始する時間：</td><td>
						<input type="text" name="start_time" value="<?= $start_time ?>" class="datepicker" readonly="readonly"></td></tr>
						<tr><td>終了する時間：</td><td>
						<input type="text" name="end_time" value="<?= $end_time ?>" class="datepicker" readonly="readonly"></td></tr>
						<tr><td>参加者の人数制限：</td><td>
						<select name="attend_limit">
						<?= $attend_limit ?>
						</select></td></tr>
						<tr><td>詳細：</td></tr></table>
						<textarea name="detail" rows="8" cols="40"><?= $detail ?></textarea><br>
						<input type="hidden" name="id" value="<?= $row["QUEST_ID"] ?>">
						<input type="hidden" name="promotor" value="<?= $row["OWNER_NAME"] ?>">
						<input type="submit" value="内容を変更する" onclick="return check()">
					</form>
			</div><!-- /centerWrap -->
			<div id="sideWrap">
				<?= $side_msg ?>
			</div><!-- /sideWrap -->
		</div><!-- /inner -->
  </div><!-- /wrap -->
</body>
</html>