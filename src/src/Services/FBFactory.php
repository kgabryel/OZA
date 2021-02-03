<?php

namespace App\Services;

use Facebook\Exceptions\FacebookSDKException as FacebookSDKExceptionAlias;
use Facebook\Facebook;

class FBFactory
{
    /**
     * @return Facebook
     * @throws FacebookSDKExceptionAlias
     */
    public static function getInstance(): Facebook
    {
        return new Facebook(
            [
                'app_id' => $_ENV['FB_ID'],
                'app_secret' => $_ENV['FB_SECRET'],
                'default_graph_version' => 'v3.2',
            ]
        );
    }
}