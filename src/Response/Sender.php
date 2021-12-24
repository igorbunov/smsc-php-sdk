<?php

namespace igorbunov\Smsc\Response;

class Sender
{
    public $id = 0;
    public $sender = '';

    public function __construct(array $jsonResponse)
    {
        $this->id = $jsonResponse['id'];
        $this->sender = $jsonResponse['sender'];
    }
}
