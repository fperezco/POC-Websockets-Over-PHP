<?php

namespace App\Command;

use App\Events\MessageToUserEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class SendMessageToClientTestCommand extends Command
{
    protected static $defaultName = 'SendMessageToClientTest';
    protected static $defaultDescription = 'Add a short description for your command';
    private MessageBusInterface $messageBus;
    private string $uuid;
    private string $message;

    public function __construct( MessageBusInterface $messageBus,$name = null)
    {
        parent::__construct($name);
        $this->messageBus = $messageBus;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
/*        $uuid = '456-456-111-111';
        $message = "test message!!!!";
        $event = new MessageToUserEvent($uuid,$message);
        $this->messageBus->dispatch($event);*/

        $this->uuid = '456-456-111-111';
        $this->message = "test message!!!!";

        \Ratchet\Client\connect('ws://localhost:8080?uuid=server')->then(function($conn) {
            $conn->on('message', function($msg) use ($conn) {
                echo "Received: {$msg}\n";
                $conn->close();
            });

            $conn->send('{"to":"'.$this->uuid.'","message":"'.$this->message.'"}');
            //$conn->send($this->uuid);
            $conn->close();
            return 0;
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });

        return 0;
    }
}
