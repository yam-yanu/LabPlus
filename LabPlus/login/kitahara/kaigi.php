<?php
  //セッションの開始
  session_start();

  include('view.php');

  //ファイルを読み込む
  //require_once("SampleDB050.php");

  //現在時刻の取得
  $now_time = date(ymdHi,time());

  // IPアドレスを取得して変数にセットする
  $ipAddress = $_SERVER["REMOTE_ADDR"];



  $agent = $_SERVER['HTTP_USER_AGENT'];

  if(ereg("^DoCoMo", $agent)){//docomo
  
  $tanmatu=3;

  }else if(ereg("^J-PHONE|^Vodafone|^SoftBank", $agent)){//SB

  $tanmatu=3;

  }else if(ereg("^UP.Browser|^KDDI", $agent)){//au

    $tanmatu=3;

  }else if(ereg("iPhone", $agent)){//iPhone

   $tanmatu=1;

  }else if(ereg("Android", $agent)){//android

   $tanmatu=2;

  }else{

    $tanmatu=0;

  }



if($tanmatu==1){//iphoneなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '96', '".$_SESSION['name']."', '".$now_time."','','1','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==0){//pcなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '96', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==2){//androidなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '96', '".$_SESSION['name']."', '".$now_time."','','2','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==3){//ガラケーなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '96', '".$_SESSION['name']."', '".$now_time."','','3','".$ipAddress."')";
 $result = executeQuery($sql);

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script
       src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"
       type="text/javascript"
        ></script>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel=stylesheet href="style1.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>lab view</title>




</head>
<body bgcolor="#000000">

<script type="text/javascript">
<!--

$(function(){
	$("#img_id_kobatake").hover(  
	function(){ 
	$("p#str_kobatake").text('<?php echo $kobatake[1]; ?>');
	$("p#str_kobatake").attr("class", "kobatake_p text-area") },function(){ $("p#str_kobatake").attr("class", "hide") } ); 

	$("#ookubo_b").hover(  
	function(){ 
	$("p#str_ookubo").text('<?php echo $ookubo[1]; ?>');
	$("p#str_ookubo").attr("class", "ookubo_p text-area") },function(){ $("p#str_ookubo").attr("class", "hide") } ); 

	$("#fujii_b").hover(  
	function(){ 
	$("p#str_fujii").text('<?php echo $fujii[1]; ?>');
	$("p#str_fujii").attr("class", "fujii_p text-area") },function(){ $("p#str_fujii").attr("class", "hide") } ); 

	$("#nobuta_b").hover(  
	function(){ 
	$("p#str_nobuta").text('<?php echo $nobuta[1]; ?>');
	$("p#str_nobuta").attr("class", "nobuta_p text-area") },function(){ $("p#str_nobuta").attr("class", "hide") } );

	$("#img_id_tsujii").hover(  
	function(){ 
	$("p#str_tsujii").text('<?php echo $tsujii[1]; ?>');
	$("p#str_tsujii").attr("class", "tsujii_p text-area") },function(){ $("p#str_tsujii").attr("class", "hide") } ); 

	$("#img_id_yano").hover(  
	function(){ 
	$("p#str_yano").text('<?php echo $yano[1]; ?>');
	$("p#str_yano").attr("class", "yano_p text-area") },function(){ $("p#str_yano").attr("class", "hide") } );

	$("#img_id_muramoto").hover(  
	function(){ 
	$("p#str_muramoto").text('<?php echo $muramoto[1]; ?>');
	$("p#str_muramoto").attr("class", "muramoto_p text-area") },function(){ $("p#str_muramoto").attr("class", "hide") } ); 

	$("#kotera_b").hover(  
	function(){ 
	$("p#str_kotera").text('<?php echo $kotera[1]; ?>');
	$("p#str_kotera").attr("class", "kotera_p text-area") },function(){ $("p#str_kotera").attr("class", "hide") } );

	$("#imairi_b").hover(  
	function(){ 
	$("p#str_imairi").text('<?php echo $imairi[1]; ?>');
	$("p#str_imairi").attr("class", "imairi_p text-area") },function(){ $("p#str_imairi").attr("class", "hide") } );

	$("#yamashita_b").hover(  
	function(){ 
	$("p#str_yamashita").text('<?php echo $yamashita[1]; ?>');
	$("p#str_yamashita").attr("class", "yamashita_p text-area") },function(){ $("p#str_yamashita").attr("class", "hide") } ); 

	$("#ishikawa_b").hover(  
	function(){ 
	$("p#str_ishikawa").text('<?php echo $ishikawa[1]; ?>');
	$("p#str_ishikawa").attr("class", "ishikawa_p text-area") },function(){ $("p#str_ishikawa").attr("class", "hide") } );

	$("#kitahara_b").hover(  
	function(){ 
	$("p#str_kitahara").text('<?php echo $kitahara[1]; ?>');
	$("p#str_kitahara").attr("class", "kitahara_p text-area") },function(){ $("p#str_kitahara").attr("class", "hide") } );

	$("#yoneshige_b").hover(  
	function(){ 
	$("p#str_yoneshige").text('<?php echo $yoneshige[1]; ?>');
	$("p#str_yoneshige").attr("class", "yoneshige_p text-area") },function(){ $("p#str_yoneshige").attr("class", "hide") } ); 

	$("#yamada_b").hover(  
	function(){ 
	$("p#str_yamada").text('<?php echo $yamada[1]; ?>');
	$("p#str_yamada").attr("class", "yamada_p text-area") },function(){ $("p#str_yamada").attr("class", "hide") } );

	$("#tamura_b").hover(  
	function(){ 
	$("p#str_tamura").text('<?php echo $tamura[1]; ?>');
	$("p#str_tamura").attr("class", "tamura_p text-area") },function(){ $("p#str_tamura").attr("class", "hide") } );

	$("#watanabe_b").hover(  
	function(){ 
	$("p#str_watanabe").text('<?php echo $watanabe[1]; ?>');
	$("p#str_watanabe").attr("class", "watanabe_p text-area") },function(){ $("p#str_watanabe").attr("class", "hide") } );

	$("#sakai_b").hover(  
	function(){ 
	$("p#str_sakai").text('<?php echo $sakai[1]; ?>');
	$("p#str_sakai").attr("class", "sakai_p text-area") },function(){ $("p#str_sakai").attr("class", "hide") } ); 

	$("#nomura_b").hover(  
	function(){ 
	$("p#str_nomura").text('<?php echo $nomura[1]; ?>');
	$("p#str_nomura").attr("class", "nomura_p text-area") },function(){ $("p#str_nomura").attr("class", "hide") } );

	$("#shen_b").hover(  
	function(){ 
	$("p#str_shen").text('<?php echo $shen[1]; ?>');
	$("p#str_shen").attr("class", "shen_p text-area") },function(){ $("p#str_shen").attr("class", "hide") } );
})



$(function(){
	
				$("#back_kari,#back_i,#back_s,#back_l,#back_n,#deskb_p,#deskf_p").attr("class","hide");//仮TOPの背景を消して

			$("#back_204").attr("class","back_g");//会議室の背景表示


			$("#kobatake_s,#kobatake_s2,#ookubo_s,#ookubo_s2,#fujii_s,#fujii_s2,#nobuta_s,#nobuta_s2,#tsujii_s,#tsujii_s2,#yano_s,#yano_s2").attr("class","hide");

			$("#muramoto_s,#muramoto_s2,#kotera_s,#kotera_s2,#imairi_s,#imairi_s2,#yamashita_s,#yamashita_s2,#ishikawa_s,#ishikawa_s2,#kitahara_s,#kitahara_s2").attr("class","hide");

			$("#yoneshige_s,#yoneshige_s2,#yamada_s,#yamada_s2,#tamura_s,#tamura_s2,#watanabe_s,#watanabe_s2,#sakai_s,#sakai_s2,#nomura_s,#nomura_s2,#shen_s,#shen_s2").attr("class","hide");
			//ステータス消去


			document.bgColor = "#000000";

		if( <?php echo $kobatake[2]; ?> ==1){
		
			if( <?php echo $kobatake[0]; ?> ==0){$("#kobatake_s").attr("class","kobatake_s");}
			else if( <?php echo $kobatake[0]; ?> ==2){$("#kobatake_s2").attr("class","kobatake_s");}

			$("#img_id_kobatake").attr("class","kobatake_p");
	
		}else{$("#img_id_kobatake").attr("class","hide");}//小畠


		if( <?php echo $ookubo[2]; ?> ==1){

			if( <?php echo $ookubo[0]; ?> ==0){$("#ookubo_s").attr("class","ookubo_s");}
			else if( <?php echo $ookubo[0]; ?> ==2){$("#ookubo_s2").attr("class","ookubo_s");}			
			
			$("#img_id_ookubo").attr("class","ookubo_p");
			$("#ookubo_b").attr("class","ookubo_b");
		
		}else{$("#img_id_ookubo").attr("class","hide");$("#ookubo_b").attr("class","hide");}


		if( <?php echo $fujii[2]; ?> ==1){

			if( <?php echo $fujii[0]; ?> ==0){$("#fujii_s").attr("class","fujii_s");}
			else if( <?php echo $fujii[0]; ?> ==2){$("#fujii_s2").attr("class","fujii_s");}

			$("#img_id_fujii").attr("class","fujii_p");
			$("#fujii_b").attr("class","fujii_b");
		
		}else{$("#img_id_fujii").attr("class","hide");$("#fujii_b").attr("class","hide");}


		if( <?php echo $nobuta[2]; ?> ==1){

			if( <?php echo $nobuta[0]; ?> ==0){$("#nobuta_s").attr("class","nobuta_s");}
			else if( <?php echo $nobuta[0]; ?> ==2){$("#nobuta_s2").attr("class","nobuta_s");}
			
			$("#img_id_nobuta").attr("class","nobuta_p");
			$("#nobuta_b").attr("class","nobuta_b");
		
		}else{$("#img_id_nobuta").attr("class","hide");$("#nobuta_b").attr("class","hide");}


		if( <?php echo $tsujii[2]; ?> ==1){

			if( <?php echo $tsujii[0]; ?> ==0){$("#tsujii_s").attr("class","tsujii_s");}
			else if( <?php echo $tsujii[0]; ?> ==2){$("#tsujii_s2").attr("class","tsujii_s");}
			
			$("#img_id_tsujii").attr("class","tsujii_p");
		
		}else{$("#img_id_tsujii").attr("class","hide");}//辻井


		if( <?php echo $yano[2]; ?> ==1){

			if( <?php echo $yano[0]; ?> ==0){$("#yano_s").attr("class","yano_s");}
			else if( <?php echo $yano[0]; ?> ==2){$("#yano_s2").attr("class","yano_s");}
			
			$("#img_id_yano").attr("class","yano_p");
		
		}else{$("#img_id_yano").attr("class","hide");}//矢野

		
		if( <?php echo $muramoto[2]; ?> ==1){

			if( <?php echo $muramoto[0]; ?> ==0){$("#muramoto_s").attr("class","muramoto_s");}
			else if( <?php echo $muramoto[0]; ?> ==2){$("#muramoto_s2").attr("class","muramoto_s");}
			
			$("#img_id_muramoto").attr("class","muramoto_p");
		
		}else{$("#img_id_muramoto").attr("class","hide");}//村本


		if( <?php echo $kotera[2]; ?> ==1){

			if( <?php echo $kotera[0]; ?> ==0){$("#kotera_s").attr("class","kotera_s");}
			else if( <?php echo $kotera[0]; ?> ==2){$("#kotera_s2").attr("class","kotera_s");}
			
			$("#img_id_kotera").attr("class","kotera_p");
			$("#kotera_b").attr("class","kotera_b");
		
		}else{$("#img_id_kotera").attr("class","hide");$("#kotera_b").attr("class","hide");}



		if( <?php echo $imairi[2]; ?> ==1){

			if( <?php echo $imairi[0]; ?> ==0){$("#imairi_s").attr("class","imairi_s");}
			else if( <?php echo $imairi[0]; ?> ==2){$("#imairi_s2").attr("class","imairi_s");}

		$("#img_id_imairi").attr("class","imairi_p");
		$("#imairi_b").attr("class","imairi_b");
		
		}else{$("#img_id_imairi").attr("class","hide");$("#imairi_b").attr("class","hide");}



		if( <?php echo $yamashita[2]; ?> ==1){

			if( <?php echo $yamashita[0]; ?> ==0){$("#yamashita_s").attr("class","yamashita_s");}
			else if( <?php echo $yamashita[0]; ?> ==2){$("#yamashita_s2").attr("class","yamashita_s");}
			
			$("#img_id_yamashita").attr("class","yamashita_p");
			$("#yamashita_b").attr("class","yamashita_b");
		
		}else{$("#img_id_yamashita").attr("class","hide");$("#yamashita_b").attr("class","hide");}



		if( <?php echo $ishikawa[2]; ?> ==1){

			if( <?php echo $ishikawa[0]; ?> ==0){$("#ishikawa_s").attr("class","ishikawa_s");}
			else if( <?php echo $ishikawa[0]; ?> ==2){$("#ishikawa_s2").attr("class","ishikawa_s");}
			
			$("#img_id_ishikawa").attr("class","ishikawa_p");
			$("#ishikawa_b").attr("class","ishikawa_b");
		
		}else{$("#img_id_ishikawa").attr("class","hide");$("#ishikawa_b").attr("class","hide");}



		if( <?php echo $kitahara[2]; ?> ==1){

			if( <?php echo $kitahara[0]; ?> ==0){$("#kitahara_s").attr("class","kitahara_s");}
			else if( <?php echo $kitahara[0]; ?> ==2){$("#kitahara_s2").attr("class","kitahara_s");}
			
			$("#img_id_kitahara").attr("class","kitahara_p");
			$("#kitahara_b").attr("class","kitahara_b");
		
		}else{$("#img_id_kitahara").attr("class","hide");$("#kitahara_b").attr("class","hide");}


				if( <?php echo $yoneshige[2]; ?> ==1){

			if( <?php echo $yoneshige[0]; ?> ==0){$("#yoneshige_s").attr("class","yoneshige_s");}
			else if( <?php echo $yoneshige[0]; ?> ==2){$("#yoneshige_s2").attr("class","yoneshige_s");}
			
			$("#img_id_yoneshige").attr("class","yoneshige_p");
			$("#yoneshige_b").attr("class","yoneshige_b");
		
		}else{$("#img_id_yoneshige").attr("class","hide");$("#yoneshige_b").attr("class","hide");}


		if( <?php echo $yamada[2]; ?> ==1){

			if( <?php echo $yamada[0]; ?> ==0){$("#yamada_s").attr("class","yamada_s");}
			else if( <?php echo $yamada[0]; ?> ==2){$("#yamada_s2").attr("class","yamada_s");}
			
			$("#img_id_yamada").attr("class","yamada_p");
			$("#yamada_b").attr("class","yamada_b");
		
		}else{$("#img_id_yamada").attr("class","hide");$("#yamada_b").attr("class","hide");}



		if( <?php echo $tamura[2]; ?> ==1){

			if( <?php echo $tamura[0]; ?> ==0){$("#tamura_s").attr("class","tamura_s");}
			else if( <?php echo $tamura[0]; ?> ==2){$("#tamura_s2").attr("class","tamura_s");}
			
			$("#img_id_tamura").attr("class","tamura_p");
			$("#tamura_b").attr("class","tamura_b");
		
		}else{$("#img_id_tamura").attr("class","hide");$("#tamura_b").attr("class","hide");}


		if( <?php echo $watanabe[2]; ?> ==1){

			if( <?php echo $watanabe[0]; ?> ==0){$("#watanabe_s").attr("class","watanabe_s");}
			else if( <?php echo $watanabe[0]; ?> ==2){$("#watanabe_s2").attr("class","watanabe_s");}
			
			$("#img_id_watanabe").attr("class","watanabe_p");
			$("#watanabe_b").attr("class","watanabe_b");
		
		}else{$("#img_id_watanabe").attr("class","hide");$("#watanabe_b").attr("class","hide");}


		if( <?php echo $sakai[2]; ?> ==1){

			if( <?php echo $sakai[0]; ?> ==0){$("#sakai_s").attr("class","sakai_s");}
			else if( <?php echo $sakai[0]; ?> ==2){$("#sakai_s2").attr("class","sakai_s");}
			
			$("#img_id_sakai").attr("class","sakai_p");
			$("#sakai_b").attr("class","sakai_b");
		
		}else{$("#img_id_sakai").attr("class","hide");$("#sakai_b").attr("class","hide");}



		if( <?php echo $nomura[2]; ?> ==1 ){

			if( <?php echo $nomura[0]; ?> ==0){$("#nomura_s").attr("class","nomura_s");}
			else if( <?php echo $nomura[0]; ?> ==2){$("#nomura_s2").attr("class","nomura_s");}
			
			$("#img_id_nomura").attr("class","nomura_p");
			$("#nomura_b").attr("class","nomura_b");
		
		}else{$("#img_id_nomura").attr("class","hide");$("#nomura_b").attr("class","hide");}


		if(<?php echo $shen[2]; ?> ==1 ){

			if( <?php echo $shen[0]; ?> ==0){$("#shen_s").attr("class","shen_s");}
			else if( <?php echo $shen[0]; ?> ==2){$("#shen_s2").attr("class","shen_s");}
			
			$("#img_id_shen").attr("class","shen_p");
			$("#shen_b").attr("class","shen_b");
		
		}else{$("#img_id_shen").attr("class","hide");$("#shen_b").attr("class","hide");}

	})



 function hyou(no) {
            // 『jQuery』の『ajax()』メソッド
            // 引数は『{url:ファイルのパス, success:終了後の処理の関数}』の連想配列

            $.ajax({
                url: "data" + 2 + ".csv",    // ファイル名
                success: function(result){
			
                    // 引数『result』を取る無名関数
                    // 『result』には取得した文字列が格納されている

	if(no==1){//さちこボタンが押された時の処

	document.location = "http://49.212.200.39/login/kitahara/satiko.php";

	}


	 if(no==2){//研究室ボタンが押された時の処理

     document.location = "http://49.212.200.39/login/kitahara/lab.php";


	}//研究室


	 if(no==4){//会議室ボタンが押された時の処理

	document.location = "http://49.212.200.39/login/kitahara/kaigi.php";

	}//会議室


	 if(no==3){//ITSKY3ボタンが押された時の処理
		
	document.location = "http://49.212.200.39/login/kitahara/itsky3.php";

	 }//ITSKY3ここまで


	 if(no==5){//NIS-Xボタンが押された時の処理

	document.location = "http://49.212.200.39/login/kitahara/nis-x.php";		


	 }//NIS-Xここまで


 	if(no==6){document.location = "http://49.212.200.39/login/kitahara/form.php";}//フォーム画面移動

 	if(no==7){document.location = "http://49.212.200.39/login/mypage.php";}//矢野君のページへ

	if(no==8){document.location = "http://49.212.200.39/login/kitahara/table.php";}//コメントのページへ

	if(no==9){document.location = "http://49.212.200.39/login/kitahara/phpver.php";}//TOPページへ
			
                }//success	
            });//ajax
		
        }hyo



// -->
</script>

<input type="image" onClick="hyou(9);" width="90" height="90" src="./img/topbutton.png">
<input type="image" onClick="hyou(2);" width="90" height="90" src="./img/KE205button2.png">
<input type="image" onClick="hyou(4);" width="90" height="90" src="./img/KE204button2.png">
<input type="image" onClick="hyou(5);" width="90" height="90" src="./img/nisxbutton2.png">
<input type="image" onClick="hyou(1);" width="90" height="90" src="./img/satikobutton2.png">
<input type="image" onClick="hyou(3);" width="90" height="90" src="./img/itsky3button2.png">
<input type="image" onClick="hyou(6);" width="90" height="90" src="./img/status2.png">
<input type="image" onClick="hyou(8);" width="90" height="90" src="./img/comment.png">
<input type="image" onClick="hyou(7);" width="90" height="90" src="./img/yanobutton2.png">


<!-- <input type="image" onClick="hyou(2);" width="120" height="50" src="./img/KE205button2.png">
<input type="image" onClick="hyou(4);" width="120" height="50" src="./img/KE204button2.png">
<input type="image" onClick="hyou(5);" width="120" height="50" src="./img/nisxbutton2.png">
<input type="image" onClick="hyou(1);" width="120" height="50" src="./img/satikobutton2.png">
<input type="image" onClick="hyou(3);" width="120" height="50" src="./img/itsky3button2.png">
<input type="image" onClick="hyou(6);" width="120" height="50" src="./img/status2.png">
<input type="image" onClick="hyou(7);" width="120" height="50" src="./img/yanobutton2.png"> -->

<p><img src="./img/top.png" class="back_g2" id="back_kari"></p>

<p><img src="./img/KE204.png" class="back_g hide" id="back_204"></p>
<p><img src="./img/KE205.png" class="back_g hide" id="back_l"></p>
<p><img src="./img/desk_b.png" class="deskb_p hide" id="deskb_p"></p>
<p><img src="./img/desk_f.png" class="deskf_p hide" id="deskf_p"></p>

<p><img src="./img/background_s.png" class="back_g hide" id="back_s"></p>
<p><img src="./img/background_i.png" class="back_g hide" id="back_i"></p>
<p><img src="./img/background_n.png" class="back_g hide" id="back_n"></p>

<p><img src="./img/kobatake.png" class="hide" id="img_id_kobatake"></p>
<p class="hide" id="str_kobatake" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="kobatake_s"></p>
<p><img src="./img/busy.png" class="hide" id="kobatake_s2"></p>

<p><img src="./img/ookubo.png" class="hide" id="img_id_ookubo"></p>
<p class="hide" id="str_ookubo" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="ookubo_s"></p>
<p><img src="./img/busy.png" class="hide" id="ookubo_s2"></p>
<p><img src="./img/blank.png" class="ookubo_b hide" id="ookubo_b"></p>


<p><img src="./img/fujii.png" class="hide" id="img_id_fujii"></p>
<p class="hide" id="str_fujii" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="fujii_s"></p>
<p><img src="./img/busy.png" class="hide" id="fujii_s2"></p>
<p><img src="./img/blank.png" class="fujii_b hide" id="fujii_b"></p>


<p><img src="./img/nobuta.png" class="hide" id="img_id_nobuta"></p> 
<p class="hide" id="str_nobuta" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="nobuta_s"></p>
<p><img src="./img/busy.png" class="hide" id="nobuta_s2"></p>
<p><img src="./img/blank.png" class="nobuta_b hide" id="nobuta_b"></p>


<p><img src="./img/tsujii.png" class="tsujii_p hide" id="img_id_tsujii"></p>
<p class="hide" id="str_tsujii" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="tsujii_s"></p>
<p><img src="./img/busy.png" class="hide" id="tsujii_s2"></p>


<p><img src="./img/yano.png" class="yano_p hide" id="img_id_yano"></p>
<p class="hide" id="str_yano" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="yano_s"></p>
<p><img src="./img/busy.png" class="hide" id="yano_s2"></p>


<p><img src="./img/muramoto.png" class="muramoto_p hide" id="img_id_muramoto"></p>
<p class="hide" id="str_muramoto" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="muramoto_s"></p>
<p><img src="./img/busy.png" class="hide" id="muramoto_s2"></p>


<p><img src="./img/kotera.png" class="kotera_p hide" id="img_id_kotera"></p>
<p class="hide" id="str_kotera" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="kotera_s"></p>
<p><img src="./img/busy.png" class="hide" id="kotera_s2"></p>
<p><img src="./img/blank.png" class="kotera_b hide" id="kotera_b"></p>


<p><img src="./img/imairi.png" class="imairi_p hide" id="img_id_imairi"></p>
<p class="hide" id="str_imairi" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="imairi_s"></p>
<p><img src="./img/busy.png" class="hide" id="imairi_s2"></p>
<p><img src="./img/blank.png" class="imairi_b hide" id="imairi_b"></p>


<p><img src="./img/yamashita.png" class="yamashita_p hide" id="img_id_yamashita"></p>
<p class="hide" id="str_yamashita" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="yamashita_s"></p>
<p><img src="./img/busy.png" class="hide" id="yamashita_s2"></p>
<p><img src="./img/blank.png" class="yamashita_b hide" id="yamashita_b"></p>



<p><img src="./img/ishikawa.png" class="ishikawa_p hide" id="img_id_ishikawa"></p>
<p class="hide" id="str_ishikawa" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="ishikawa_s"></p>
<p><img src="./img/busy.png" class="hide" id="ishikawa_s2"></p>
<p><img src="./img/blank.png" class="ishikawa_b hide" id="ishikawa_b"></p>



<p><img src="./img/kitahara.png" class="kitahara_p hide" id="img_id_kitahara"></p>
<p class="hide" id="str_kitahara" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="kitahara_s"></p>
<p><img src="./img/busy.png" class="hide" id="kitahara_s2"></p>
<p><img src="./img/blank.png" class="kitahara_b hide" id="kitahara_b"></p>


<p><img src="./img/yoneshige.png" class="yoneshige_p hide" id="img_id_yoneshige"></p>
<p class="hide" id="str_yoneshige" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="yoneshige_s"></p>
<p><img src="./img/busy.png" class="hide" id="yoneshige_s2"></p>
<p><img src="./img/blank.png" class="yoneshige_b hide" id="yoneshige_b"></p>


<p><img src="./img/yamada.png" class="yamada_p hide" id="img_id_yamada"></p>
<p class="hide" id="str_yamada" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="yamada_s"></p>
<p><img src="./img/busy.png" class="hide" id="yamada_s2"></p>
<p><img src="./img/blank.png" class="yamada_b hide" id="yamada_b"></p>


<p><img src="./img/tamura.png" class="tamura_p hide" id="img_id_tamura"></p>
<p class="hide" id="str_tamura" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="tamura_s"></p>
<p><img src="./img/busy.png" class="hide" id="tamura_s2"></p>
<p><img src="./img/blank.png" class="tamura_b hide" id="tamura_b"></p>


<p><img src="./img/watanabe.png" class="watanabe_p hide" id="img_id_watanabe"></p>
<p class="hide" id="str_watanabe" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="watanabe_s"></p>
<p><img src="./img/busy.png" class="hide" id="watanabe_s2"></p>
<p><img src="./img/blank.png" class="watanabe_b hide" id="watanabe_b"></p>

<p><img src="./img/sakai.png" class="sakai_p hide" id="img_id_sakai"></p>
<p class="hide" id="str_sakai" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="sakai_s"></p>
<p><img src="./img/busy.png" class="hide" id="sakai_s2"></p>
<p><img src="./img/blank.png" class="sakai_b hide" id="sakai_b"></p>


<p><img src="./img/nomura.png" class="nomura_p hide" id="img_id_nomura"></p>
<p class="hide" id="str_nomura" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="nomura_s"></p>
<p><img src="./img/busy.png" class="hide" id="nomura_s2"></p>
<p><img src="./img/blank.png" class="nomura_b hide" id="nomura_b"></p>

<p><img src="./img/shen.png" class="shen_p hide" id="img_id_shen"></p>
<p class="hide" id="str_shen" span style="background-color:#000000;color:#ffffff;"></span></p>
<p><img src="./img/happy.png" class="hide" id="shen_s"></p>
<p><img src="./img/busy.png" class="hide" id="shen_s2"></p>
<p><img src="./img/blank.png" class="shen_b hide" id="shen_b"></p>




</body>
</html>

