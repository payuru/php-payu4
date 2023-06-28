<?php

/**
 * Этот файл аналогичен paymentRefund.php за исключением того,
 * что здесь возврат разделяется на несколько мерчантов
 */

declare(strict_types=1);

use Ypmn\ApiRequest;
use Ypmn\Refund;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

// Создадим запрос на возврат средств
$refund = (new Refund);
// Установим номер платежа Ypmn
$refund->setYpmnPaymentReference("2297597");
// Cумма исходной операции на авторизацию
$refund->setOriginalAmount(3700);
// Cумма фактического списания
$refund->setAmount(3700);
// Добавим Сабмерчантов
$refund->addMarketPlaceSubmerchant('SUBMERCHANT_1', 3000);
$refund->addMarketPlaceSubmerchant('SUBMERCHANT_2', 700);
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
