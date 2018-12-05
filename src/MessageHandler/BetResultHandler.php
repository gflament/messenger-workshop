<?php

namespace App\MessageHandler;

use App\Exception\ClientUnauthorized;
use App\Message\GameResultMessage;
use App\Message\Lost;
use App\Message\Won;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class BetResultHandler implements MessageSubscriberInterface
{
    public function handleResult($message)
    {
        if ($message instanceof Lost) {
            try {
                throw new \InvalidArgumentException('User is not allowed.');
            } catch (\InvalidArgumentException $e) {
                throw new ClientUnauthorized('Oups.');
            }
        }

        echo $message->bet->user." ".get_class($message)."<br>";
    }

    public static function getHandledMessages(): iterable
    {
        yield GameResultMessage::class => [
            'method' => 'handleResult',
            'bus' => 'event_bus',
        ];
    }
}