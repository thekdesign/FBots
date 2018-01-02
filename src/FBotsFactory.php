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

    }

    public static function create(Request $request)
    {

        $config = [
            'facebook' => [
                'token' => env('FACEBOOK_TOKEN'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'verification' => env('FACEBOOK_VERIFICATION'),
            ]
        ];

        DriverManager::loadDriver(FacebookDriver::class);

        $botman = BotManFactory::create($config, new LaravelCache(), $request);

        $botman->loadDriver(FacebookDriver::class);

        return $botman;
    }

}
