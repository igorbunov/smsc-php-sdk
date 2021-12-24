<?php

namespace igorbunov\Smsc\Config;

class Config
{
    private $login;
    private $password;
    private $url;

    public function __construct(
        string $login,
        string $password,
        string $url = 'https://smsc.ru/sys/'
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->url = $url;
    }

    public function credentials(): array
    {
        return [
            'login=' . $this->login,
            'psw=' . $this->password
        ];
    }

    public function url(string $page): string
    {
        return $this->url . $page;
    }
}
