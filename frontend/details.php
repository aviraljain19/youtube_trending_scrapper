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
$apiUrl = "https://youtube-trending-scrapper-backend.onrender.com/api/videos/$videoId";
$data = file_get_contents($apiUrl);
$video = json_decode($data, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $video['title'] ?></title>
    <link rel="stylesheet" href="assets/css/detais.css">
    <script src="https://kit.fontawesome.com/8e2867f597.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="videoDetail">
            <h1><?= $video['title'] ?></h1>
            <iframe src="https://www.youtube.com/embed/<?= $video['videoId'] ?>?autoplay=1" allow="autoplay" allowfullscreen></iframe>

            <div class="video-details">
                <p><span>Description:</span> <?= $video['description'] ?></p>
                <p><span>Views:</span> <?= $video['views'] ?><i class="fa-solid fa-eye" style="color: #ffffff; margin-left:5px;"></i></p>
                <p><span>Likes:</span> <?= $video['likes'] ?><i class="fa-regular fa-thumbs-up" style="color: #ffffff; margin-left:5px;"></i></p>
                <p><span>URL:</span> <a href="<?= $video['url'] ?>" target="_blank">Watch on YouTube</a></p>
            </div>

            <div class="thumbnail">
                <img src="<?= $video['thumbnails'] ?>" alt="Thumbnail">
            </div>
        
            <div class="sizes">
                <button onclick="viewImage('1280x720')">1280x720</button>
                <button onclick="viewImage('640x480')">640x480</button>
                <button onclick="viewImage('480x360')">480x360</button>
                <button onclick="viewImage('320x180')">320x180</button>
                <button onclick="viewImage('120x90')">120x90</button>
            </div>      
        </div>
        <div class="channelDetail">
            <div class="channel-details">
                <p><span>Channel Title:</span> <?= $video['channelTitle'] ?></p>
                <p><span>Channel Description:</span> <?= $video['channelDescription'] ?></p>
                <p><span>Subscribers:</span> <?= $video['channelSubscribers'] ?></p>
                <div class="thumbnail">
                    <img src="<?= $video['channelThumbnails'] ?>" alt="Channel Thumbnail">
                </div>
                <p><span>Channel URL:</span> <a href="<?= $video['channelUrl'] ?>" target="_blank">Go to Channel</a></p>
            </div>
        </div>
        <div class="back-button">
            <a href="index.php"><i class="fa-solid fa-arrow-left" style="margin-right:5px; color:#1e90ff;"></i>Back to Trending Videos</a>
        </div>
    </div>
    <script>
        function viewImage(size) {
            if(size==='1280x720'){
                const imgSrc = 'https://img.youtube.com/vi/<?= $videoId ?>/maxresdefault.jpg';
                window.open(imgSrc);
            }
            else if(size==='640x480'){
                const imgSrc = 'https://i.ytimg.com/vi/<?= $videoId ?>/sddefault.jpg';
                window.open(imgSrc);
            }
            else if(size==='480x360'){
                const imgSrc = 'https://i.ytimg.com/vi/<?= $videoId ?>/hqdefault.jpg';
                window.open(imgSrc);
            }
            else if(size==='320x180'){
                const imgSrc = 'https://img.youtube.com/vi/<?= $videoId ?>/mqdefault.jpg';
                window.open(imgSrc);
            }
            else if(size==='120x90'){
                const imgSrc = 'https://img.youtube.com/vi/<?= $videoId ?>/default.jpg';
                window.open(imgSrc);
            }
        }
    </script>
</body>
</html>