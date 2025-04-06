<?php

/**
 * Troca a url do Youtube pelo ID do vídeo
 * @param string URL do vídeo no Youtube
 *
 * @return string ID do vídeo
 */
function returnYoutubeId($url) {
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    $idYoutube = $matches[1];
    return $idYoutube;
}

?>