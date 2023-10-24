<?php

declare(strict_types=1);

use Ypmn\ApiRequest;
use Ypmn\Report;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Хотим получить токен
// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе)
$apiRequest->setSandboxMode();

// Выберем даты
$startDate = date('Y-m-d');
$endDate = date('Y-m-d');

// Выберем, какие транзакции нам интересны
$transactionStatuses = [
  'COMPLETE',
];

// TODO: refactor

// отправим запрос
$result = $apiRequest->sendGetReportRequest(
    $startDate,
    $endDate,
    $transactionStatuses
);
