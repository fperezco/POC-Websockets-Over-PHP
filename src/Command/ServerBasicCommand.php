<?php

namespace App\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerBasicCommand extends Command
{
    protected static $defaultName = 'ServerCommandBasic';
    protected static $defaultDescription = 'Websockets server';

    protected function configure(): void
    {
        $this
            ->setName('webserverbasic:server')
            ->setDescription('Start the notification server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo "goooo\n";
        $server = IoServer::factory(new HttpServer(
                                        new WsServer(
                                            new ServerBasic()
                                        )
                                    ), 8080);

        $server->run();
        return 0;

    }
}
