
<?php

 session_start();

  $now_time = date(ymdHi,time());

  // IPアドレスを取得して変数にセットする
  $ipAddress = $_SERVER["REMOTE_ADDR"];

//confirm.phpからデータを受け取る。
$status = $_POST[status];
$comment = $_POST[comment];

//ファイルを読み込む
require_once("SampleDB050.php");

if (!empty($comment) && isset($status)) {//どちらも更新
  
/* データを更新するクエリーを設定 */
$query = "UPDATE login SET MESSAGE='".$comment."',FREE=".$status." WHERE IDNo = ".$_SESSION["id"];
$sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '50', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
$result = executeQuery($sql);


}else if (!empty($comment)) {//コメントのみ
   
/* データを更新するクエリーを設定 */
$query = "UPDATE login SET MESSAGE='".$comment."' WHERE IDNo = ".$_SESSION["id"];
$sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '51', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
$result = executeQuery($sql);

}else if(!empty($status) || $status==0){//ステータスのみ更新

$query = "UPDATE login SET FREE=".$status." WHERE IDNo = ".$_SESSION["id"];
$sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '52', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
$result = executeQuery($sql);

}else {
	echo "テキストフィールドに何も入力されていません。<br>もう一度入力してください。<br><br><br>";
	header("location:http://49.212.200.39/login/kitahara/form.html");
	exit();
}



/* データを更新するクエリーを設定 */
//$query = "UPDATE tablename SET comment='$comment',status='$status' WHERE id = ;

$result = executeQuery($query);
?>

<!-- MYSQLのデータを更新するプログラム。-->
<html>
<head>
<mete http-equiv="content-type" content="text/html;charset=Shift_JIS">
<title> 変更完了</title>
<meta http-equiv="refresh" content="2;URL=http://49.212.200.39/login/kitahara/phpver.php">
</head>
<body>
<br><br>
変更しました。<br>
2秒後にtopページに移動します<br>

</body></html>