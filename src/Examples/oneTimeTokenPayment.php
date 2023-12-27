<?php
declare(strict_types=1);

use Ypmn\Authorization;
use Ypmn\OneTimeUseToken;
use Ypmn\Payment;
use Ypmn\Client;
use Ypmn\Billing;
use Ypmn\ApiRequest;
use Ypmn\PaymentException;
use Ypmn\Product;
use Ypmn\Std;

// Подключим файл, в котором заданы параметры мерчанта
include_once 'start.php';

if (empty($_REQUEST['token']) || empty($_REQUEST['sessionId'])) {
    if ($jsonMode) {
        echo json_encode([
            'status' => 'FAILED',
            'message' => 'Token and sessionId are required'
        ]);
        exit();
    }

    throw new PaymentException('Необходимо передать одноразовый токен и ID сессии');
}

// Оплата по токену
// Установим номер (ID) заказа (номер заказа в вашем магазине, должен быть уникален в вашей системе)
$merchantPaymentReference = "order_id_" . time();
$orderAsProduct = new Product([
    'name'  => 'Заказ №' . $merchantPaymentReference,
    'sku'  => $merchantPaymentReference,
    'unitPrice'  => 1.42,
    'quantity'  => 2,
]);

// Опишем Биллинговую (платёжную) информацию
$billing = new Billing;
// Установим Код страны
$billing->setCountryCode('RU');
// Установим Имя Плательщика
$billing->setFirstName('Иван');
// Установим Фамилия Плательщика
$billing->setLastName('Петров');
// Установим Email Плательщика
$billing->setEmail('test1@ypmn.ru');
// Установим Телефон Плательщика
$billing->setPhone('+7-800-555-35-35');
// Установим Город
$billing->setCity('Москва');

// Создадим клиентское подключение
$client = new Client;
// Установим биллинг
$client->setBilling($billing);

// Создадим платёж
$payment = new Payment;
// Установим позиции
$payment->addProduct($orderAsProduct);
// Установим валюту
$payment->setCurrency('RUB');

//  токен
$oneTimeUseToken = new OneTimeUseToken($_REQUEST['token'] ?? 'some token', $_REQUEST['sessionId'] ?? 'test session id');

$auth = new Authorization();
$auth->setUsePaymentPage(false);
$auth->setPaymentMethod('CCVISAMC');
$auth->setOneTimeUseToken($oneTimeUseToken);

// Создадим и установим авторизацию по типу платежа
$payment->setAuthorization($auth);

// Установим номер заказа (должен быть уникальным в вашей системе)
$payment->setMerchantPaymentReference($merchantPaymentReference);
// Установим адрес перенаправления пользователя после оплаты
$payment->setReturnUrl(
    ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http') .
    '://' .
    $_SERVER['HTTP_HOST'] .
    '/?function=returnPage'
);

// Установим клиентское подключение
$payment->setClient($client);

// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (закомментируйте или удалите в рабочей программе!)
if (!$jsonMode) {
    $apiRequest->setDebugMode();
}
// Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
$apiRequest->setSandboxMode();

try {
    // Отправляем запрос и получаем ответ
    $responseData = $apiRequest->sendAuthRequest($payment);
    // Преобразуем ответ из JSON в массив
    $responseData = json_decode((string) $responseData["response"], true);

    if ($jsonMode) {
        echo json_encode($responseData);
        exit();
    }
} catch (Exception $exception) {

    if ($jsonMode) {
        echo json_encode([
            'status' => 'FAILED',
            'message' => 'Payment method is unavailable'
        ]);
        exit();
    }

    //TODO: обработка исключения
    echo Std::alert([
        'text' => '
            Извините, платёжный метод временно недоступен.<br>
            Вы можете попробовать другой способ оплаты, либо свяжитесь с продавцом.<br>
            <br>
            <pre>' . $exception->getMessage() . '</pre>',
        'type' => 'danger',
    ]);

    throw new PaymentException('Платёжный метод временно недоступен');
}
