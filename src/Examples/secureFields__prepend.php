<?php
declare(strict_types=1);

use Ypmn\ApiRequest;
use Ypmn\PaymentException;
use Ypmn\SessionRequest;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Запрос на сессию со временем жизни = полчаса
try {
    $sessionRequest = new SessionRequest(30);
} catch (PaymentException $e) {
}

// Отправим запрос
$apiRequest = new ApiRequest($merchant);
$apiRequest->setSandboxMode();
//$apiRequest->setDebugMode();

try {
    $session = $apiRequest->sendSessionRequest($sessionRequest);

    $response = json_decode($session['response']);

    $merchantCode = $merchant->getCode();
    $sessionId = $response->sessionId;
} catch (PaymentException $e) {
}
