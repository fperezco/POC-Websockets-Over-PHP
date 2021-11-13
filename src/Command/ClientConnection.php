<?php

namespace App\Command;

use Ratchet\ConnectionInterface;

class ClientConnection
{


    private string $clientUuid;
    private ConnectionInterface $connection;

    public function __construct(string $clientUuid, ConnectionInterface $connection)
    {
        $this->clientUuid = $clientUuid;
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getClientUuid(): string
    {
        return $this->clientUuid;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

}