<?php

namespace igorbunov\Smsc;

use GuzzleHttp\Client;
use igorbunov\Smsc\Config\Config;
use igorbunov\Smsc\Response\Balance;
use igorbunov\Smsc\Response\Senders;
use igorbunov\Smsc\Status\SmsStatus;
use igorbunov\Smsc\Response\NewSubclient;
use igorbunov\Smsc\Response\UpdateBalance;
use igorbunov\Smsc\Validator\MainValidator;
use igorbunov\Smsc\Response\SendSmsResponse;
use igorbunov\Smsc\Response\SendEmailResponse;

class SmscJsonApi
{
    private $validator;
    private $guzzleClient;
    private $config;

    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->validator = new MainValidator();

        $this->guzzleClient = new Client([
            'verify' => false,
            'http_errors' => false
        ]);
    }

    public function getBalance(): Balance
    {
        $params = array_merge([
            'fmt=3',
            'cur=1'
        ], $this->config->credentials());

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('balance.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new Balance($jsonResponse);
    }

    public function getSenderNames(): Senders
    {
        $params = array_merge([
            'get=1',
            'fmt=3',
            'cur=1'
        ], $this->config->credentials());

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('senders.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new Senders($jsonResponse);
    }

    public function sendSms($phones, $message, $sender = ''): SendSmsResponse
    {
        if (is_array($phones)) {
            $phones = implode(',', $phones);
        }

        $message = urlencode(iconv("utf-8", "windows-1251", $message));

        $params = array_merge([
            'phones=' . $phones,
            'mes=' . $message,
            'fmt=3',
            'cost=3',
            'op=1'
        ], $this->config->credentials());

        if (!empty($sender)) {
            $params[]= 'sender=' . $sender;
        }

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('send.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        (new MainValidator())->validate($jsonResponse);

        return new SendSmsResponse($jsonResponse);
    }

    public function getSmsStatus($messageIds, $phone): SmsStatus
    {
        if (is_array($messageIds)) {
            $messageIds = implode(',', $messageIds);
        }

        $params = array_merge([
            'id=' . $messageIds,
            'phone=' . $phone,
            'fmt=3',
            'all=0',
            'charset=utf-8'
        ], $this->config->credentials());

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('status.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        (new MainValidator())->validate($jsonResponse);

        return new SmsStatus($jsonResponse);
    }

    public function updateSubclientBalance($subLogin, $balance): UpdateBalance
    {
        $params = array_merge([
            'user=' . $subLogin,
            'sum=' . $balance,
            'fmt=3',
            'balance2=1',
            'pay=1'
        ], $this->config->credentials());

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('users.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new UpdateBalance($jsonResponse);
    }

    public function sendEmail($emails, $message, $theme, $sender): SendEmailResponse
    {
        if (is_array($emails)) {
            $emails = implode(',', $emails);
        }

        $emails = str_replace('@', '%40', $emails);

        $message = urlencode(iconv("utf-8", "windows-1251", $message));
        $theme = urlencode(iconv("utf-8", "windows-1251", $theme));

        $params = array_merge([
            'phones=' . $emails,
            'mes=' . $message,
            'sender=' . $sender,
            'subj=' . $theme,
            'fmt=3',
            'mail=1'
        ], $this->config->credentials());

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('send.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new SendEmailResponse($jsonResponse);
    }

    public function registerSubclient($subLogin, $subPassword, $subEmail, $subPhone, $parentSender): NewSubclient
    {
        $params = array_merge([
            'user=' .urlencode($subLogin),
            'password=' .urlencode($subPassword),
            'email=' .$subEmail,
            'phone=' .$subPhone,
            'reseller=1',
            'type=0',
            'tariff=0',
            'mintrf=0',
            'add=1',
            'fmt=3',
            'op=1',
            'sender=' . $parentSender,
            'fl2[24]=1'
        ], $this->config->credentials());

        $response = $this->guzzleClient->request(
            self::METHOD_POST,
            $this->config->url('users.php') . '?' . implode('&', $params)
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->validator->validate($jsonResponse);

        return new NewSubclient($jsonResponse);
    }
}