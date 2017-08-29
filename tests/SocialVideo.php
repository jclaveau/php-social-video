<?php
namespace JClaveau\SocialVideo;


require_once __DIR__ . '/../src/SocialVideo.php';

//------------------------------------------------------------------------------/
// TESTS
//------------------------------------------------------------------------------/
$vimeo = [
    'https://vimeo.com/87973054',
    'http://vimeo.com/87973054',
    'http://vimeo.com/87973054',
    'http://player.vimeo.com/video/87973054?title=0&amp;byline=0&amp;portrait=0',
    'http://player.vimeo.com/video/87973054',
    'http://player.vimeo.com/video/87973054',
    'http://player.vimeo.com/video/87973054?title=0&amp;byline=0&amp;portrait=0',
    'http://vimeo.com/channels/vimeogirls/87973054',
    'http://vimeo.com/channels/vimeogirls/87973054',
    'http://vimeo.com/channels/staffpicks/87973054',
    'http://vimeo.com/87973054',
    'http://vimeo.com/channels/vimeogirls/87973054',
];

$vimeoInvalid = [
    'http://vimeo.com/videoschool',
    'http://vimeo.com/videoschool/archive/behind_the_scenes',
    'http://vimeo.com/forums/screening_room',
    'http://vimeo.com/forums/screening_room/topic:42708',
];


$youtube = [
    "https://www.youtube.com/watch?v=nCwRJUg3tcQ&list=PLv5BUbwWA5RYaM6E-QiE8WxoKwyBnozV2&index=4",
    "http://www.youtube.com/watch?v=nCwRJUg3tcQ&feature=relate",
    'http://youtube.com/v/nCwRJUg3tcQ?feature=youtube_gdata_player',
    'http://youtube.com/vi/nCwRJUg3tcQ?feature=youtube_gdata_player',
    'http://youtube.com/?v=nCwRJUg3tcQ&feature=youtube_gdata_player',
    'http://www.youtube.com/watch?v=nCwRJUg3tcQ&feature=youtube_gdata_player',
    'http://youtube.com/?vi=nCwRJUg3tcQ&feature=youtube_gdata_player',
    'http://youtube.com/watch?v=nCwRJUg3tcQ&feature=youtube_gdata_player',
    'http://youtube.com/watch?vi=nCwRJUg3tcQ&feature=youtube_gdata_player',
    'http://youtu.be/nCwRJUg3tcQ?feature=youtube_gdata_player',
    "https://youtube.com/v/nCwRJUg3tcQ",
    "https://youtube.com/vi/nCwRJUg3tcQ",
    "https://youtube.com/?v=nCwRJUg3tcQ",
    "https://youtube.com/?vi=nCwRJUg3tcQ",
    "https://youtube.com/watch?v=nCwRJUg3tcQ",
    "https://youtube.com/watch?vi=nCwRJUg3tcQ",
    "https://youtu.be/nCwRJUg3tcQ",
    "http://youtu.be/nCwRJUg3tcQ?t=30m26s",
    "https://youtube.com/v/nCwRJUg3tcQ",
    "https://youtube.com/vi/nCwRJUg3tcQ",
    "https://youtube.com/?v=nCwRJUg3tcQ",
    "https://youtube.com/?vi=nCwRJUg3tcQ",
    "https://youtube.com/watch?v=nCwRJUg3tcQ",
    "https://youtube.com/watch?vi=nCwRJUg3tcQ",
    "https://youtu.be/nCwRJUg3tcQ",
    "https://youtube.com/embed/nCwRJUg3tcQ",
    "http://youtube.com/v/nCwRJUg3tcQ",
    "http://www.youtube.com/v/nCwRJUg3tcQ",
    "https://www.youtube.com/v/nCwRJUg3tcQ",
    "https://youtube.com/watch?v=nCwRJUg3tcQ&wtv=wtv",
    "http://www.youtube.com/watch?dev=inprogress&v=nCwRJUg3tcQ&feature=related"
];


$dailymotion = [
    'http://www.dailymotion.com/video/x2jvvep_coup-incroyable-pendant-un-match-de-ping-pong_tv',
    'http://www.dailymotion.com/video/x2jvvep_rates-of-exchange-like-a-renegade_music',
    'http://www.dailymotion.com/video/x2jvvep',
    'http://www.dailymotion.com/hub/x2jvvep_Galatasaray',
    'http://www.dailymotion.com/hub/x2jvvep_Galatasaray#video=x2jvvep',
    'http://www.dailymotion.com/video/x2jvvep_hakan-yukur-klip_sport',
    'http://dai.ly/x2jvvep',
];

$local = [
    '/video/babla.mp4',
    '/medias/models/Campaign_Native/891/url_video/979/2017-08-29_moi_je_me_la_pete?_.mp4',
];


echo "Ids\n";
foreach ($vimeo as $url) {
    echo "Vimeo\n";
    $result = SocialVideo::getVimeoId($url);
    var_dump($result);
}
echo "\n\n\n";
foreach ($vimeoInvalid as $url) {
    echo "Vimeo invalid\n";
    $result = SocialVideo::getVimeoId($url);
    var_dump($result);
}
echo "\n\n\n";
foreach ($youtube as $url) {
    echo "Youtube\n";
    $result = SocialVideo::getYoutubeId($url);
    var_dump($result);
}
echo "\n\n\n";
foreach ($local as $url) {
    echo "Youtube Local\n";
    $result = SocialVideo::getYoutubeId($url);
    var_dump($result);
}

echo "\n\n\n";
foreach ($dailymotion as $url) {
    echo "Dailymotion\n";
    $result = SocialVideo::getDailyMotionId($url);
    var_dump($result);
}
foreach ($local as $url) {
    echo "Dailymotion Local\n";
    $result = SocialVideo::getDailyMotionId($url);
    var_dump($result);
}

// return;


echo "\n\n\n";
foreach ($local as $url) {
    echo "Local\n";
    $result = SocialVideo::getDailyMotionId($url);
    var_dump($result);
}


echo "\n\n\n";
foreach ($local as $url) {
    echo "Local\n";
    $result = SocialVideo::getEmbedVideo($url);
    var_dump($result);
}





// return;


echo "\n\n\n";
echo "Thumbnails\n";
$mixed = array_merge($vimeo, $youtube, $dailymotion);


foreach ($mixed as $url) {
    $thumb_src = SocialVideo::getVideoThumbnailByUrl($url);
    echo 'Thumb: ' . $thumb_src ."\n";
    echo 'Location: ' . SocialVideo::getVideoLocation($url) ."\n";
}
