<?php

namespace igorbunov\Smsc\Response;

use igorbunov\Smsc\Response\Sender;

class Senders
{
    public $senders = [];

    public function __construct(array $jsonResponse)
    {
        foreach ($jsonResponse as $sender) {
            $this->senders[] = new Sender($sender);
        }
    }
}
