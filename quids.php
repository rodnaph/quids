<?php

list($SCRIPT, $title) = $_SERVER['argv'];

if (!$title) {
    echo "Usage: php quids.php The-Video-Url-Title";
    exit(1);
}

$req = new HttpRequest();

$req->setHeaders(
    array(
        'User-Agent' => 'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10'
    )
);

$req->setUrl(
    sprintf(
        'http://www.infoq.com/presentations/%s',
        urlencode($title)
    )
);

$res = $req->send();
$body = $res->getBody();

if (preg_match('/http:\/\/.*?.mp4/', $body, $matches)) {

    list($videoUrl) = $matches;

    $cmd = sprintf(
        'curl -O %s',
        $videoUrl
    );

    passthru($cmd);

} else {
    echo "Cannot find video URL! :(\n";
    exit(1);
}

