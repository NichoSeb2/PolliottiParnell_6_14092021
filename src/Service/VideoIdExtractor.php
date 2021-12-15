<?php

namespace App\Service;

class VideoIdExtractor {
    public const VIDEO_URL_REGEX = "/https?:\/\/([a-z]*\.)?((youtu(be)?)|(vimeo))\.[a-z]*\//";

	public function getYoutubeId(string $url): ?string {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=embed/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);

        return isset($matches[0]) ? $matches[0] : null;
    }

    public function getYoutubeThumbnail(string $id): string {
        return "https://img.youtube.com/vi/$id/maxresdefault.jpg";
    }

    public function getYoutubeTitle(string $id): string {
        $data = explode(' - YouTube', explode('</title>', explode('<title>', file_get_contents("https://www.youtube.com/watch?v=$id"))[1])[0])[0];

        $title = html_entity_decode($data, ENT_QUOTES | ENT_HTML5);

        return $title;
    }

    private function _getVimeoData(string $id): object {
        $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
        $data = json_decode($data);

        return $data[0];
    }

    public function getVimeoId(string $url): ?string {
        preg_match("#(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?#", $url, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function getVimeoThumbnail(string $id): string {
        return $this->_getVimeoData($id)->thumbnail_large;
    }

    public function getVimeoTitle(string $id): string {
        return $this->_getVimeoData($id)->title;
    }
}
