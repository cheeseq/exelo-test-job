<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace app\daemons;

use app\models\ChatMessage;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;
use yii\helpers\Html;

class ChatServer extends WebSocketServer
{
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_CLIENT_CONNECTED, function(WSClientEvent $e) {
            $e->client->name = 'anonymous';
        });
    }


    protected function getCommand(ConnectionInterface $from, $msg)
    {
        $request = json_decode($msg, true);
        return !empty($request['action']) ? $request['action'] : parent::getCommand($from, $msg);
    }

    public function commandChat(ConnectionInterface $client, $msg)
    {
        $request = json_decode($msg, true);
        $result = ['success' => false, 'error' => ''];

        if (!empty($request['name'])) {
            $client->name = $request['name'];
        }

        if (!empty($request['message']) && $message = trim($request['message']) ) {
            try {
                $messageModel = new ChatMessage();
                $messageModel->username = $client->name;
                $messageModel->message = $message;
                $messageModel->save();

                $datetime = \Yii::$app->formatter->asDatetime(time());

                $this->broadcastMessage(json_encode([
                    'success' => true,
                    'type' => 'chat',
                    'from' => Html::encode($messageModel->username),
                    'message' => Html::encode($messageModel->message),
                    'date' => $datetime
                ]));

                $result['success'] = true;
            } catch (\Exception $e) {
                $result['error'] = $e->getMessage();
                $client->send( json_encode($result) );
            }
        }

        \Yii::$app->db->close();
    }

    private function broadcastMessage($message)
    {
        foreach ($this->clients as $chatClient) {
            $chatClient->send($message);
        }
    }
}