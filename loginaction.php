<?php
echo '<html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />';
echo '<link rel="stylesheet" type="text/css" href="gonomiya.css"  />';
echo '<title>グローバル鉄道オンライン予約 Excellent予約トップ</title>';
echo '<script type="text/javascript" id="ca_eum_ba_ext" src="http://iwahi01-centos7.ca.com:9080/mdo/v1/sdks/browser/BAExt.js"></script>';
echo '<script type="text/javascript" id="ca_eum_ba" agent=browser src="http://iwahi01-centos7.ca.com:9080/mdo/v1/sdks/browser/BA.js" data-profileUrl="http://iwahi01-centos7.ca.com:7081/api/1/urn:ca:tenantId:BTA-USERSTORE/urn:ca:appId:%E3%82%A8%E3%82%AF%E3%82%BB%E3%83%AC%E3%83%B3%E3%83%88%E4%BA%88%E7%B4%84/profile?agent=browser" data-tenantID="BTA-USERSTORE" data-appID="エクセレント予約" data-appKey="1af905d0-1daf-11e8-a2f8-9761fa1c39f9" ></script>';
echo '</head>';
require_once './mysql.php';
$con = mysqli_connect(HOST, USER, PWD);
if (!$con) {
	exit('データベースに接続できませんでした。<br />');
}

$result = mysqli_select_db($con,'exdb');
if (!$result) {
	exit('データベースを選択できませんでした。<br />');
}
$result = mysqli_query($con,'SET NAMES utf8' );
if (!$result) {
	exit('文字コードを指定できませんでした。<br />');
}

$personal_sql='select * from members where userid="'.$_POST["userid"].'" and password="'.$_POST["password"].'"';
$result = mysqli_query($con,$personal_sql);

if ($data = mysqli_fetch_array($result)) {
	echo '<form id="standard" action="referinfo.php" method="post">';
	echo '<ul>';
	echo '<li>';
	echo '<center>';
	echo '<img src="image/EXlogo.png" width="180" height=130/><br />';
	echo 'Excellent予約トップ<br />';
	echo htmlspecialchars($data["lastname"],ENT_QUOTES,'UTF-8').' '.htmlspecialchars($data["firstname"],ENT_QUOTES,'UTF-8').' 様 ようこそ<br />';
	echo '</center>';
	echo '</li>';
	echo '<li>';
	echo '<center>';
	echo '<input type="hidden" name="userid" value="'.$_POST["userid"].'" />';
	echo '<input type="submit" name="submit" value="個人情報照会" />';
	echo '</li>';
	echo '<li>';
	echo ' <center>接続先(デバッグ用)<br /></center>';
	echo '<center><select name="uriselector" size="1" style="width:114px" >';
	echo '  <option value="APIGW">API Gateway</option>';
	echo '  <option value="SV">仮想サービス</option>';
	echo '</select></center></p>';
	echo '</li>';
	echo '</center>';
	echo '<br />';
	echo '</li>';
	echo '<li>';
} else {
	echo '<form id="standard"><ul>';
	echo '<li>';
	echo '<center>ユーザID又はパスワードが間違っています。<br />';
	echo '</li>';
	echo '<li>';
	echo '<center><input type="button" value="戻る" onClick="history.back();"></center>';
}

echo '</li>';
echo '</ul>';
echo '</form>';
echo '<center>';
echo '<footer>';
echo '<img src="image/GRlogo.png" width="90" height=60/><br />';
echo 'Global Railways Co., Ltd. All Rights Reserved.</center>';
echo '</footer>';
echo '</body></html>';
?>
