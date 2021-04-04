<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/video-url-parser/vendor/autoload.php';

use RicardoFiorani\Matcher\VideoServiceMatcher;

class Video_model extends CI_Model
{

    //get video embed code
    public function get_video_embed_code($url)
    {
        try {
            $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($url);
            return $video->getEmbedUrl();
        } catch (\RicardoFiorani\Exception\NotEmbeddableException $e) {
            return null;
        }
    }

    //get video thumbnail
    public function get_video_thumbnail($url)
    {
        try {
            $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($url);
            $thumbnail = $video->getLargestThumbnail();
            if (empty($thumbnail)) {
                $thumbnail = $video->getSmallThumbnail();
            }
            return $thumbnail;
        } catch (\RicardoFiorani\Exception\NotEmbeddableException $e) {
            return null;
        }
    }
}