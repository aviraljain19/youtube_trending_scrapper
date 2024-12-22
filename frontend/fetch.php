<?php
set_time_limit(60);
function file_get_contents_curl($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_URL, $url);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
$fetchUrl = 'http://localhost:3000/api/videos/fetch';
$response = file_get_contents($fetchUrl);
header('Location: index.php');
?>
