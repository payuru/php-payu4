# php-payu4
Примеры использования PayU API v4

[TOC]

## Ссылки
- ['Докуметация по API'](https://dev.payu.ru/ru/documents/apiv4/)
- ['Основной сайт PayU Россия'](https://payu.ru/)

## Установка
### Composer
```php
<?php

```
### Laravel
```php
<?php

```
### PHP без фреймворков
```php
<?php

```
## Примеры использования
### Создание (авторизация) платежа
Метод создаёт платёж (транзакцию) в системе PayU.
В зависимости от настройки, средства списываются либо сразу, 
либо после отправки метода "capture". 
```php
<?php
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

$paymentRequest = new PaymentsApiRequest();
$responseData = $paymentRequest->sendRequest($payment, $merchant);

$responseData = json_decode((string) $responseData["response"], true);
echo '<a href="'.$responseData["paymentResult"]['url'].'" class="btn btn-success" target="_b" rel="noopener"> ОПЛАТА </a>';
```
### Страница пользователя после совершения платежа

### Приём информации о состоянии платежа (webhook)

### Отмена платежа (refund)

### Создание выплаты (payout)

-------------
![](https://www.nco-payu.ru/media/images/global/payu@2x.png)
 
[PayU.ru](https://PayU.ru/ "Платёжная система для сайтов и не только")
