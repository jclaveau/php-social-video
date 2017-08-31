<?php
namespace JClaveau\SocialVideo;

/**
 *
 */
class SocialVideo
{
    const DAILYMOTION = 'DailyMotion';
    const VIMEO       = 'Vimeo';
    const YOUTUBE     = 'Youtube';
    const FACEBOOK    = 'Facebook';    // TODO support not implemented

    protected static $enabledSocialNetworks = [
        self::YOUTUBE,
        self::DAILYMOTION,
        self::VIMEO,
        // self::FACEBOOK,
    ];

    /**
     * Checks that the social network given as parameter is enabled
     */
    public static function isNetworkEnabled($socialNetworkName)
    {
        return in_array($socialNetworkName, self::$enabledSocialNetworks);
    }

    /**
     * Extracts the daily motion id from a daily motion url or returns null.
     */
    public static function getDailyMotionId($url)
    {
        if (!self::isNetworkEnabled(self::DAILYMOTION))
            return null;

        if (preg_match('!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m)) {
            if (isset($m[6])) {
                return $m[6];
            }

            if (isset($m[4])) {
                return $m[4];
            }

            return $m[2];
        }
    }

    /**
     * Extracts the vimeo id from a vimeo url or returns null.
     */
    public static function getVimeoId($url)
    {
        if (!self::isNetworkEnabled(self::VIMEO))
            return null;

        if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m)) {
            return $m[1];
        }
    }

    /**
     * Extracts the youtube id from a youtube url  or returns null.
     */
    public static function getYoutubeId($url)
    {
        if (!self::isNetworkEnabled(self::YOUTUBE))
            return null;

        $parts = parse_url($url);

        if (!isset($parts['host']))
            return null;

        $host = $parts['host'];
        if (
            false === strpos($host, 'youtube') &&
            false === strpos($host, 'youtu.be')
        ) {
            return null;
        }

        if (isset($parts['query'])) {
            parse_str($parts['query'], $qs);
            if (isset($qs['v'])) {
                return $qs['v'];
            }
            else if (isset($qs['vi'])) {
                return $qs['vi'];
            }
        }

        if (isset($parts['path'])) {
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path) - 1];
        }

        return null;
    }

    /**
     * Returns true if the url is valid which means it could be a simple
     * video file uploaded somewhere.
     *
     * @todo add checks mime-type or extension check?
     * @return bool
     */
    public static function isOtherUrl($url)
    {
        return !self::isSocialVideo($url)
            && (bool) parse_url($url);
    }

    /**
     * Returns true if the url is valid which means it could be a simple
     * video file uploaded somewhere.
     *
     * @return bool
     */
    public static function isLocalUrl($url)
    {
        $parts = parse_url($url);

        return !self::isSocialVideo($url)
            && $parts && empty($parts['host']);
    }

    /**
     * Returns true if the url is valid which means it could be a simple
     * video file uploaded somewhere.
     *
     * @todo add checks mime-type check?
     */
    public static function isSocialVideo($url)
    {
        return self::getYoutubeId($url)
            || self::getDailyMotionId($url)
            || self::getVimeoId($url)
            ;
    }

    /**
     * Gets the thumbnail url associated with an url from either:
     *
     *      - youtube
     *      - daily motion
     *      - vimeo
     *
     * Returns false if the url couldn't be identified.
     *
     * In the case of you tube, we can use the second parameter (format), which
     * takes one of the following values:
     *      - small         (returns the url for a small thumbnail)
     *      - medium        (returns the url for a medium thumbnail)
     */
    public static function getVideoThumbnailByUrl($url, $format = 'small')
    {
        if ($id = self::getVimeoId($url)) {
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
            /**
             * thumbnail_small
             * thumbnail_medium
             * thumbnail_large
             */
            return $hash[0]['thumbnail_large'];
        }
        elseif ($id = self::getDailyMotionId($url)) {
            return 'http://www.dailymotion.com/thumbnail/video/' . $id;
        }
        elseif ($id = self::getYoutubeId($url)) {
            /**
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/0.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/1.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/2.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/3.jpg
             *
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/default.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/hqdefault.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/mqdefault.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/sddefault.jpg
             * http://img.youtube.com/vi/<insert-youtube-video-id-here>/maxresdefault.jpg
             */
            if ('medium' === $format) {
                return 'http://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
            }
            return 'http://img.youtube.com/vi/' . $id . '/default.jpg';
        }
    }

    /**
     * Returns the location of the actual video for a given url which belongs to either:
     *
     *      - youtube
     *      - daily motion
     *      - vimeo
     *
     * Or returns false in case of failure.
     * This function can be used for creating video sitemaps.
     */
    public static function getVideoLocation($url)
    {
        if (false !== ($id = self::getDailyMotionId($url))) {
            return 'http://www.dailymotion.com/embed/video/' . $id;
        }
        elseif (false !== ($id = self::getVimeoId($url))) {
            return 'http://player.vimeo.com/video/' . $id;
        }
        elseif (false !== ($id = self::getYoutubeId($url))) {
            return 'http://www.youtube.com/embed/' . $id;
        }
        else if (self::isVideoFile($url)) {
            return $url;
        }

        return false;
    }

    /**
     * Returns the html code for an embed responsive video, for a given url.
     * The url has to be either from:
     * - youtube
     * - daily motion
     * - vimeo
     *
     * Returns false in case of failure
     */
    public static function getEmbedVideoHtml($url, array $optionalAttributes=null)
    {
        $iframeAttributes = self::getEmbedIframeAttributes($url);

        if (is_array($optionalAttributes)) {
            foreach($optionalAttributes as $name => $value)
                $iframeAttributes[$name] = $value;
        }

        $html = '<iframe ';
        foreach ($iframeAttributes as $name => $value) {
            if ($value === true)
                $html .= $name .' ';
            else
                $html .= $name . '="' . $value . '" ';
        }
        $html .= '></iframe>';

        return $html;
    }

    /**
     * Returns the html code for an embed responsive video, for a given url.
     * The url has to be either from:
     * - youtube
     * - daily motion
     * - vimeo
     *
     * Returns false in case of failure
     */
    public static function getEmbedIframeAttributes($url)
    {
        if ($id = self::getDailyMotionId($url)) {
            $attributes = [
                'src'                   => 'http://www.dailymotion.com/embed/video/' . $id,
                'frameborder'           => 0,
                'webkitAllowFullScreen' => true,
                'mozallowfullscreen'    => true,
                'allowFullScreen'       => true,
            ];
        }
        elseif ($id = self::getVimeoId($url)) {
            $attributes = [
                'src'                   => 'http://player.vimeo.com/video/' . $id,
                'frameborder'           => 0,
                'webkitAllowFullScreen' => true,
                'mozallowfullscreen'    => true,
                'allowFullScreen'       => true,
            ];
        }
        elseif ($id = self::getYoutubeId($url)) {
            $attributes = [
                'src'                   => 'http://www.youtube.com/embed/' . $id,
                'frameborder'           => 0,
                'allowFullScreen'       => true,
            ];
        }
        else if (self::isOtherUrl($url)) {
            $attributes = [
                'src'                   => $url,
                'frameborder'           => 0,
                'controls'              => true,
            ];
        }

        return $attributes;
    }

    /**/
}
