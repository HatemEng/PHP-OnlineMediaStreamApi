<?php
/**
 * Created by PhpStorm.
 * User: Hatem En
 * Date: 11/11/2018
 * Time: 8:32 PM
 */

class Dailymotion
{
    private $url;
    private $format = array(
        "H264-176x144-2" => "MP4, 144p",
        "H264-320x240" => "MP4, 240p",
        "H264-512x384" => "MP4, 380p",
        "H264-848x480" => "MP4, 480p",
        "H264-1280x720" => "MP4, 720p"

    );
    public function setUrl($url) {
        $newUrl = substr($url, strrpos($url, '/')+1);
        if (strpos($newUrl, '?')) $newUrl = substr($newUrl, 0, strrpos($newUrl, '?'));
        $newUrl = "https://www.dailymotion.com/embed/video/" . $newUrl;
        $this->url = $newUrl;
    }
    public function getMediaInfo() {
        $helper = new Helper();
        $page = $helper->getPage($this->url);
        if ($page != null) {
            preg_match_all('@"qualities":(.*?)"tracking"@si', $page, $extracted);
            if ($extracted != null) {
                preg_match_all('@"url":"(.*?)"@si', $extracted[0][0], $address_links);

                $info = array();
                $index = 0;
                foreach ($address_links[1] as $link){
                    $format = $this->getFormat($link);
                    if ($format != 'manifest') {
                        $media = new Media();
                        $media->url     = $link;
                        $media->format  = $this->format[$format];
                        $media->more    = $format;
                        $info[$index] = $media;
                        $index ++;
                    }

                }
                return $info;
            }
        }

        return null;

    }

    public function getFormat($link) {
        $str = substr($link, strpos($link, 'cdn\/') + 5);
        $format = substr($str,0, strpos($str, '\/'));
        return $format;
    }
}