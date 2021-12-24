<?php

namespace igorbunov\Smsc\Response;

use igorbunov\Smsc\Status\SmsStatus;

class Phone
{
    public $phone = '';
    public $mccmnc = '';
    public $cost = '';
    public $status = '';
    public $error = '';
    public $smsStatus;

    public function __construct(array $jsonResponse)
    {
        $this->phone = $jsonResponse['phone'];
        $this->mccmnc = $jsonResponse['mccmnc'];
        $this->cost = $jsonResponse['cost'] ?? '';
        $this->status = $jsonResponse['status'] ?? '';
        $this->error = $jsonResponse['error'] ?? '';

        if (!empty($this->status)) {
            $this->smsStatus = new SmsStatus($jsonResponse);
        }
    }
}
