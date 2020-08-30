<?php
namespace app\commands;

use app\daemons\ChatServer;
use yii\console\Controller;

class WebsocketServerController extends Controller
{
    public function actionStart()
    {
        $server = new ChatServer();
        $server->port = 8081;

        $server->on(ChatServer::EVENT_WEBSOCKET_OPEN_ERROR, function($e) use($server) {
            echo "Error opening port " . $server->port . "\n";
            $server->port += 1; //Try next port to open
            $server->start();
        });

        $server->on(ChatServer::EVENT_WEBSOCKET_OPEN, function($e) use($server) {
            echo "Server started at port " . $server->port;
        });

        $server->start();
    }
}