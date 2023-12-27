<?php

declare(strict_types=1);

use Ypmn\ApiRequest;
use Ypmn\Capture;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Запрос на списание денег
// В зависимости от настройки мерчанта, Ypmn может списывать денежные средства автоматически,
// Либо с помощью дополнительного запроса, описанного ниже.

// Создадим такой запрос:
$capture = (new Capture);

// Номер платежа Ypmn (возвращается в ответ на запрос на авторизацию в JSON Response)
$capture->setYpmnPaymentReference('2297597');

// Cумма исходной операции на авторизацию
$capture->setOriginalAmount(5300);
// Cумма фактического списания
$capture->setAmount(3700);
// Валюта
$capture->setCurrency('RUB');

// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе!)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
$apiRequest->setSandboxMode();
// Отправим запрос к API
$responseData = $apiRequest->sendCaptureRequest($capture, $merchant);
