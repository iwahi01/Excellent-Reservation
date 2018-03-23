
<?php
$curl = curl_init();

$base_url = "http://iwahi01-ra63:9090/cdd";
curl_setopt($curl ,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
$basic = base64_encode("superuser@ca.com:suser");
$header = ["Content-Type: application/json", "Authorization: Basic ".$basic];
curl_setopt($curl, CURLOPT_USERPWD,"superuser@ca.com:suser");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $base_url."/design/0000/v1/releases?filter=".urlencode("イテレーション2"));
$json = json_decode(curl_exec($curl), true);
$rel = $json["data"][0]["executionData"]["releaseId"];

curl_setopt($curl, CURLOPT_URL, $base_url."/design/0000/v1/releases/".$rel."/phases");
$json = json_decode(curl_exec($curl), true);
$phase = $json["data"][0]["tasks"][0]["phaseId"];

$json = '{"status" : "RUNNING"}';
$json = file_get_contents($base_url."/execution/0000/v1/releases-execution/".$rel."/phases-execution/".$phase,
        null, stream_context_create([
        "http" => [
        "method" => "PATCH",
        "header" => $header[0]."\r\n".
        $header[1]."\r\n".
        "Content-Length: ".strlen($json)."\r\n",
        "content" => $json]]));
        $json = json_decode($json, true);
if (strcmp($json["data"]["status"], "RUNNING") != 0) {
  exit("CDDを起動できませんでした。");
}

curl_close($curl);
?>
