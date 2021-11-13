<?php

declare(strict_types=1);

namespace App\Events;

class MessageToUserEvent
{
    private string $userUuid;
    private string $message;

    public function __construct(string $userUuid,string $message)
    {
        $this->userUuid = $userUuid;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

}