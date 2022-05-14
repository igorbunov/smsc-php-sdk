![GitHub CI](https://github.com/igorbunov/smsc-php-sdk/workflows/CI/badge.svg)
[![Packagist](https://img.shields.io/badge/package-igorbunov/smsc--php--sdk-blue.svg?style=flat-square)](https://github.com/igorbunov/smsc-php-sdk)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/igorbunov/smsc-php-sdk.svg?style=flat-square)](https://github.com/igorbunov/smsc-php-sdk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![PHP >=8.0](https://img.shields.io/badge/php-%3E=_8.0-orange.svg?style=flat-square)](https://github.com/igorbunov/smsc-php-sdk)
[![Total Downloads](https://poser.pugx.org/igorbunov/smsc-php-sdk/downloads)](https://github.com/igorbunov/smsc-php-sdk)

# smsc-php-sdk
### PHP SDK для работы с Мессенджером sms центр api

##### Примечание:

> В данном sdk реализованы не все функции отправки сообщений

#### Официальная документация:

<https://smsc.ru/api/http/#menu>

#### Установка:
```bash
composer require igorbunov/smsc-php-sdk
```

#### Настройка:

```php
require_once 'vendor/autoload.php';
```

##### Начало работы:

```php
$api = new \igorbunov\Smsc\SmscJsonApi(
    new \igorbunov\Smsc\Config\Config('логин', 'пароль')
);
```

##### Проверка баланса:

```php
$result = $api->getBalance(): \igorbunov\Smsc\Response\Balance;
```

##### Получить имена отправителей (sender id):

```php
$result = $api->getSenderNames(): \igorbunov\Smsc\Response\Senders;
```

##### Отправка смс сообщения:

```php
// $phones - телефон или массив телефонов
// $message - сообщение
// $sender - имя отправителя (sender id)
$result = $api->sendSms($phones, $message, $sender): \igorbunov\Smsc\Response\SendSmsResponse;
```

##### Получить статус сообщения:

```php
$result = $api->getSmsStatus('id сообщения', 'номер телефона'): \igorbunov\Smsc\Status\SmsStatus;
```

##### Отправка email сообщения:

```php
// $emails - email или массив email'ов
// $message - сообщение
// $theme - тема
// $sender - email отправителя
$result = $api->sendEmail(
    $emails,
    $message,
    $theme,
    $sender
): \igorbunov\Smsc\Response\SendEmailResponse;
```

##### Регистрация субакаунта:

```php
// $subLogin - логин субакаунта
// $subPassword - пароль субакаунта (не допускаются простые пароли)
// $subEmail - почта субакаунта
// $subPhone - телефон субакаунта
// $parentSender - имя отправителя родителя (sender id) (не обязательно)
$result = $api->registerSubclient(
    $subLogin,
    $subPassword,
    $subEmail,
    $subPhone,
    $parentSender
): \igorbunov\Smsc\Response\NewSubclient;
```

##### Обновить баланс субакаунта:

```php
$result = $api->updateSubclientBalance($subLogin, $balance): \igorbunov\Smsc\Response\UpdateBalance;
```

##### Простой пример отправки

```php

use igorbunov\Smsc\SmscJsonApi;
use igorbunov\Smsc\Config\Config;

require_once 'vendor/autoload.php';

try {
    $api = new SmscJsonApi(
        new Config('логин', 'пароль')
    );

    $sender = 'отправитель';
    $phones = '380123456789';
    $message = 'test';
    $result = $api->sendSms($phones, $message, $sender);

    echo "id сообщения: {$result->id}, стоимость:  {$result->cost}";

    echo '<pre>';
    var_dump($result);
    echo '</pre>';
} catch (\Exception $e) {
    echo '<pre>';
    var_dump('Ошибка', $e->getMessage());
    echo '</pre>';
}
```

# Для котрибьюторов


For run all tests
```shell
make all
```
or connect to terminal
```shell
make exec
```

or use built in php server [http://localhost:8080](http://localhost:8080)
```shell
# start server on 8080 port
make serve
# custom port 8081
make serve PORT=8081
```

*Dafault php version is 8.1*. Use PHP_VERSION= for using custom version.
```shell
make all PHP_VERSION=8.1
# run both
make all PHP_VERSION=7.4 && make all PHP_VERSION=8.1
```

all commands
```shell
# security check
make security
# composer install
make install
# composer install with --no-dev
make install-no-dev
# check code style
make style
# run static analyze tools
make static-analyze
# run unit tests
make unit
```

Without Docker
```
#validate composer json
composer check-composer

#static analyzes and codestyle
composer static

#run unit tests
composer unit-tests

#run all tests

composer all-tests
```