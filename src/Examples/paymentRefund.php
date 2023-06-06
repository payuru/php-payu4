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

// Инициировать возврат средств

// Создадим запрос
$refund = (new Refund);

// Установим номер платежа Ypmn - возвращается в ответ на запрос на авторизацию платежа в JSON Response
// См. пример с запросом Payment выше
$refund->setYpmnPaymentReference(2297597);
// Cумма исходной операции на авторизацию
$refund->setOriginalAmount(3700);
// Cумма фактического списания
$refund->setAmount(3700);
// Установим валюту
$refund->setCurrency('RUB');
// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе!)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
$apiRequest->setSandboxMode();
// Отправим запрос к API
$responseData = $apiRequest->sendRefundRequest($refund, $merchant);
