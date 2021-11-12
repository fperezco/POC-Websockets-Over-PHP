<?php

namespace App\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ServerCommand extends Command
{
    protected static $defaultName = 'ServerCommand';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->setName('Project:notification:server')
            ->setDescription('Start the notification server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = IoServer::factory(new HttpServer(
                                        new WsServer(
                                            new Notification($this->getContainer())
                                        )
                                    ), 8080);

        $server->run();

    }
}
