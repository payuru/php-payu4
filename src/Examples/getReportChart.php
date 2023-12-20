<?php

declare(strict_types=1);

 use Ypmn\ApiRequest;
 use Ypmn\PaymentException;
 use Ypmn\Std;

 // Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Получение графика отчета

// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе!)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
$apiRequest->setSandboxMode();

// Отправим запрос
$responseData = $apiRequest->sendReportChartRequest([
    'startDate' => '2023-12-02',
    'endDate' => '2023-12-08',
    'periodLength' => 'day'
]);