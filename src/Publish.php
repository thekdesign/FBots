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
        $message,
        $link = null,
        $photos = null,
        $video = null,
        $published = true,
        $publish_time = null
    ) {

        $prams = [
            'access_token' => env('FACEBOOK_TOKEN'),
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
            'access_token' => env('FACEBOOK_TOKEN'),
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

    public function autoReply(
        $type_reply,
        $page_id,
        $hears,
        $reply
    ) {

        $id = [];

        $publish_list = $this->get($page_id, 'comments');

        $publish_comments = json_decode($publish_list->getContent())->data;

        $comment = $publish_comments[count($publish_comments) - 1];

        foreach ($publish_comments as $publish_comment) {

            $id[] = array_push($id, $publish_comment->from->id);

        }

        if (array_unique($id) === $id) {

            if ($hears === $comment->message) {

                $this->reply($type_reply, $comment->id, $reply);

            }

        }

    }

    public function get($page_id, $type = '')
    {
        $prams = [
            'access_token' => env('FACEBOOK_TOKEN'),
        ];

        $header = [
            'Content-Type' => 'application/json',
        ];

        $result = $this->curl->get('https://graph.facebook.com/v2.11/' . $page_id . '/' . $type
            , $prams
            , $header);

        return $result;
    }
}
