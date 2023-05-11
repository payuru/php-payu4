<?php
/**
 * Пример интеграции API многофункциональной платёжной системы Ypmn, версия 4
 * Документация:
 *      https://dev.payu.ru/ru/documents/apiv4/
 *      https://secure.payu.ru/docs/#tag/Payment-API
 * Начните знакомство с кодом с текущего файла
 *  и класса PaymentInterface
 */

use Ypmn\Authorization;
use Ypmn\Delivery;
use Ypmn\IdentityDocument;
use Ypmn\Merchant;
use Ypmn\Payment;
use Ypmn\Client;
use Ypmn\Billing;
use Ypmn\ApiRequest;
use Ypmn\PaymentException;
use Ypmn\Product;
use Ypmn\Capture;
use Ypmn\Refund;
use Ypmn\Std;

// TODO: нужен публичный тестовый мерчант, которого можно включить в документацию
// Создадим тестового мерчанта
//$merchant = new Merchant('rudevru1', 'hE9I1?3@|C8@w[1I&=y)');
$merchant = new Merchant('CC1', 'SECRET_KEY');
//ePayment Code: и Secret

if(isset($_GET['function'])){
    try {
        switch ($_GET['function']) {
            case 'simpleGetPaymentLink':
                // Оплата по ссылке Ypmn
                // Минимальный набор полей

                // Представим, что мы не хотим передавать товары, только номер заказа и сумму
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
                // Создадим и установим авторизацию по типу платежа
                $payment->setAuthorization(new Authorization('CCVISAMC',true));
                // Установим номер заказа (должен быть уникальным в вашей системе)
                $payment->setMerchantPaymentReference($merchantPaymentReference);
                // Установим адрес перенаправления пользователя после оплаты
                $payment->setReturnUrl('http://127.0.0.1:8080/?function=returnPage');
                // Установим клиентское подключение
                $payment->setClient($client);

                // Создадим HTTP-запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Включить режим отладки (удалите в рабочей программе!)
                $apiRequest->setDebugMode();
                // Переключиться на тестовый сервер (удалите в рабочей программе!)
                $apiRequest->setSandboxMode();
                // Отправим запрос
                $responseData = $apiRequest->sendAuthRequest($payment, $merchant);
                // Преобразуем ответ из JSON в массив
                try {
                    $responseData = json_decode((string) $responseData["response"], true);

                    // Нарисуем кнопку оплаты
                    echo Std::drawYpmnButton([
                        'url' => $responseData["paymentResult"]['url'],
                        'sum' => $payment->sumProductsAmount(),
                    ]);

                    // .. или сделаем редирект на форму оплаты (опционально)
                    // Std::redirect($responseData["paymentResult"]['url']);
                } catch (Exception $exception) {
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
                break;
            case 'getPaymentLink':
                // Оплата по ссылке Ypmn
                // Представим, что нам надо оплатить пару позиций: Синий Мяч и Жёлтый Круг

                // Опишем первую позицию
                $product1 = new Product;
                // Установим Наименование (название товара или услуги)
                $product1->setName('Синий Квадрат');
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
                    'name'  => 'Оранжевый Круг',
                    'sku'  => 'toy-15',
                    'unitPrice'  => 160000,
                    'quantity'  => 3,
                    'vat'  => 0,
                ]);

                // Опишем Биллинговую (платёжную) информацию
                $billing = new Billing;
                // Установим Код страны
                $billing->setCountryCode('RU');
                // Установим Город
                $billing->setCity('Москва');
                // Установим Регион
                $billing->setState('Центральный регион');
                // Установим Адрес Плательщика (первая строка)
                $billing->setAddressLine1('Улица Старый Арбат, дом 10');
                // Установим Адрес Плательщика (вторая строка)
                $billing->setAddressLine1('Офис Ypmn');
                // Установим Почтовый Индекс Плательщика
                $billing->setZipCode('121000');
                // Установим Имя Плательщика
                $billing->setFirstName('Иван');
                // Установим Фамилия Плательщика
                $billing->setLastName('Петров');
                // Установим Телефон Плательщика
                $billing->setPhone('+79670660742');
                // Установим Email Плательщика
                $billing->setEmail('test1@ypmn.ru');

                // (необязательно) Опишем Доствку и принимающее лицо
                $delivery = new Delivery;
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
                $delivery->setAddressLine1('Офис Ypmn');
                // Установим Почтовый Индекс Лица, принимающего заказ
                $delivery->setZipCode('121000');
                // Установим Имя Лица, принимающего заказ
                $delivery->setFirstName('Мария');
                // Установим Фамилия Лица, принимающего заказ
                $delivery->setLastName('Петрова');
                // Установим Телефон Лица, принимающего заказ
                $delivery->setPhone('+79670660743');
                // Установим Email Лица, принимающего заказ
                $delivery->setEmail('test2@ypmn.ru');
                // Установим Название Компании, в которой можно оставить заказ
                $delivery->setCompanyName('ООО "Вектор"');

                // Создадим клиентское подключение
                $client = new Client;
                // Установим биллинг
                $client->setBilling($billing);
                // Установим доставку
                $client->setDelivery($delivery);
                // Установим IP (автоматически)
                $client->setCurrentClientIp();
                // И Установим время (автоматически)
                $client->setCurrentClientTime();

                // Создадим платёж
                $payment = new Payment;
                // Установим позиции
                $payment->addProduct($product1);
                $payment->addProduct($product2);
                // Установим валюту
                $payment->setCurrency('RUB');
                // Создадим и установим авторизацию по типу платежа
                $payment->setAuthorization(new Authorization('CCVISAMC',true));
                // Установим номер заказа (должен быть уникальным в вашей системе)
                $payment->setMerchantPaymentReference('primer_nomer__' . time());
                // Установим адрес перенаправления пользователя после оплаты
                $payment->setReturnUrl('http://127.0.0.1:8080/?function=returnPage');
                // Установим клиентское подключение
                $payment->setClient($client);

                // Создадим HTTP-запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Включить режим отладки (удалите в рабочей программе!)
                $apiRequest->setDebugMode();
                // Переключиться на тестовый сервер (удалите в рабочей программе!)
                $apiRequest->setSandboxMode();
                // Отправим запрос
                $responseData = $apiRequest->sendAuthRequest($payment, $merchant);
                // Преобразуем ответ из JSON в массив
                try {
                    $responseData = json_decode((string) $responseData["response"], true);

                    // Нарисуем кнопку оплаты
                    echo Std::drawYpmnButton([
                        'url' => $responseData["paymentResult"]['url'],
                        'sum' => $payment->sumProductsAmount(),
                    ]);

                    // Либо сделаем редирект (перенаправление) браузера по адресу оплаты:
                    // echo Std::redirect($responseData["paymentResult"]['url']);
                } catch (Exception $exception) {
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
                break;

            case 'paymentCapture':
                // Запрос на списание денег
                // В зависимости от настройки мерчанта, Ypmn может списывать денежные средства автоматически,
                // Либо с помощью дополнительного запроса, описанного ниже.

                // Создадим такой запрос:
                $capture = (new Capture);

                // Номер платежа Ypmn (возвращается в ответ на запрос на авторизацию в JSON Response)
                $capture->setPayuPaymentReference(2297597);

                // Cумма исходной операции на авторизацию
                $capture->setOriginalAmount(5300);
                // Cумма фактического списания
                $capture->setAmount(3700);
                // Валюта
                $capture->setCurrency('RUB');

                // Создадим HTTP-запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Включить режим отладки (удалите в рабочей программе!)
                $apiRequest->setDebugMode();
                // Переключиться на тестовый сервер (удалите в рабочей программе!)
                $apiRequest->setSandboxMode();
                // Отправим запрос к API
                $responseData = $apiRequest->sendCaptureRequest($capture, $merchant);

                break;
            case 'paymentGetStatus':
                // Получить номер транзакции в Ypmn

                // Номер заказа
                $merchantPaymentReference = 'primer_nomer__184';
                // Создадим HTTP-запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Включить режим отладки (удалите в рабочей программе!)
                $apiRequest->setDebugMode();
                // Переключиться на тестовый сервер (удалите в рабочей программе!)
                $apiRequest->setSandboxMode();
                // Отправим запрос к API
                $responseData = $apiRequest->sendStatusRequest($merchantPaymentReference);

                break;
            case 'paymentWebhook':
                //сформировать вебхук
                break;
            case 'paymentRefund':
                // Инициировать возврат средств

                // Создадим запрос
                $refund = (new Refund);

                // Установим номер платежа Ypmn - возвращается в ответ на запрос на авторизацию платежа в JSON Response
                // См. пример с запросом Payment выше
                $refund->setPayuPaymentReference(2297597);
                // Cумма исходной операции на авторизацию
                $refund->setOriginalAmount(3700);
                // Cумма фактического списания
                $refund->setAmount(3700);
                // Установим валюту
                $refund->setCurrency('RUB');
                // Создадим HTTP-запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Включить режим отладки (удалите в рабочей программе!)
                $apiRequest->setDebugMode();
                // Переключиться на тестовый сервер (удалите в рабочей программе!)
                $apiRequest->setSandboxMode();
                // Отправим запрос к API
                $responseData = $apiRequest->sendRefundRequest($refund, $merchant);
                break;

            case 'returnPage':
                // Страница после оплаты:
                echo '<h1>Благодарим за оплату</h1>Чек выслан вам на почту.';
                echo '<pre>$_GET: ' . print_r($_GET, true) . '</pre>';
                echo '<pre>$_POST: ' . print_r($_POST, true) . '</pre>';
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
