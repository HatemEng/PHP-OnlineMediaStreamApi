<?php
/**
 * Created by PhpStorm.
 * User: Hatem En
 * Date: 11/10/2018
 * Time: 9:21 PM
 */

class Youtube
{
    private $url;
    private $itags = array(

        5  => "FLV, 240p",
        6  => "FLV, 270p",
        13 => "3GP, (Mobile phones, iPod friendly)",
        17 => "3GP, 144p",
        18 => "MP4, Medium Quality [360p]",
        22 => "MP4, HD High Quality [720p]",
        34 => "FLV, 360p",
        35 => "FLV, 480p",
        36 => "3GP, 240p",
        37 => "MP4, HD High Quality [1080p]",
        38 => "MP4, HD High Quality [3072p]",
        43 => "WEBM, Medium Quality [360p]",
        44 => "WEBM, 480p",
        45 => "WEBM, 720p",
        46 => "WEBM, 1080p",
        // questionable MP4s
        59 => "MP4, 480p",
        78 => "MP4, 480p"

    );


    public function setUrl($url) {
        $this->url = $url;
    }

    public function getMediaInfo() {
       $helper = new helper();
       $page = $helper->getPage($this->url);
       $info = array();
        if(preg_match('@url_encoded_fmt_stream_map["\']:\s*["\']([^"\'\s]*)@', $page, $matches)) {
            $parts = explode(",", $matches[1]);
            foreach ($parts as $index => $p) {
                $query = str_replace('\u0026', '&', $p);
                parse_str($query, $arr);
                $media = new Media();
                /*$media = array();
                $media['url'] = $arr['url'];
                $media['format'] = $this->itags[$arr['itag']];
                $media['type'] = $arr['type'];*/
                $media->url = $arr['url'];
                $media->format = $this->itags[$arr['itag']];
                $media->more = $arr['type'];
                $info[$index] = $media;
            }

        }
        return $info;
    }
}