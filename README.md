Video ids and thumbnails from Youtube, DailyMotion, Vimeo and Facebook
=============================

This simple class provides helpers to extract information from URLs of
videos, draws embed videos from it, get thumbnails urls and checks from
which social network they come from.

All those helpers are stored in [SocialVideo.php](https://github.com/jclaveau/php-social-video/blob/master/src/SocialVideo.php)

Api reference can be found here [API reference](docs/JClaveau-SocialVideo-SocialVideo.md)


Quality
--------------
[![Build Status](https://travis-ci.org/jclaveau/php-social-video.png?branch=master)](https://travis-ci.org/jclaveau/php-social-video)
[![codecov](https://codecov.io/gh/jclaveau/php-social-video/branch/master/graph/badge.svg)](https://codecov.io/gh/jclaveau/php-social-video)
[![Maintainability](https://api.codeclimate.com/v1/badges/75c89e5e61ab58d5fc71/maintainability)](https://codeclimate.com/github/jclaveau/php-social-video/maintainability)
[![Dependency Status](https://www.versioneye.com/user/projects/59f33e0515f0d7003ff197c3/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/59f33e0515f0d7003ff197c3)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/jclaveau/php-social-video/issues)
[![Viewed](http://hits.dwyl.com/jclaveau/php-social-video.svg)](http://hits.dwyl.com/jclaveau/php-social-video)

Supported social networks
--------------
- Youtube
- DailyMotion
- Vimeo


Installation
--------------
Until the version is setted up and the package published on packagist, you'll need to add the following lines to your composer.json.
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/jclaveau/php-social-video"
        }
    ],
    "require": {
        "jclaveau/php-social-video": "dev-master",
    },
}
```

Usage
--------------
```php

// To extract an id from any youtube URI or check that it is a youtube URI
$youtubeId = SocialVideo::getYoutubeId("https://youtube.com/v/nCwRJUg3tcQ");

// To disaply really fastly a video player with the embed video corresponding
// to your URI
$youtubeHtmlPlayer = SocialVideo::getEmbedVideoHtml("https://youtube.com/v/nCwRJUg3tcQ", [
    'width'  => 300, // custom with
    'height' => 200, // custom height 
    'id'     => "my-custom-video-elementid",
]);
echo $youtubeHtmlPlayer;


// By default all the supported social networks are enabled
SocialVideo::disableNetwork( SocialVideo::VIMEO );
$vimeoId = SocialVideo::getVimeoId('http://vimeo.com/87973054');
// $vimeoId is null as Vimeo support is disabled


```

Todo
--------------
- Implement Facebook videos support
- Make the testing exhaustive
- Documentation
- Semantic Versioning
- packagist


Related
--------------
- Based on [video-ids-and-thumbnails](https://github.com/lingtalfi/video-ids-and-thumbnails)
- [YouTubeUtils](https://github.com/lingtalfi/YouTubeUtils)
- [code quality badges](https://github.com/dwyl/repo-badges)
- [Semver](https://semver.org/)
