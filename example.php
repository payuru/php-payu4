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


if(isset($_GET['function'])){
    try {
        switch ($_GET['function']) {
            case 'start':
                include './src/Examples/'.$_GET['function'] . '.php';
                break;
            case 'simpleGetPaymentLink':
            case 'getPaymentLink':
            case 'getToken':
                include './src/Examples/start.php';
                include './src/Examples/'.$_GET['function'] . '.php';
                break;


            case 'paymentByToken':
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
                $token = new MerchantToken();
                $token->setTokenHash("8080695611129aa71725c413bd330e9e");

                $auth = new Authorization('CCVISAMC',false);
                $auth->setMerchantToken($token);

                // Создадим и установим авторизацию по типу платежа
                $payment->setAuthorization($auth);

                // Установим токен транзакции
                // Установим номер заказа (должен быть уникальным в вашей системе)
                $payment->setMerchantPaymentReference($merchantPaymentReference);
                // Установим адрес перенаправления пользователя после оплаты
                $payment->setReturnUrl('https://test.u2go.ru/php-api-client/?function=returnPage');
                // Установим клиентское подключение
                $payment->setClient($client);

                // Создадим HTTP-запрос к API
                $apiRequest = new ApiRequest($merchant);
                // Включить режим отладки (закомментируйте или удалите в рабочей программе!)
                $apiRequest->setDebugMode();
                // Переключиться на тестовый сервер (закомментируйте или удалите в рабочей программе!)
                $apiRequest->setSandboxMode();

                $responseData = $apiRequest->sendAuthRequest($auth, $merchant);
                // Преобразуем ответ из JSON в массив
                try {
                    $responseData = json_decode((string) $responseData["response"], true);

                    // Нарисуем кнопку оплаты 5
//                    echo Std::drawYpmnButton([
//                        'url' => $responseData["paymentResult"]['url']
//                    ]);

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
                $capture->setYpmnPaymentReference(2297597);

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

                break;
            case 'paymentGetStatus':
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
