<?php

namespace App\Command;

use App\Events\MessageToUserEvent;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ServerBasicCommand extends Command implements MessageHandlerInterface
{
    protected static $defaultName = 'ServerCommandBasic';
    protected static $defaultDescription = 'Websockets server';
    private ServerBasic $app;
    private IoServer $server;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->app = new ServerBasic();

        $this->server = IoServer::factory(new HttpServer(
                                              new WsServer(
                                                  $this->app
                                              )
                                          ), 8080);
    }

    protected function configure(): void
    {
        $this
            ->setName('webserverbasic:server')
            ->setDescription('Start the notification server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo "goooo\n";

 /*       $this->server = IoServer::factory(new HttpServer(
                                        new WsServer(
                                            $this->app
                                        )
                                    ), 8080);*/

        $this->server->run();
        //return 0;

    }

    public function __invoke(MessageToUserEvent $messageToUserEvent)
    {
        $userUuid = $messageToUserEvent->getUserUuid();
        $message = $messageToUserEvent->getMessage();
        echo "message to user event!!! $userUuid , $message\n\n";
        $this->server->app->sendMessageToClientByUuid($userUuid,$message);
    }
}
