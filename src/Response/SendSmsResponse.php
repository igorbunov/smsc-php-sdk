<?php

namespace igorbunov\Smsc\Response;

use igorbunov\Smsc\Response\Phone;

class SendSmsResponse
{
    public $id;
    public $cnt;
    public $cost;
    public $balance;
    public $phones = [];

    public function __construct(array $jsonResponse)
    {
        $this->id = $jsonResponse['id'];
        $this->cnt = $jsonResponse['cnt'];
        $this->cost = $jsonResponse['cost'];
        $this->balance = $jsonResponse['balance'];

        foreach ($jsonResponse['phones'] as $phone) {
            $this->phones[] = new Phone($phone);
        }
    }
}
