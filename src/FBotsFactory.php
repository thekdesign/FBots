<?php

namespace ThekDesign\FBots;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
use Illuminate\Http\Request;

class FBotsFactory
{

    public function __construct()
    {
        //
    }

    public static function create(Request $request)
    {

        /*************************************************************/
        /*                            config                         */
        /* --------------------------------------------------------- */
        /* token         : facebook page's access_token              */
        /* app_secret    : application's secret                      */
        /* verification  : to connect webhook, so it depends on you  */
        /* --------------------------------------------------------- */
        /*************************************************************/

        $config = [
            'facebook' => [
                'token' => env('FACEBOOK_TOKEN'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'verification' => env('FACEBOOK_VERIFICATION'),
            ]
        ];

        // registered facebook driver
        DriverManager::loadDriver(FacebookDriver::class);


        // create the bots
        $botman = BotManFactory::create($config, new LaravelCache(), $request);

        // load facebook driver
        $botman->loadDriver(FacebookDriver::class);

        return $botman;
    }

}
