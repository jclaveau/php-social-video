<?php
namespace JClaveau\SocialVideo;

/**
 * This static class gathers tools to parse urls of videos shared through
 * social networks.
 */
class SocialVideo
{
    const DAILYMOTION = 'DailyMotion';
    const VIMEO       = 'Vimeo';
    const YOUTUBE     = 'Youtube';
    const FACEBOOK    = 'Facebook';

    /** @var array $enabledSocialNetworks */
    protected static $enabledSocialNetworks = [
        self::YOUTUBE     => true,
        self::DAILYMOTION => true,
        self::VIMEO       => true,
        self::FACEBOOK    => null,    // TODO support not implemented
    ];

    /**
     * Checks that the social network given as parameter is enabled
     *
     * @return bool Whether or not the support of videos from the social
     *              network is allowed.
     */
    public static function isNetworkEnabled($socialNetworkName)
    {
        return !empty(
            self::$enabledSocialNetworks[$socialNetworkName]
        );
    }

    /**
     * Enables the support of a social network.
     *
     * @param string $socialNetworkName The name of the social network
     *                                  to enable. It's recommended to
     *                                  use the constants of this class
     *                                  for maintability and better
     *                                  performances :
     *                                      + SocialVideo::DAILYMOTION
     *                                      + SocialVideo::YOUTUBE
     *                                      + SocialVideo::VIMEO
     *                                      + SocialVideo::FACEBOOK
     *
     * @throws InvalidArgumentException If the social network given as
     *                                  parameter doesn't exist.
     */
    public static function enableNetwork($socialNetworkName)
    {
        if (!isset(self::$enabledSocialNetworks[$socialNetworkName])) {
            throw new \InvalidArgumentException(
                 "The support of the social network you try to enable is "
                ."not implement: $socialNetworkName"
            );
        }

        self::$enabledSocialNetworks[$socialNetworkName] = true;
    }

    /**
     * Disables the support of a social network.
     *
     * @param string $socialNetworkName The name of the social network
     *                                  to disable. It's recommended to
     *                                  use the constants of this class
     *                                  for maintability and better
     *                                  performances :
     *                                      + SocialVideo::DAILYMOTION
     *                                      + SocialVideo::YOUTUBE
     *                                      + SocialVideo::VIMEO
     *                                      + SocialVideo::FACEBOOK
     *
     * @throws InvalidArgumentException If the social network given as
     *                                  parameter doesn't exist.
     */
    public static function disableNetwork($socialNetworkName)
    {
        if (!isset(self::$enabledSocialNetworks[$socialNetworkName])) {
            throw new \InvalidArgumentException(
                 "The support of the social network you try to enable is "
                ."not implement: $socialNetworkName"
            );
        }

        self::$enabledSocialNetworks[$socialNetworkName] = false;
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
     * Extracts the facebook id from a facebook url of a video or returns
     * null.
     *
     */
    public static function getFacebookId($url)
    {
        if (!self::isNetworkEnabled(self::FACEBOOK))
            return null;

        throw new \ErrorException("Facebook support not implemented yet");
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
     *
     * @return bool
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
     *      - youtube
     *      - daily motion
     *      - vimeo
     *
     * This function can be used for creating video sitemaps.
     *
     * @throws InvalidArgumentException If the $url parameter cannot be
     *                                  parsed.
     *
     * @return string The url of an embeded video in an iframe
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
        else if (self::isOtherUrl($url)) {
            return $url;
        }
        else {
            throw new \InvalidArgumentException("The $url parameter"
                ." doesn't seem to ve a valid URL" );
        }
    }

    /**
     * Returns the html code for an embed responsive video, for a given url.
     * The url has to be either from a enabled social network.
     *
     * @todo   Use video element for mp4?
     *
     * @param  string $url                The url of the video
     * @param  array  $optionalAttributes The attributes to add to the element.
     *
     * @return string The html element.
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
     * Generates the iframe attributes corresponding to a video URL.
     *
     * @param  string $url              The $url of the video to embed.
     * @throws InvalidArgumentException If the $url parameter cannot be
     *                                  parsed.
     *
     * @return array The HTML attributes for the iframe element.
     *
     * @todo   facebook
     */
    public static function getEmbedIframeAttributes($url)
    {
        if ($id = self::getYoutubeId($url)) {
            $attributes = [
                'src'                   => 'http://www.youtube.com/embed/' . $id,
                'frameborder'           => 0,
                'allowFullScreen'       => true,
            ];
        }
        elseif ($id = self::getDailyMotionId($url)) {
            $attributes = [
                'src'                   => 'http://www.dailymotion.com/embed/video/' . $id,
                'frameborder'           => 0,
                'webkitAllowFullScreen' => true,
                'mozallowfullscreen'    => true,
                'allowFullScreen'       => true,
            ];
        }
        elseif ($id = self::getFacebookId($url)) {

            // <iframe
            //      src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fjfprovencal%2Fvideos%2F1702184380077620%2F&show_text=0&width=560"
            //      width="560" height="315"
            //      style="border:none;overflow:hidden"
            //      scrolling="no"
            //      frameborder="0"
            //      allowTransparency="true"
            //      allowFullScreen="true"
            //      >
            // </iframe>

            $attributes = [
                'src'                   => 'https://www.facebook.com/plugins/video.php?href=' . $id,
                'frameborder'           => 0,
                'scrolling'             => "no",
                'style'                 => "border: none; overflow: hidden",
                'allowTransparency'     => true,
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
        else if (self::isOtherUrl($url)) {
            $attributes = [
                'src'                   => $url,
                'frameborder'           => 0,
                'controls'              => true,
            ];
        }
        else {
            throw new \InvalidArgumentException("The $url parameter"
                ." doesn't seem to ve a valid URL" );
        }

        return $attributes;
    }

    /**/
}
