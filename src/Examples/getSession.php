<?php

declare(strict_types=1);

use Ypmn\ApiRequest;
use Ypmn\SessionRequest;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Запрос на сессию со временем жизни = полчаса
$sessionRequest = new SessionRequest(30);

// Отправим запрос
$apiRequest = new ApiRequest($merchant);
$apiRequest->setSandboxMode();
$apiRequest->setDebugMode();

try {
    $session = $apiRequest->sendSessionRequest($sessionRequest);

} catch (\Ypmn\PaymentException $e) {
}
