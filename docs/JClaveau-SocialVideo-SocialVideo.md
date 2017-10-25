JClaveau\SocialVideo\SocialVideo
===============

This static class gathers tools to parse urls of videos shared through
social networks.




* Class name: SocialVideo
* Namespace: JClaveau\SocialVideo



Constants
----------


### DAILYMOTION

    const DAILYMOTION = 'DailyMotion'





### VIMEO

    const VIMEO = 'Vimeo'





### YOUTUBE

    const YOUTUBE = 'Youtube'





### FACEBOOK

    const FACEBOOK = 'Facebook'





### TWITCH

    const TWITCH = 'Twitch'





### KOREUS

    const KOREUS = 'Koreus'





Properties
----------


### $enabledSocialNetworks

    protected array $enabledSocialNetworks = array(self::YOUTUBE => true, self::DAILYMOTION => true, self::VIMEO => true, self::FACEBOOK => null, self::TWITCH => null)





* Visibility: **protected**
* This property is **static**.


Methods
-------


### listKnownNetworks

    array JClaveau\SocialVideo\SocialVideo::listKnownNetworks()

Lists all the networks known by this api.



* Visibility: **public**
* This method is **static**.




### listEnabledNetworks

    array JClaveau\SocialVideo\SocialVideo::listEnabledNetworks()

Lists all the enabled networks of this api.



* Visibility: **public**
* This method is **static**.




### isNetworkEnabled

    boolean JClaveau\SocialVideo\SocialVideo::isNetworkEnabled($socialNetworkName)

Checks that the social network given as parameter is enabled



* Visibility: **public**
* This method is **static**.


#### Arguments
* $socialNetworkName **mixed**



### enableNetwork

    mixed JClaveau\SocialVideo\SocialVideo::enableNetwork(string $socialNetworkName)

Enables the support of a social network.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $socialNetworkName **string** - &lt;p&gt;The name of the social network
to enable. It&#039;s recommended to
use the constants of this class
for maintability and better
performances :&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;SocialVideo::DAILYMOTION&lt;/li&gt;
&lt;li&gt;SocialVideo::YOUTUBE&lt;/li&gt;
&lt;li&gt;SocialVideo::VIMEO&lt;/li&gt;
&lt;li&gt;SocialVideo::FACEBOOK&lt;/li&gt;
&lt;/ul&gt;



### disableNetwork

    mixed JClaveau\SocialVideo\SocialVideo::disableNetwork(string $socialNetworkName)

Disables the support of a social network.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $socialNetworkName **string** - &lt;p&gt;The name of the social network
to disable. It&#039;s recommended to
use the constants of this class
for maintability and better
performances :&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;SocialVideo::DAILYMOTION&lt;/li&gt;
&lt;li&gt;SocialVideo::YOUTUBE&lt;/li&gt;
&lt;li&gt;SocialVideo::VIMEO&lt;/li&gt;
&lt;li&gt;SocialVideo::FACEBOOK&lt;/li&gt;
&lt;/ul&gt;



### getDailyMotionId

    string|null JClaveau\SocialVideo\SocialVideo::getDailyMotionId(string $url)

Extracts the daily motion id from a daily motion url or returns null.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **string**



### getVimeoId

    string|null JClaveau\SocialVideo\SocialVideo::getVimeoId(string $url)

Extracts the vimeo id from a vimeo url or returns null.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **string**



### getYoutubeId

    string|null JClaveau\SocialVideo\SocialVideo::getYoutubeId(string $url)

Extracts the youtube id from a youtube url  or returns null.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **string**



### getFacebookId

    string|null JClaveau\SocialVideo\SocialVideo::getFacebookId(string $url)

Extracts the facebook id from a facebook url of a video or returns
null.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **string**



### isOtherUrl

    boolean JClaveau\SocialVideo\SocialVideo::isOtherUrl($url)

Returns true if the url is valid which means it could be a simple
video file uploaded somewhere.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**



### isLocalUrl

    boolean JClaveau\SocialVideo\SocialVideo::isLocalUrl($url)

Returns true if the url is valid which means it could be a simple
video file uploaded somewhere.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**



### isSocialVideo

    boolean JClaveau\SocialVideo\SocialVideo::isSocialVideo($url)

Returns true if the url is valid which means it could be a simple
video file uploaded somewhere.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**



### getVideoThumbnailByUrl

    mixed JClaveau\SocialVideo\SocialVideo::getVideoThumbnailByUrl($url, $format)

Gets the thumbnail url associated with an url from either:

- youtube
     - daily motion
     - vimeo

Returns false if the url couldn't be identified.

In the case of you tube, we can use the second parameter (format), which
takes one of the following values:
     - small         (returns the url for a small thumbnail)
     - medium        (returns the url for a medium thumbnail)

* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**
* $format **mixed**



### getEmbededVideoLocation

    string JClaveau\SocialVideo\SocialVideo::getEmbededVideoLocation($url)

Returns the location of the actual video for a given url which belongs to either:
     - youtube
     - daily motion
     - vimeo

This function can be used for creating video sitemaps.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**



### getEmbededDailyMotionVideoLocation

    string JClaveau\SocialVideo\SocialVideo::getEmbededDailyMotionVideoLocation($id)

Generates the url of an embeded video from DailyMotion.



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $id **mixed**



### getEmbededVimeoVideoLocation

    string JClaveau\SocialVideo\SocialVideo::getEmbededVimeoVideoLocation($id)

Generates the url of an embeded video from Vimeo.



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $id **mixed**



### getEmbededYoutubeVideoLocation

    string JClaveau\SocialVideo\SocialVideo::getEmbededYoutubeVideoLocation($id)

Generates the url of an embeded video from Youtube.



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $id **mixed**



### getEmbededFacebookVideoLocation

    string JClaveau\SocialVideo\SocialVideo::getEmbededFacebookVideoLocation($id)

Generates the url of an embeded video from Facebook.



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $id **mixed**



### getEmbedVideoHtml

    string JClaveau\SocialVideo\SocialVideo::getEmbedVideoHtml(string $url, array $optionalAttributes)

Returns the html code for an embed responsive video, for a given url.

The url has to be either from a enabled social network.

* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **string** - &lt;p&gt;The url of the video&lt;/p&gt;
* $optionalAttributes **array** - &lt;p&gt;The attributes to add to the element.&lt;/p&gt;



### getEmbedIframeAttributes

    array JClaveau\SocialVideo\SocialVideo::getEmbedIframeAttributes(string $url)

Generates the iframe attributes corresponding to a video URL.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **string** - &lt;p&gt;The $url of the video to embed.&lt;/p&gt;


