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

    /******************************************************/
    /*                   post method                      */
    /* -------------------------------------------------- */
    /* $pages_id     : id from your facebook pages        */
    /* $message      : write what you want to post        */
    /* $link         : if you want to post include links  */
    /* $photo        : if you want to post include photos */
    /* $video        : if you want to post include videos */
    /* $published    : decide that publish now or later   */
    /* $publish_time : decide that publish time           */
    /* -------------------------------------------------- */
    /******************************************************/

    public function post(
        $pages_id,
        $message,
        $link = null,
        $photo = null,
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
            'url' => $photo,
            'published' => $published,
            'scheduled_publish_time' => $publish_time,
        ];

        if ($photo) {

            $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $pages_id . '/photos'
                , $prams
                , $body
                , $header);

        } else {

            $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $pages_id . '/feed'
                , $prams
                , $body
                , $header);

        }

        return $result;

    }

    /***************************************************************/
    /*                         reply method                        */
    /* ----------------------------------------------------------- */
    /* $type     : comments, private_replies(Permissions problems) */
    /* $page_id  : the post's id                                   */
    /* $message  : write what you want to reply                    */
    /* ----------------------------------------------------------- */
    /***************************************************************/

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

    /**************************************************/
    /*                 autoReply method               */
    /* ---------------------------------------------- */
    /* $type_reply : comments, private_replies        */
    /* $page_id    : the post's id                    */
    /* $hears      : keyword that start to reply      */
    /* $reply      : write what you want to reply     */
    /* ---------------------------------------------- */
    /**************************************************/

    public function autoReply(
        $type_reply,
        $page_id,
        $hears,
        $reply,
        $repeat = true
    ) {

        $publish_id = [];

        $comment_repeat = true;

        $publish_list = $this->get($page_id, 'comments');

        $publish_comments = json_decode($publish_list->getContent())->data;

        if ($publish_comments) {

            $publish_last = $publish_comments[count($publish_comments) - 1];

            $comment_replies = json_decode($this->get($publish_last->id, 'comments')->getContent())->data;

            foreach ($publish_comments as $publish_comment) {

                $publish_id[] = array_push($publish_id, $publish_comment->from->id);

            }

            if ($comment_replies) {

                foreach ($comment_replies as $comment_reply) {

                    if ($repeat) {

                        if ($comment_reply->from->id === substr($page_id, 0, 15)) {

                            $comment_repeat = false;

                        }

                    }

                }
            }

            if (array_unique($publish_id) === $publish_id) {

                if ($hears === $publish_last->message && $comment_repeat) {

                    $this->reply($type_reply, $publish_last->id, $reply);

                }

            }

        }

    }

    /****************************************************/
    /*                    get method                    */
    /* ------------------------------------------------ */
    /* $page_id  : the post's id                        */
    /* $type     : get information from pages or posts  */
    /* ------------------------------------------------ */
    /****************************************************/

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

    /*********************************************/
    /*            finishPost method              */
    /* ----------------------------------------- */
    /* $post_id  : the post's id                 */
    /* ----------------------------------------- */
    /*********************************************/

    public function finishPost($post_id)
    {
        $prams = [
            'access_token' => env('FACEBOOK_TOKEN'),
        ];

        $header = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'is_published' => true,
        ];

        $result = $this->curl->post('https://graph.facebook.com/v2.11/' . $post_id
            , $prams
            , $body
            , $header);

        return $result;
    }
}
