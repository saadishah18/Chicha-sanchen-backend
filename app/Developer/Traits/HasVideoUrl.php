<?php


namespace App\Developer\Traits;


trait HasVideoUrl
{
    public function getVideoUrlFromContent()
    {
        $videoUrl = null;
        if(!empty($this->content)&&(strpos($this->content, 'twitter')>0)){
            $new_uri       = str_replace('https://', '', $this->content);
            $twitters_urls = explode('/', $new_uri);
            $twitter_id    = end($twitters_urls);
            $videoUrl = 'https://twitter.com/i/videos/'.$twitter_id;
        }else if(!empty($videoItem->content)&&(strpos($videoItem->content, 'instagram')>0)){
            $new_uri     = str_replace('https://', '', $videoItem->content);
            $insta_urls  = explode('/', $new_uri);
            $uri_segment = !empty($insta_urls[2])?$insta_urls[2]:'';
            if(!empty($uri_segment)){
                $data        = file_get_contents('https://www.instagram.com/p/'.$uri_segment.'/?__a=1');
                $video_urls  = json_decode($data);
                if(!empty($video_urls)){
                    $videoUrl = get_instagram_video_url($video_urls);
                }
            }
        }

        if(empty($videoUrl)){
            $video = json_decode($this->video_content);
            if(isset($video->iframe) && !empty($video->iframe)){
                preg_match('/src="([^"]+)"/', $video->iframe, $match);
                $url = $match[1];
                $videoUrl = $url;

            }else{
                //show image with video button
            }
        }

        return $videoUrl;
    }
}
