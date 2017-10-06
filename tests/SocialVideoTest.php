<?php
use JClaveau\SocialVideo\SocialVideo;
use JClaveau\VisibilityViolator\VisibilityViolator;

class SocialVideoTest extends PHPUnit_Framework_TestCase
{
    protected $allNetworks = [
        SocialVideo::DAILYMOTION,
        SocialVideo::FACEBOOK,
        SocialVideo::YOUTUBE,
        SocialVideo::TWITCH,
        SocialVideo::VIMEO,
    ];

    protected $validUrls = [
        SocialVideo::YOUTUBE => [
            'nCwRJUg3tcQ' => [
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
            ],
        ],
        SocialVideo::VIMEO => [
            '87973054' => [
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
            ],
            null => [
                'http://vimeo.com/videoschool',
                'http://vimeo.com/videoschool/archive/behind_the_scenes',
                'http://vimeo.com/forums/screening_room',
                'http://vimeo.com/forums/screening_room/topic:42708',
            ],
        ],
        SocialVideo::DAILYMOTION => [
            'x2jvvep' => [
                'http://www.dailymotion.com/video/x2jvvep_coup-incroyable-pendant-un-match-de-ping-pong_tv',
                'http://www.dailymotion.com/video/x2jvvep_rates-of-exchange-like-a-renegade_music',
                'http://www.dailymotion.com/video/x2jvvep',
                'http://www.dailymotion.com/hub/x2jvvep_Galatasaray',
                'http://www.dailymotion.com/hub/x2jvvep_Galatasaray#video=x2jvvep',
                'http://www.dailymotion.com/video/x2jvvep_hakan-yukur-klip_sport',
                'http://dai.ly/x2jvvep',
            ],
        ],
        SocialVideo::FACEBOOK => [
            '1833607506657400' => [
                'https://www.facebook.com/unjouruncochon/videos/1833607506657400/',
            ],
        ],
        SocialVideo::TWITCH => [
        ],
    ];



    public static function setUpBeforeClass()
    {
        //
        // ini_set('xdebug.max_nesting_level', 10000);
    }

    /**
     * Test the the enabling of a social network support
     */
    public function test_enableNetwork()
    {
        $saved = VisibilityViolator::getHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks'
        );

