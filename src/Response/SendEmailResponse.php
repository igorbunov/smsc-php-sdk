<?php

namespace igorbunov\Smsc\Response;

class SendEmailResponse
{
    public $id;
    public $cnt;

    public function __construct(array $jsonResponse)
    {
        $this->id = $jsonResponse['id'];
        $this->cnt = $jsonResponse['cnt'] ?? '';
    }
}
