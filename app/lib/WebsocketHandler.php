<?php

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Description of WebsocketHandler
 *
 * @author Jason
 */
class WebsocketHandler implements MessageComponentInterface
{
    private $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        \Log::info('Started WebsockeHandler');
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Client closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
        echo "Client Errored\n";
        \Log::error($e->getMessage(), array('code' => $e->getCode(), 'trace' => $e->getTrace()));
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        if ($msg !== 'listen') {
            echo "Sending message to {$this->clients->count()} clients '$msg'\n";
            foreach ($this->clients as $client) {
//                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    $client->send($msg);
//                }
            }
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Client Opened\n";
    }
}