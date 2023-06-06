<?php

declare(strict_types=1);

use Ypmn\Authorization;
use Ypmn\Delivery;
use Ypmn\IdentityDocument;
use Ypmn\Merchant;
use Ypmn\MerchantToken;
use Ypmn\Payment;
use Ypmn\Client;
use Ypmn\Billing;
use Ypmn\ApiRequest;
use Ypmn\PaymentException;
use Ypmn\Product;
use Ypmn\Capture;
use Ypmn\Refund;
use Ypmn\Std;
use Ypmn\PaymentReference;

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
