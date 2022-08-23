<?php
/**
 * Пример интеграции API многофункциональной платёжной системы PayU, версия 4
 * Документация:
 *      https://dev.payu.ru/ru/documents/apiv4/
 *      https://secure.payu.ru/docs/#tag/Payment-API
 * Начните знакомство с кодом с текущего файла
 *  и класса PaymentInterface
 */

use payuru\phpPayu4\Authorization;
use payuru\phpPayu4\Delivery;
use payuru\phpPayu4\IdentityDocument;
use payuru\phpPayu4\Merchant;
use payuru\phpPayu4\Payment;
use payuru\phpPayu4\Client;
use payuru\phpPayu4\Billing;
use payuru\phpPayu4\ApiRequest;
use payuru\phpPayu4\PaymentException;
use payuru\phpPayu4\Product;
use payuru\phpPayu4\Capture;
use payuru\phpPayu4\Refund;

// TODO: нужен публичный тестовый мерчант, которого можно включить в документацию
// Создадим тестового мерчанта
//$merchant = new Merchant('rudevru1', 'hE9I1?3@|C8@w[1I&=y)');
$merchant = new Merchant('CC1', 'SECRET_KEY');
//ePayment Code: и Secret

if(isset($_GET['function'])){
    try {
        switch ($_GET['function']) {
            case 'getPaymentLink':
                // Оплата по ссылке PayU
                // Представим, что нам надо оплатить пару позиций: Синий Мяч и Жёлтый Круг

                // Опишем первую позицию
                $product1 = new Product;
                // Установим Наименование (название товара или услуги)
                $product1->setName('Синий Мяч');
                // Установим Артикул
                $product1->setSku('ball-05');
                // Установим Стоимость за единицу
                $product1->setUnitPrice('500');
                // Установим Количество
                $product1->setQuantity(1);
                // Установим НДС
                $product1->setVat(20);

                //Опишем вторую позицию с помощью сокращённого синтаксиса:
                $product2 = new Product([
                    'name'  => 'Жёлтый Круг',
                    'sku'  => 'toy-15',
                    'unitPrice'  => '1600',
                    'quantity'  => '3',
                    'vat'  => 0,
                ]);

                // Опишем Биллинговую (платёжную) информацию
                $billing = (new Billing);
                // Установим Код страны
                $billing->setCountryCode('RU');
                // Установим Город
                $billing->setCity('Москва');
                // Установим Регион
                $billing->setState('Центральный регион');
                // Установим Адрес Плательщика (первая строка)
                $billing->setAddressLine1('Улица Старый Арбат, дом 10');
                // Установим Адрес Плательщика (вторая строка)
                $billing->setAddressLine1('Офис PayU');
                // Установим Почтовый Индекс Плательщика
                $billing->setZipCode('121000');
                // Установим Имя Плательщика
                $billing->setFirstName('Иван');
                // Установим Фамилия Плательщика
                $billing->setLastName('Петров');
                // Установим Телефон Плательщика
                $billing->setPhone('+79670660742');
                // Установим Email Плательщика
                $billing->setEmail('test1@payu.ru');

                // (необязательно) Опишем Доствку и принимающее лицо
                $delivery = (new Delivery);
                // Установим документ, подтверждающий право приёма доставки
                $delivery->setIdentityDocument(
                    new IdentityDocument('123456', 'PERSONALID')
                );
                // Установим Код страны
                $delivery->setCountryCode('RU');
                // Установим Город
                $delivery->setCity('Москва');
                // Установим Регион
                $delivery->setState('Центральный регион');
                // Установим Адрес Лица, принимающего заказ (первая строка)
                $delivery->setAddressLine1('Улица Старый Арбат, дом 10');
                // Установим Адрес Лица, принимающего заказ (вторая строка)
                $delivery->setAddressLine1('Офис PayU');
                // Установим Почтовый Индекс Лица, принимающего заказ
                $delivery->setZipCode('121000');
                // Установим Имя Лица, принимающего заказ
                $delivery->setFirstName('Мария');
                // Установим Фамилия Лица, принимающего заказ
                $delivery->setLastName('Петрова');
                // Установим Телефон Лица, принимающего заказ
                $delivery->setPhone('+79670660743');
                // Установим Email Лица, принимающего заказ
                $delivery->setEmail('test2@payu.ru');
                // Установим Название Компании, в которой можно оставить заказ
                $delivery->setCompanyName('ООО "Вектор"');

                // Создадим клиентское подключение
                $client = (new Client);
                // Установим биллинг
                $client->setBilling($billing);
                // Установим доставку
                $client->setDelivery($delivery);
                // Установим IP (автоматически)
                $client->setCurrentClientIp();
                // И Установим время (автоматически)
                $client->setCurrentClientTime();

                // Создадим платёж
                $payment = (new Payment);
                // Установим валюту
                $payment->setCurrency('RUB');
                // Установим позиции
                $payment->addProduct($product1);
                $payment->addProduct($product2);

                // Установим авторизацию
                $payment->setAuthorization(new Authorization('CCVISAMC',true));
                // Установим номер заказа (должен быть уникальным)
                $payment->setMerchantPaymentReference('primer_nomer__' . time());
                // Установим адрес перенаправления пользователя после оплаты
                $payment->setReturnUrl('http://127.0.0.1:8080/?function=returnPage');
                // Установим клиентское подключение
                $payment->setClient($client);

                // Создадим запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Установим вывод сообщений отладки
                $apiRequest->setDebugMode();
                // Установим режим песочницы
                $apiRequest->setSandboxMode();
                // Отправим запрос
                $responseData = $apiRequest->sendAuthRequest($payment, $merchant);
                // Преобразуем ответ из JSON в массив
                $responseData = json_decode((string) $responseData["response"], true);
                // Нарисуем кнопку оплаты
                echo '<a href="'.$responseData["paymentResult"]['url'].'" class="btn btn-success" target="_b" rel="noopener"> ОПЛАТА </a><br><br><br>';
                break;

            case 'paymentCapture':
                // списание денег
                // Номер платежа PayU (возвращается в ответ на запрос на авторизацию в JSON Response
                $payuPaymentReference = 2297597;

                // Cумма исходной операции на авторизацию
                $originalAmount = 5300;

                // Cумма фактического списания
                $amount = 3700;

                $capture = (new Capture)
                    ->setPayuPaymentReference($payuPaymentReference)
                    ->setOriginalAmount($originalAmount)
                    ->setAmount($amount)
                    ->setCurrency('RUB');

                $apiRequest = new ApiRequest($merchant);
                $responseData = $apiRequest->sendCaptureRequest($capture, $merchant);

                break;
            case 'paymentGetStatus':
                // получить номер платежа по PayU
                // Номер заказа PayU (возвращается в ответ на запрос на авторизацию в JSON Response
                $merchantPaymentReference = 'primer_nomer__184';

                $apiRequest = new ApiRequest($merchant);
                $responseData = $apiRequest->sendStatusRequest($merchantPaymentReference);
                echo '<pre>' . print_r($responseData, true) . '</pre>';

                break;
            case 'paymentWebhook':
                //сформировать вебхук
                break;
            case 'paymentRefund':
                //инициировать возврат

                // Номер платежа PayU (возвращается в ответ на запрос на авторизацию в JSON Response)
                $payuPaymentReference = 2297597;

                // Cумма исходной операции на авторизацию
                $originalAmount = 3700;

                // Cумма фактического списания
                $amount = 3700;

                $refund = (new Refund)
                    ->setPayuPaymentReference($payuPaymentReference)
                    ->setOriginalAmount($originalAmount)
                    ->setAmount($amount)
                    ->setCurrency('RUB');

                $apiRequest = new ApiRequest($merchant);
                $responseData = $apiRequest->sendRefundRequest($refund, $merchant);

                break;
            case 'returnPage':
                //забрать GET-параметры из страницы возврата
                echo '<pre>' . print_r($_GET, true) . '</pre>';
                break;
            default:
                throw new PaymentException('Метод не поддерживается');
        }
    } catch (PaymentException $e) {
        //TODO: добавить проверки и выброс исключений
        //TODO: добавить в исключения ссылки на документацию
        echo $e->getHtmlMessage();
    }
}

include 'example_template.html';

