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
$videoId = $_GET['id'];
$apiUrl = "http://localhost:3000/api/videos/$videoId";
$data = file_get_contents($apiUrl);
$video = json_decode($data, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $video['title'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #fff;
            font-size: 2rem;
            margin-top: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        iframe {
            width: 100%;
            height: 500px;
            border: none;
        }
        .video-details, .channel-details {
            margin-top: 20px;
        }
        .video-details p, .channel-details p {
            font-size: 1rem;
            margin: 8px 0;
        }
        .video-details span, .channel-details span {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .thumbnail {
            margin-top: 20px;
            text-align: center;
        }
        .thumbnail img {
            width: 300px;          
            border-radius: 8px;
        }
        a {
            color: #1e90ff;
            text-decoration: none;
            font-size: 1rem;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            font-size: 1rem;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $video['title'] ?></h1>
        <iframe src="https://www.youtube.com/embed/<?= $video['videoId'] ?>?autoplay=1" allow="autoplay" allowfullscreen></iframe>

        <div class="video-details">
            <p><span>Description:</span> <?= $video['description'] ?></p>
            <p><span>Views:</span> <?= $video['views'] ?></p>
            <p><span>Likes:</span> <?= $video['likes'] ?></p>
            <p><span>URL:</span> <a href="<?= $video['url'] ?>" target="_blank">Watch on YouTube</a></p>
        </div>

        <div class="thumbnail">
            <img src="<?= $video['thumbnails'] ?>" alt="Thumbnail">
        </div>

        <div class="channel-details">
            <p><span>Channel Title:</span> <?= $video['channelTitle'] ?></p>
            <p><span>Channel Description:</span> <?= $video['channelDescription'] ?></p>
            <p><span>Subscribers:</span> <?= $video['channelSubscribers'] ?></p>
            <div class="thumbnail">
            <img src="<?= $video['channelThumbnails'] ?>" alt="Channel Thumbnail">
        </div>
            <p><span>Channel URL:</span> <a href="https://www.youtube.com<?= $video['channelUrl'] ?>" target="_blank">Go to Channel</a></p>
        </div>

        <div class="back-button">
            <a href="index.php">Back to Trending Videos</a>
        </div>
    </div>
</body>
</html>