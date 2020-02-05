<?php
/**
 * Created by PhpStorm.
 * User: Hatem En
 * Date: 12/4/2018
 * Time: 3:14 PM
 */

class Vimeo
{

    private $url;

    private $format = array(
        "270p" => array("order" => "1", "height" => "270", "ext" => "mp4", "resolution" => "270p", "video" => "true", "video_only" => "false"),
        "360p" => array("order" => "2", "height" => "360", "ext" => "mp4", "resolution" => "360p", "video" => "true", "video_only" => "false"),
        "540p" => array("order" => "3", "height" => "540", "ext" => "mp4", "resolution" => "540p", "video" => "true", "video_only" => "false"),
        "720p" => array("order" => "4", "height" => "720", "ext" => "mp4", "resolution" => "720p", "video" => "true", "video_only" => "false"),
        "1080p" => array("order" => "5", "height" => "1080", "ext" => "mp4", "resolution" => "1080p", "video" => "true", "video_only" => "false")
        );

    private $helper;

    public function __construct()
    {
        $this->helper = new helper();
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $id = $this->helper->getId($url);
        $this->url = 'https://player.vimeo.com/video/' . $id;
    }


    public function getMediaInfo() {
        $page = $this->helper->getPage($this->url);
        $video_formats_data = $this->helper->get_string_between($page, '"request":{"files":', ',"lang":"en"');
        $video_formats_data = json_decode($video_formats_data, true);
        $videoStreams = $video_formats_data['progressive'];
        $info = array();
        foreach ($videoStreams as $stream) {
            $formatId = $stream['quality'];
            if (array_key_exists($formatId, $this->format)) {
                $media          = new Media();
                $media->format  = 'MP4, ' . $formatId;
                $media->url     = $stream['url'];
                $media->more    = $this->format[$formatId];
                array_push($info, $media);
            }
        }
        return $info;
    }
}