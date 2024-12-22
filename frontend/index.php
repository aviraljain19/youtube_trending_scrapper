<?php
function file_get_contents_curl($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_URL, $url);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
$apiUrl = "http://localhost:3000/api/videos/";
$data = file_get_contents($apiUrl);
$videos = json_decode($data, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Trending Videos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <div class="logo">
           <img src="https://upload.wikimedia.org/wikipedia/commons/4/42/YouTube_icon_%282013-2017%29.png" alt="YouTube Logo">
           <span>YouTube</span>
       </div>
  </header>
  <div class="btn">
  <button onclick="window.location.href='fetch.php'">Fetch Latest Videos</button>

  </div>
    <span style="color:white; margin: 23px; font-size: 35px; font-weight:bold;">Trending🔥</span>
    <div class="videos" style="display: flex;">
        <?php foreach ($videos as $video): ?>
            <div class="video" style="margin: 10px;">
                <a href="details.php?id=<?= htmlspecialchars($video['videoId']) ?>" >
                    <img src="<?= htmlspecialchars($video['thumbnails']) ?>" 
                         alt="<?= htmlspecialchars($video['title']) ?>" 
                        >
                </a>
                <h4>
                    <a href="details.php?id=<?= htmlspecialchars($video['videoId']) ?>" 
                       style="text-decoration: none; color: rgb(245, 245, 245)">
                        <?= htmlspecialchars($video['title']) ?>
                    </a>
                </h4>
            </div>
            
        <?php endforeach; ?>
    </div>
</body>
</html>
