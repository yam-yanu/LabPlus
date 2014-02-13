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

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '100', '".$_SESSION['name']."', '".$now_time."','','1','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==0){//pcなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '100', '".$_SESSION['name']."', '".$now_time."','','0','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==2){//androidなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '100', '".$_SESSION['name']."', '".$now_time."','','2','".$ipAddress."')";
 $result = executeQuery($sql);


}else if($tanmatu==3){//ガラケーなら

 $sql = "INSERT INTO kitahara VALUES('".$_SESSION['team_id']."', '".$_SESSION['id']."', '100', '".$_SESSION['name']."', '".$now_time."','','3','".$ipAddress."')";
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
			
                }//success	
            });//ajax
		
        }hyo



// -->
</script>

<input type="image" onClick=location.reload() width="90" height="90"  src="./img/topbutton.png" />
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

