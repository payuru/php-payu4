<?php declare(strict_types=1);

use Ypmn\Amount;
use Ypmn\ApiRequest;
use Ypmn\Billing;
use Ypmn\Payout;
use Ypmn\PayoutDestination;
use Ypmn\PayoutSource;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

/**
 * Это файл с примером для создания выплат на карту физ. лицам
 **/

// Созданим выплату
$payout = new Payout();

// Назначим ей уникальный номер выплаты
// (повторно этот номер использовать нельзя,
// даже если выплата неудачная
$payout->setMerchantPayoutReference('payout__' . time());

// Назначим сумму
$payout->setAmount(
    new Amount(15, 'RUB')
);

// Назначим Описание
$payout->setDescription('Тестовое Описание Платежа');

// Опишем и назначим Направление и Получателя платежа
$destination = new PayoutDestination();
// Назначим номер карты
$destination->setCardNumber("4111111111111111");
// Опишем получателя
$recipient = new Billing();
// E-mail получателя
$recipient->setEmail('support@ypmn.ru');
// Город получателя
$recipient->setCity('Москва');
// Адрес получателя
$recipient->setAddressLine1('Арбат, 10');
// Почтовый индекс получателя
$recipient->setZipCode('121000');
// Код страны получателя (2 буквы, на английском)
$recipient->setCountryCode('RU');

// Имя получателя из GET-запроса
$postRecipientName = explode(' ', @$_POST['reciever-name'] ?: '');
// Установим Имя получателя для платежа
$recipient->setFirstName(@$postRecipientName[0] ?: 'Иван');
// Фамилия получателя
$recipient->setLastName(@$postRecipientName[1] ?: @$postRecipientName[0] ?: 'Иванович');
$destination->setRecipient($recipient);
$payout->setDestination($destination);

// Опишем и назначим Источник платежа
$source = new PayoutSource();
// Опишем отправителя
$sender = new Billing();
// Имя отправителя
$sender->setFirstName('Василий');
// Фамилия отправителя
$sender->setLastName('Петрович');
// Телефон отправителя
$sender->setPhone('0764111111');
// Email отправителя
$sender->setEmail('test@example.ru');;
$source->setSender($sender);
$payout->setSource($source);

// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе!)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
$apiRequest->setSandboxMode();
// Отправим запрос
$responseData = $apiRequest->sendPayoutCreateRequest($payout);
