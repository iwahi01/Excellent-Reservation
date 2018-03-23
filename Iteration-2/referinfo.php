<?php
echo "<html>";
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />';
echo '<link rel="stylesheet" type="text/css" href="gonomiya.css"  />';
echo '<title>グローバル鉄道オンライン予約 情報照会</title>';
echo '<script type="text/javascript" id="ca_eum_ba_ext" src="http://iwahi01-centos7.ca.com:9080/mdo/v1/sdks/browser/BAExt.js"></script>';
echo '<script type="text/javascript" id="ca_eum_ba" agent=browser src="http://iwahi01-centos7.ca.com:9080/mdo/v1/sdks/browser/BA.js" data-profileUrl="http://iwahi01-centos7.ca.com:7081/api/1/urn:ca:tenantId:BTA-USERSTORE/urn:ca:appId:%E3%82%A8%E3%82%AF%E3%82%BB%E3%83%AC%E3%83%B3%E3%83%88%E4%BA%88%E7%B4%84/profile?agent=browser" data-tenantID="BTA-USERSTORE" data-appID="エクセレント予約" data-appKey="1af905d0-1daf-11e8-a2f8-9761fa1c39f9" ></script>';
echo '</head>';
echo '<form id="standard" action="chgpersonalinfo.php" method="post">';
echo '<ul>';
echo '<li>';
echo '<center>';
echo '<img src="image/EXlogo.png" width="180" height=130/><br />';
echo htmlspecialchars($_POST["submit"],ENT_QUOTES,'UTF-8').'<br />';
echo '</center>';
echo '</li>';
echo '<li>';

// URIの切り替え処理
if ($_POST["uriselector"]=="APIGW") {
	$MEMBERS_TARGET="https://iwahi01-apig92.ca.com:8443/LAC_Proxy/aovcd/v1/main:members?nometa=true&sysfilter=equal(userid:'".$_POST["userid"]."')";
	$MEMBER_RES_TARGET="https://iwahi01-apig92.ca.com:8443/LAC_Proxy/aovcd/v1/member_reservation_order?nometa=true&sysfilter=equal(userid:'".$_POST["userid"]."')";
} else if ($_POST["uriselector"]=="SV") {
	$MEMBERS_TARGET='http://iwahi01-devtest10:7777/members?nometa=true&sysfilter=equal(userid:"'.$_POST["userid"].'")';
	$MEMBER_RES_TARGET='http://iwahi01-devtest10:7778/member_reservation_order?nometa=true&sysfilter=equal(userid:"'.$_POST["userid"].'")';
}

//curl初期化
$ch=curl_init();
if ($_POST["submit"]=="個人情報照会"){

	$URI=$MEMBERS_TARGET;
		
        curl_setopt($ch,CURLOPT_URL,$URI);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);

        $ret=curl_exec($ch);
        $decoded=json_decode($ret,true);
        // cURL リソースを閉じ、システムリソースを解放します
        curl_close($ch);
               
        echo "<center><table border=1><tr>";
        echo '<td>お名前</td><td>'.$decoded[0]["lastname"].' '.$decoded[0]["firstname"].' 様</td></tr>';
        echo '<td>年齢</td><td>'.$decoded[0]["age"].'歳</td></tr>';
        echo '<td>ご住所</td><td>'.$decoded[0]["address1"].'</td></tr>';
        echo '<td>住所つづき</td><td>'.$decoded[0]["address2"].'</td></tr>';
        echo '<td>住所つづき</td><td>'.$decoded[0]["address3"].'</td></tr>';
        echo '<td>ご連絡先</td><td>'.$decoded[0]["phone1"].'-'.$decoded[0]["phone2"].'-'.$decoded[0]["phone3"].'</td></tr>';
        echo '<td>ログインID</td><td>'.$decoded[0]["userid"].'</td></tr>';
        echo '<td>所有ポイント</td><td>'.$decoded[0]["point"].'</td></tr>';
        echo '<td>会員ランクID</td><td>'.$decoded[0]["rank"].'</td></tr>';

       
        echo '</tr></table>';

	echo '<br />';
	echo '<input type="submit" name="submit" value="変更"/><input type="button" value="戻る" onClick="history.back();"> </center>';
} else if ($_POST["submit"]=="予約情報照会"){

	$URI=$MEMBER_RES_TARGET;

        curl_setopt($ch,CURLOPT_URL,$URI);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);

        $ret=curl_exec($ch);
        $decoded=json_decode($ret,true);
               
        echo "<center><table border=1><tr>";
	
        echo '<th>発券日</th><th>ご旅行の予定日</th><th>列車名</th><th>座席番号</th></tr>';
        for($i = 0; $i < count($decoded[0]["reservation"]); $i++) {
                echo '<tr><td>'.$decoded[0]["reservation"][$i]["order"][0]["PURCHASE_DATE"].'</td><td>'.$decoded[0]["reservation"][$i]["order"][0]["TRAVEL_DATE"].'</td><td>'.$decoded[0]["reservation"][$i]["order"][0]["TRAIN_NAME"].'</td><td>'.$decoded[0]["reservation"][$i]["order"][0]["SEAT_NO"].'</td></tr>';
	}
        echo '</tr></table>';
        // cURL リソースを閉じ、システムリソースを解放します
        curl_close($ch);

	echo '<br />';
	echo '<input type="submit" name="submit" value="変更"/><input type="button" value="戻る" onClick="history.back();"> </center>';


} 
// 将来拡張用
else {
	echo "実装されていません<br />";
}

echo '</form></html>';
?>
