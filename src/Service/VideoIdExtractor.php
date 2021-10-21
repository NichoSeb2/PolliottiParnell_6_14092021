<?php

namespace App\Service;

class VideoIdExtractor {
	public function getYoutubeId(string $url): ?string {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=embed/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);

        return isset($matches[0]) ? $matches[0] : null;
    }

    public function getVimeoId(string $url): ?string {
        preg_match("#(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?#", $url, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }
}
