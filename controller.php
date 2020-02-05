<?php
include "config.php";

function controller($url) {
    $urlCompare = strtolower($url);
    if (strpos($urlCompare, "youtube.com")) {
        $yd = new Youtube();
        $yd->setUrl($url);
        return $yd->getMediaInfo();
    } elseif (strpos($urlCompare, "dailymotion.com")) {
        $dd = new Dailymotion();
        $dd->setUrl($url);
        return $dd->getMediaInfo();
    } elseif (strpos($urlCompare, "facebook.com")) {
        $fd = new Facebook();
        $fd->setUrl($url);
        return $fd->getMediaInfo();
    } elseif (strpos($urlCompare, "vimeo.com")) {
        $vd = new Vimeo();
        $vd->setUrl($url);
        return $vd->getMediaInfo();
    } else {
        return null;
    }

}