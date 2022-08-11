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
use payuru\phpPayu4\Merchant;
use payuru\phpPayu4\Payment;
use payuru\phpPayu4\Client;
use payuru\phpPayu4\Billing;
use payuru\phpPayu4\PaymentsApiRequest;
use payuru\phpPayu4\PaymentException;
use payuru\phpPayu4\Product;
use payuru\phpPayu4\Capture;
use payuru\phpPayu4\CaptureApiRequest;

// TODO: нужен публичный тестовый мерчант, которого можно включить в документацию
// Создадим тестового мерчанта
$merchant = new Merchant('rudevru1', 'hE9I1?3@|C8@w[1I&=y)');

if(isset($_GET['function'])){
    try {
        //TODO: надо реально создать эти функции в классе PaymentsApiRequest
        switch ($_GET['function']) {
            case 'getPaymentLink':
                // получение ссылки на оплату заказа

                // нам надо оплатить пару товаров или услуг
                $product1 = new Product([
                    'name'  => 'Синий Мяч',
                    'sku'  => 'ball-05',
                    'unitPrice'  => '500',
                    'quantity'  => '1',
                    'vat'  => '20',
                ]);

                $product2 = new Product([
                    'name'  => 'Жёлтый Круг',
                    'sku'  => 'toy-15',
                    'unitPrice'  => '1600',
                    'quantity'  => '3',
                    'vat'  => '12',
                ]);

                // опишем биллинговую информацию
                $billing = (new Billing)
                    ->setCountryCode('RU')
                    ->setCity('Москва')
                    ->setState('Центральный регион')
                    ->setFirstName('Иван')
                    ->setLastName('Петров')
                    ->setPhone('+79670660742')
                    ->setEmail('test@payu.ru');

                // создадим клиента
                $client = (new Client)
                    ->setBilling($billing)
                    ->setCurrentClientIp()
                    ->setCurrentClientTime();

                // создадим тестовый платёж
                $payment = (new Payment)
                    ->setCurrency('RUB')
                    ->addProduct($product1)
                    ->addProduct($product2)
                    ->setAuthorization(new Authorization('CCVISAMC',true))
                    ->setMerchantPaymentReference('primer_nomer__' . rand(1,999))
                    ->setReturnUrl('http://127.0.0.1:8080/?function=returnPage')
                    ->setClient($client);

                // TODO: добавить функцию debug
                echo '<pre>'.json_encode($payment, JSON_PRETTY_PRINT).'</pre>';

                $paymentRequest = new PaymentsApiRequest();
                $responseData = $paymentRequest->sendRequest($payment, $merchant);
                echo '<pre>' . print_r($responseData, true) . '</pre>';

                $responseData = json_decode((string) $responseData["response"], true);
                echo '<a href="'.$responseData["paymentResult"]['url'].'" class="btn btn-success" target="_b" rel="noopener"> ОПЛАТА </a><br><br><br>';
                break;

            case 'paymentCapture':
                // списание денег
                // Номер платежа PayU (возвращается в ответ на запрос на авторизацию в JSON Response
                $payuPaymentReference = 2327088;

                // Cумма исходной операции на авторизацию
                $originalAmount = 5300;

                //Cумма фактического списания
                $amount = 3700;

                $product1 = new Product([
                    'sku'  => 'ball-05',
                    'amount'  => '500',
                ]);

                $product2 = new Product([
                    'sku'  => 'toy-15',
                    'amount'  => '3200',
                ]);

                // TODO: $payuPaymentReference = 2277166
                // TODO: code: 400, status:PRODUCTS_NOT_SUPPORTED | закомментил продукты в запросе
                // TODO: code: 400, status:PARTIAL_AMOUNT_NOT_SUPPORTED, Partial amount is not supported or enabled | Поставил 5300 из 5300
                // TODO: "code":500,"status":"ERROR_CONFIRMING_ORDER","message":"Error confirming order"

                // TODO: $payuPaymentReference = 2317336
                // TODO: code:200, status:SUCCESS, message:Confirmed"

                // TODO: $payuPaymentReference = 2327088
                // TODO: code: 400, status:PRODUCTS_NOT_SUPPORTED | закомментил продукты в запросе
                // TODO: code:200, status:SUCCESS, message:Confirmed" | Частичное списание поддерживается уже, списалось 3700

                $capture = (new Capture)
                    ->setPayuPaymentReference($payuPaymentReference)
                    ->setOriginalAmount($originalAmount)
                    ->setAmount($amount)
                    ->setCurrency('RUB')
                    ->addProduct($product1)
                    ->addProduct($product2);

                echo '<pre>'.json_encode($capture, JSON_PRETTY_PRINT).'</pre>';

                $captureRequest = new CaptureApiRequest();
                $responseData = $captureRequest->sendRequest($capture, $merchant);
                echo '<pre>' . print_r($responseData, true) . '</pre>';

                break;
            case 'paymentWebhook':
                //сформировать вебхук
                break;
            case 'paymentRefound':
                //инициировать возврат
                break;
            case 'returnPage':
                //забрать GET-параметры из страницы возврата
                print_r($_REQUEST);
                print_r($_GET);
                break;
            default:
                throw new PaymentException('method not allowed');
        }
    } catch (PaymentException $e) {
        //TODO: добавить проверки и выброс исключений
        //TODO: добавить в исключения ссылки на документацию
        echo $e->getHtmlMessage();
    }
}

include 'example_template.html';

