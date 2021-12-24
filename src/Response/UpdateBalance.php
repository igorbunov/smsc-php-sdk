<?php

namespace igorbunov\Smsc\Response;

class UpdateBalance
{
    public $result = '';

    public function __construct(array $jsonResponse)
    {
        $this->result = $jsonResponse['result'] ?? '';
    }
}
