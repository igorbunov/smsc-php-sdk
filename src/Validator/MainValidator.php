<?php

namespace igorbunov\Smsc\Validator;

class MainValidator
{
    private $statuses = [
        '1' => 'Ошибка в параметрах.',
        '2' => 'Неверный логин или пароль. Также возникает при попытке отправки сообщения с IP-адреса, не входящего в список разрешенных Клиентом (если такой список был настроен Клиентом ранее).',
        '3' => 'Недостаточно средств на счете Клиента.',
        '4' => 'IP-адрес временно заблокирован из-за частых ошибок в запросах. Подробнее',
        '5' => 'Неверный формат даты.',
        '6' => 'Сообщение запрещено (по тексту или по имени отправителя). Также данная ошибка возникает при попытке отправки массовых и (или) рекламных сообщений без заключенного договора.',
        '7' => 'Неверный формат номера телефона.',
        '8' => 'Сообщение на указанный номер не может быть доставлено.',
        '9' => 'Отправка более одного одинакового запроса на передачу SMS-сообщения либо более пяти одинаковых запросов на получение стоимости сообщения в течение минуты.
                Данная ошибка возникает также при попытке отправки пятнадцати и более запросов одновременно с разных подключений под одним логином (too many concurrent requests).'
    ];

    public function validate(array $response): void
    {
        if (!array_key_exists('error', $response)) {
            return;
        }

        throw new \Exception($this->statuses[$response['error_code']] ?? $response['error']);
    }
}
