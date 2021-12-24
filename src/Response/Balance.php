<?php

namespace igorbunov\Smsc\Response;

class Balance
{
    public $balance = '';
    public $currency = '';

    public function __construct(array $jsonResponse)
    {
        $this->balance = $jsonResponse['balance'];
        $this->currency = $jsonResponse['currency'] ?? '';
    }
}
