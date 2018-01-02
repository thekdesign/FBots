<?php

namespace ThekDesign\FBots;


use BotMan\BotMan\Http\Curl;

class Publish
{

    private $curl;

    public function __construct()
    {
        $this->curl = new Curl();

    }

    public function post(
        $pages_id,
        $access_token,
        $message,
        $link = null,
        $photos = null,
        $video = null,
        $published = true,
        $publish_time = null
    ) {

        $header = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'access_token' => $access_token,
            'message' => $message,
            'link' => $link,
            'photos' => $photos,
            'video' => $video,
            'published' => $published,
            'scheduled_publish_time' => $publish_time
        ];

        $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $pages_id . '/feed'
            , []
            , $body
            , $header);

        return $result;

    }

    public function reply(
        $type,
        $page_id,
        $access_token,
        $message
    ) {

        $header = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'access_token' => $access_token,
            'message' => $message,
        ];

        $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $page_id . '/' . $type
            , []
            , $body
            , $header);

        return $result;
    }

    public function get($page_id, $type = '')
    {
        $result = $this->curl->get('https://www.facebook.com/' . $page_id . '/' . $type);

        return $result;
    }
}