        // not implemented
        VisibilityViolator::setHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks',
            [
                SocialVideo::DAILYMOTION => null,
            ]
        );

        try {
            SocialVideo::enableNetwork( SocialVideo::DAILYMOTION );
        }
        catch (\JClaveau\SocialVideo\NotImplementedException $e) {
            $this->assertEquals(
                $e->getMessage(),
                "The support of the social network you try to enable is "
                ."not implement: ".SocialVideo::DAILYMOTION
            );
        }

        // disabled
        VisibilityViolator::setHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks',
            [
                SocialVideo::DAILYMOTION => false,
            ]
        );

        SocialVideo::enableNetwork( SocialVideo::DAILYMOTION );

        $enabledSocialNetworks = VisibilityViolator::getHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks'
        );

        $this->assertEquals( $enabledSocialNetworks, [
            SocialVideo::DAILYMOTION => true,
        ]);

        // restore
        VisibilityViolator::setHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks',
            $saved
        );
    }

    /**
     * Test the the disabling of a social network support
     */
    public function test_disableNetwork()
    {
        $saved = VisibilityViolator::getHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks'
        );

        // not implemented
        VisibilityViolator::setHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks',
            [
                SocialVideo::DAILYMOTION => null,
            ]
        );

        try {
            SocialVideo::disableNetwork( SocialVideo::DAILYMOTION );
        }
        catch (\JClaveau\SocialVideo\NotImplementedException $e) {
            $this->assertEquals(
                $e->getMessage(),
                "The support of the social network you try to enable is "
                ."not implement: ".SocialVideo::DAILYMOTION
            );
        }

        // enabled
        VisibilityViolator::setHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks',
            [
                SocialVideo::DAILYMOTION => true,
            ]
        );

        SocialVideo::disableNetwork( SocialVideo::DAILYMOTION );

        $enabledSocialNetworks = VisibilityViolator::getHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks'
        );

        $this->assertEquals( $enabledSocialNetworks, [
            SocialVideo::DAILYMOTION => false,
        ]);

        // restore
        VisibilityViolator::setHiddenProperty(
            'JClaveau\SocialVideo\SocialVideo',
            'enabledSocialNetworks',
            $saved
        );
    }

    /**
     * Test the check of the enabling of a social network support
     */
    public function test_isNetworkEnabled()
    {
        SocialVideo::enableNetwork( SocialVideo::YOUTUBE );

        $this->assertTrue(
            SocialVideo::isNetworkEnabled( SocialVideo::YOUTUBE )
        );

        SocialVideo::disableNetwork( SocialVideo::VIMEO );

        $this->assertFalse(
            SocialVideo::isNetworkEnabled( SocialVideo::VIMEO )
        );
    }

    /**
     * Prepare sets of test parameters for id retrieval methods.
     *
     * @param  string The name of the tested social network
     * @return array  The parameters
     */
    public function combineTestUrlsFor($socialNetworkName)
    {
        $test_parameters_sets = [];

        foreach ($this->validUrls[ $socialNetworkName ] as $expected_id => $urls) {
            foreach ($urls as $url)
                $test_parameters_sets[] = [$url, $expected_id];
        }

        $others_networks = array_diff($this->allNetworks, [$socialNetworkName]);

        foreach ($others_networks as $others_network) {
            foreach ($this->validUrls[ $others_network ] as $expected_id => $urls) {
                foreach ($urls as $url)
                    $test_parameters_sets[] = [$url, null];
            }
        }

        return $test_parameters_sets;
    }

    /**
     * Set of arguments for test_getVimeoId().
     *
     * @return array The parameters
     */
    public function test_getVimeoId_dataProvider()
    {
        return $this->combineTestUrlsFor( SocialVideo::VIMEO );
    }

    /**
     * Test the extraction of ids from Vimeo urls.
     *
     * @param string An example Vimeo URL
     *
     * @dataProvider test_getVimeoId_dataProvider
     */
    public function test_getVimeoId($url, $expected_id)
    {
        $id = SocialVideo::getVimeoId($url);
        $this->assertEquals($expected_id, $id);
    }

    /**
     * Set of arguments for test_getYoutubeId().
     *
     * @return array The parameters
     */
    public function test_getYoutubeId_dataProvider()
    {
        return $this->combineTestUrlsFor( SocialVideo::YOUTUBE );
    }

    /**
     * Test the extraction of ids from Youtube urls.
     *
     * @param string An example Youtube URL
     *
     * @dataProvider test_getYoutubeId_dataProvider
     */
    public function test_getYoutubeId($url, $expected_id)
    {
        $id = SocialVideo::getYoutubeId($url);
        $this->assertEquals($expected_id, $id);
    }

    /**
     * Set of arguments for test_getDailyMotionId().
     *
     * @return array The parameters
     */
    public function test_getDailyMotionId_dataProvider()
    {
        return $this->combineTestUrlsFor( SocialVideo::DAILYMOTION );
    }

    /**
     * Test the extraction of ids from DailyMotion urls.
     *
     * @param string An example DailyMotion URL
     *
     * @dataProvider test_getDailyMotionId_dataProvider
     */
    public function test_getDailyMotionId($url, $expected_id)
    {
        $id = SocialVideo::getDailyMotionId($url);
        $this->assertEquals($expected_id, $id);
    }

    /**
     * Set of arguments for test_getFacebookId().
     *
     * @return array The parameters
     */
    public function test_getFacebookId_dataProvider()
    {
        return $this->combineTestUrlsFor( SocialVideo::FACEBOOK );
    }

    /**
     * Test the extraction of ids from Facebook urls.
     *
     * @param string An example Facebook URL
     *
     * @expectedException \JClaveau\SocialVideo\NotImplementedException
     *
     * @dataProvider test_getFacebookId_dataProvider
     */
    public function test_getFacebookId($url, $expected_id)
    {
        SocialVideo::enableNetwork( SocialVideo::FACEBOOK );
        // $this->expectException( InvalidArgumentException::class );
        $id = SocialVideo::getFacebookId($url);
        $this->assertEquals($expected_id, $id);
    }

    /**
     * Set of arguments for getEmbedVideo().
     *
     * @return array The parameters
     * /
    public function test_getEmbedVideo_dataProvider()
    {
        $urls = [
            '/video/babla.mp4',
            '/medias/models/Campaign_Native/891/url_video/979/2017-08-29_moi_je_me_la_pete?_.mp4',
        ];

        $test_parameters = [];
        foreach ($urls as $url) {
            $test_parameters[] = [
                $url
            ];
        }

        return $test_parameters;
    }

    /**
     * Test the extraction of ids from local urls.
     *
     * @param string An example local URL
     *
     * @dataProvider test_getEmbedVideo_dataProvider
     * /
    public function test_getEmbedVideo($url)
    {
        $id = SocialVideo::getEmbedVideo($url);
        $this->assertNotEquals(null, $id);
    }

    /**/
}



return;




echo "\n\n\n";
echo "Thumbnails\n";
$mixed = array_merge($vimeo, $youtube, $dailymotion);


foreach ($mixed as $url) {
    $thumb_src = SocialVideo::getVideoThumbnailByUrl($url);
    echo 'Thumb: ' . $thumb_src ."\n";
    echo 'Location: ' . SocialVideo::getVideoLocation($url) ."\n";
}
