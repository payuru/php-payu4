# php-payu4
Примеры использования PayU API v4.
 
PayU - многофункциональная платёжная система, поддерживающая не только простые платежи с банковских карт, но и множество форм оплаты, а также подписки и выплаты на карты.
 
## Ссылки
- [Докуметация по API](https://dev.payu.ru/ru/documents/apiv4/)
- [Основной сайт PayU Россия](https://payu.ru/)
- Начните знакомство с кодом с этих файлов: [example.php](https://github.com/payuru/php-payu4/blob/main/example.php) и класса [PaymentInterface.php](https://github.com/payuru/php-payu4/blob/main/src/PaymentInterface.php)

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
echo '<a href="'.$responseData["paymentResult"]['url'].'" class="btn btn-success" target="_b" rel="noopener"> ОПЛАТА </a><br><br><br>';S
```
### Страница пользователя после совершения платежа

### Приём информации о состоянии платежа (webhook)

### Отмена платежа (refund)

### Создание выплаты (payout)

-------------
![](https://www.nco-payu.ru/media/images/global/payu@2x.png)
 
[PayU.ru](https://PayU.ru/ "Платёжная система для сайтов и не только")
