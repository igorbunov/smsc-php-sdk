<?php

namespace igorbunov\Smsc\Response;

class NewSubclient
{
    public $id = '';

    public function __construct(array $jsonResponse)
    {
        $this->id = $jsonResponse['id'];
    }
}
