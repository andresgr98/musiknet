<?php

namespace App\Shared;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    public function query($query): mixed
    {
        return $this->handle($query);
    }
}
