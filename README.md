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