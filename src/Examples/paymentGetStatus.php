<?php

declare(strict_types=1);

use Ypmn\ApiRequest;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Получить номер транзакции в Ypmn

// Номер заказа
$merchantPaymentReference = 'primer_nomer__184';
// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе!)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
$apiRequest->setSandboxMode();
// Отправим запрос к API
$responseData = $apiRequest->sendStatusRequest($merchantPaymentReference);
