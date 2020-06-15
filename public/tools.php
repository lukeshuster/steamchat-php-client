<?php
function topNav($pageTitle){
echo <<<DOC
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/styles.css">
  <meta charset="utf-8">
  <title>$pageTitle</title>
</head>
<body>
    <header>
    <nav class="main-nav">
        <a href="/">Steam Chat</a>
    </nav>
</header>
DOC;
}

function bottomFooter(){
    $cURLConnection = curl_init();
    curl_setopt($cURLConnection, CURLOPT_URL, 'https://steamchat-api-b3xftqio3a-uc.a.run.app/get_total_users');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $apiRes = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $res_json= json_decode($apiRes, true);

echo <<<DOC
<footer>
    <div> Total Steam Chat Users: {$res_json['total_users']}</div>
    <div> Luke Shuster s3725150 & Craig Slack s3788151</div>
</footer>
</body>
</html>
DOC;
}
?>