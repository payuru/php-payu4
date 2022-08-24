# php-payu4
Примеры использования PayU API v4.
 
PayU - многофункциональная платёжная система, поддерживающая не только простые платежи с банковских карт, но и множество
форм оплаты, а также подписки и выплаты на карты.
 
Данный репозиторий написан по принципам SOLID, и каждый программный интерфейс снабжен подробной документацией на
русском языке.
 
Репозиторий также содержит примеры по принципу "одна строка кода - одна строка документации".

Репозиторий опубликован в виде [пакета Composer](https://packagist.org/packages/payuru/php-payu4) и может использоваться со всеми современными
фреймворками: Laravel, Symfony, Yii и другими.

Для работы рекомендуется использовать любую современную IDE (VS Code, Intellij Idea/PHPStorm,
Eclipse, Netbeans, etc), чтобы получать подробные подсказки прямо во время редактирования кода.
![IDE screenshot](screenshot.jpg "IDE screenshot")


## Требования
Актуальные требования для использования пакета можно посмотреть 
в файле [composer.json](https://github.com/payuru/php-payu4/blob/main/composer.json)
в секции "require"

## Установка
### Composer
[Composer](https://getcomposer.org/) - это инструмент для управления зависимостями в PHP. Он позволяет вам объявить
библиотеки, от которых зависит ваш проект, и он будет управлять ими (устанавливать/обновлять) за вас.
```shell
composer require payuru/php-payu4
```

```php
// Для использования классов, например:
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

// Подключите загрузчик классов от Composer
require vendor/autoload.php;
```

### PHP без фреймворков
Клонируйте или скачайте, а затем подключите файлы этого репозитория

## Примеры использования
### Начало работы
```php
// Создадим объект Мерчанта с помощью Идентификатора Мерчанта и Секретного Ключа Мерчанта
$merchant = new Merchant('rudevru1', 'hE9I1?3@|C8@w[1I&=y)');
```
### Создание (авторизация) платежа
Метод создаёт платёж (транзакцию) в системе PayU.
В зависимости от настройки, средства списываются либо сразу, 
либо после отправки метода "capture". 
```php
<?php
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
$responseData = json_decode((string) $responseData["response"], true);
// Нарисуем кнопку оплаты
echo '<a
    href="'.$responseData["paymentResult"]['url'].'"
    class="btn btn-success"
    target="_b"
    style="font-weight: bolder; color: green;"
    rel="noindex noopener">
        Оплата PayU
    </a>';
```
### Страница пользователя после совершения платежа
Данные о состоянии платежа после его создания передаются в параметрах GET ($_GET)
```php
print_r($_GET);
```
### Получить номер транзакции в PayU (GetStatus)
```php
<php
// Получить номер транзакции в PayU

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
```

### Списание средств (Capture)
В зависимости от настройки мерчанта, PayU может списывать денежные средства автоматически,
// Либо с помощью дополнительного запроса, описанного ниже.
```php
<php
// Запрос на списание денег

// Создадим такой запрос:
$capture = (new Capture);

// Номер платежа PayU (возвращается в ответ на запрос на авторизацию в JSON Response)
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
```
### Отмена платежа (Refund)
```php
<?php
// Инициировать возврат средств

// Создадим запрос
$refund = (new Refund);

// Установим номер платежа PayU - возвращается в ответ на запрос на авторизацию платежа в JSON Response
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
```

## Ссылки
- [Докуметация по API](https://dev.payu.ru/ru/documents/apiv4/)
- [Основной сайт PayU Россия](https://payu.ru/)
- Начните знакомство с кодом с этих файлов: [example.php](https://github.com/payuru/php-payu4/blob/main/example.php) и
  класса [PaymentInterface.php](https://github.com/payuru/php-payu4/blob/main/src/PaymentInterface.php)

-------------
![](https://www.nco-payu.ru/media/images/global/payu@2x.png)
 
[PayU.ru](https://PayU.ru/ "Платёжная система для сайтов и не только")
