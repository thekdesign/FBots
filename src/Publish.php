<?php

namespace ThekDesign\FBots;


use BotMan\BotMan\Http\Curl;

class Publish
{

    private $curl, $access_token;

    public function __construct($access_token)
    {
        $this->curl = new Curl();

	    $this->access_token = $access_token;

    }

    public function post(
        $pages_id,
        $message,
        $link = null,
        $photos = null,
        $video = null,
        $published = true,
        $publish_time = null
    ) {

        $prams = [
            'access_token' => $this->access_token,
        ];

        $header = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'message' => $message,
            'link' => $link,
            'photos' => $photos,
            'video' => $video,
            'published' => $published,
            'scheduled_publish_time' => $publish_time,
        ];

        $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $pages_id . '/feed'
            , $prams
            , $body
            , $header);

        return $result;

    }

    public function reply(
        $type,
        $page_id,
        $message
    ) {

        $prams = [
            'access_token' => $this->access_token,
        ];

        $header = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'message' => $message,
        ];

        $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $page_id . '/' . $type
            , $prams
            , $body
            , $header);

        return $result;
    }

    public function get($page_id , $type = '')
    {
        $prams = [
            'access_token' => $this->access_token,
        ];

        $header = [
            'Content-Type' => 'application/json',
        ];

        $result = $this->curl->get('https://graph.facebook.com/v2.11/' . $page_id . '/' . $type
            ,$prams
            ,$header);

        return $result;
    }
}
