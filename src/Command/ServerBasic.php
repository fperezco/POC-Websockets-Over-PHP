<?php

namespace App\Command;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ServerBasic implements MessageComponentInterface {
    protected $clients;
    protected array $clientConnections;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        //$this->clientConnections = new \SplObjectStorage;
        echo "builded...";
    }

    public function onOpen(ConnectionInterface $conn) {

        echo "New connection! ({$conn->resourceId})\n";
        echo "trying.... parameters \n\n";
        //trying to get parameters
        $parameters = $conn->httpRequest->getUri()->getQuery();
        echo "parameters \n\n";
        $queryArray = explode('=', $parameters);

        $this->users[$queryArray[1]] = $conn;
        $userUuid = $queryArray[1];

        echo "New user connected! ({$userUuid})";
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $newClientConnection = new ClientConnection($userUuid, $conn);
        $this->clientConnections[$userUuid] = $conn;
        echo "Conectado estado del array\n\n";
        $this->printArrayIndexes();
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";

        echo "desconectamos el cliente en cuestion..\n\n";
        echo "Antes\n\n";
        $this->printArrayIndexes();
        foreach ($this->clientConnections as $uuid => $connection){
            if($connection->resourceId == $conn->resourceId){
                unset($this->clientConnections[$uuid]);
            }
        }
        echo "Despues\n\n";
       $this->printArrayIndexes();
        echo "---\n\n";
        echo "---\n\n";
        //$clientConnection = new ClientConnection($userUuid, $conn);



    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function printArrayIndexes()
    {
        foreach($this->clientConnections as $key => $value){
            echo $key."\n\n";
        }
    }
}