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

    public static function create(Request $request, $config)
    {

        // registered facebook driver
        DriverManager::loadDriver(FacebookDriver::class);


        // create the bots
        $botman = BotManFactory::create($config, new LaravelCache(), $request);

        // load facebook driver
        $botman->loadDriver(FacebookDriver::class);

        return $botman;
    }

}
