<?php
/**
 * Created by PhpStorm.
 * User: Hatem En
 * Date: 11/10/2018
 * Time: 9:27 PM
 */

class Helper
{


    public function getPage($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }


    public function clear_html($content)
    {
        # code...
        $content = str_replace("/", "", $content);
        $content = str_replace("&quot;", '"', $content);
        return $content;
    }

    function unshorten($url, $max_redirs = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, $max_redirs);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Niche Office Link Checker 1.0');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return $url;
    }


    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function getId($url) {
        $id = substr($url, strrpos($url, '/')+1);
        if (strpos($url, '?')) $id = substr($url, 0, strrpos($url, '?'));
        return $id;
    }



}