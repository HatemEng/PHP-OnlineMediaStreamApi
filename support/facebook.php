<?php
/**
 * Created by PhpStorm.
 * User: Hatem En
 * Date: 11/11/2018
 * Time: 4:48 PM
 */

class Facebook
{
    private $format = array(
        0 => "SD Quality",
        1 => "HD Quality"
    );

    private $url;

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    function getMediaInfo() {
        $helper = new helper();
        $page = $helper->getPage($this->url);
        $info = array();
        $media = new Media();
        $index = 0;
        $media->url = $this->sd_link($page);
        if ($media->url != null) {
            $media->format = $this->format[0];
            $info[$index] = $media;
            $index ++;
        }

        $media = new Media();
        $media->url = $this->hd_link($page);
        if ($media->url != null) {
            $media->format = $this->format[1];
            $info[$index] = $media;
        }

        return $info;
    }


    function hd_link($curl_content)
    {
        $regex = '/hd_src_no_ratelimit:"([^"]+)"/';
        if (preg_match($regex, $curl_content, $match)) {
            return $match[1];
        }
        return null;
    }

    function sd_link($curl_content)
    {
        $regex = '/sd_src_no_ratelimit:"([^"]+)"/';
        if (preg_match($regex, $curl_content, $match)) {
            return $match[1];
        } else {
            $mobil_link = $this->mobil_link($curl_content);
            if (!empty($mobil_link)) {
                return $mobil_link;
            }
        }
        return null;
    }

    function mobil_link($curl_content)
    {
        $regex = '@&quot;https:(.*?)&quot;,&quot;@si';
        if (preg_match_all($regex, $curl_content, $match)) {
            return $match[1][0];
        }
        return null;
    }
}