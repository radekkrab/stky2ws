<?php

namespace app\commands;

use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use yii\console\Controller;
use app\models\Connection;

class ConnectionController extends Controller
{
    private $connectionInfo = [];
    
    public function actionRun()
    {
        $worker = new Worker('websocket://127.0.0.2:8080');

        $worker->onConnect = [$this, 'onConnect'];

        $worker->onClose = [$this, 'onClose'];

        $worker->onMessage = [$this, 'onMessage'];

        Worker::runAll();
    }

    public function onConnect(TcpConnection $connection)
    {
        echo "New connection\n";
    }

    public function onClose(TcpConnection $connection)
    {
        if(!empty($this->connectionInfo)) {
            $connection = new Connection();
            $connection->token = $this->connectionInfo['token'];
            $connection->user_id = $this->connectionInfo['user_id'];
            $connection->user_agent = $this->connectionInfo['user_agent'];
            $connection->created_at = $this->connectionInfo['created_at'];
            $connection->finished_at = date('Y-m-d H:i:s');
            $connection->save(); 
            unset($this->connectionInfo['token']);
            unset($this->connectionInfo['user_id']);
            unset($this->connectionInfo['user_agent']);
            unset($this->connectionInfo['created_at']);
            unset($this->connectionInfo['finished_at']);
        }
    }

    public function onMessage(TcpConnection $connection, string $data)
    {
        $requestData = json_decode($data, true);

        if (isset($requestData['token'])) {
            $token = $requestData['token'];
            
            if ($token !== 'accessToken3') {
                $connection->close();
            } else {
                $this->connectionInfo = [
                    'token' => $token,
                    'user_id' => $requestData['user_id'],
                    'user_agent' => $requestData['user_agent'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'finished_at' => null, 
                ];    
                $connection->send(json_encode($requestData));
            }
        }
    }
}
