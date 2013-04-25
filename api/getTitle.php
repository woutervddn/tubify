<?php

function getTitle($Url){
    $str = file_get_contents($Url);
    if(strlen($str)>0){
        preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
        return $title[1];
    }
}

echo getTitle("https://embed.spotify.com/?uri=".$_REQUEST['uri']);
?>
