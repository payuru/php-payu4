# PHP API Client платёжной системы Твои Платежи
Интеграционная библиотека (PHP SDK, или готовый клиент для нашего API) + примеры использования платёжной системы 
Твои Платежи (Your Payments, YPMN). 

![](https://repository-images.githubusercontent.com/638835276/ff494b04-d65b-4843-8759-e85c689a7e80)
 
Эта библиотека содержит подробные [примеры](src/Examples/) с комментариями на русском языке 
и предназначена для быстрой интеграции. Подходит для сайтов, платформ и приложений.

Репозиторий опубликован в виде [пакета Composer](https://packagist.org/packages/yourpayments/php-api-client) и может 
использоваться с любфми фреймворками и CMS.
 
## Требования
[PHP 7.4+](https://github.com/yourpayments/php-api-client/blob/main/composer.json)

## Установка
### Composer
```shell
composer require yourpayments/php-api-client
```

```php
require vendor/autoload.php;
```

### PHP без фреймворков
Клонируйте или скачайте, а затем подключите ([require](https://www.php.net/manual/ru/function.require.php)) файлы этого репозитория.

## Примеры использования
### Функции
1. [Начало работы (настройка интеграции)](src/Examples/start.php)
1. [Cамый простой платёж](src/Examples/simpleGetPaymentLink.php)
2. [Платёж со всеми полями](src/Examples/getPaymentLink.php)
3. [Токенизация карты (чтобы запомнить карту клиента и не вводить повторно)](src/Examples/getToken.php)
4. [Оплата по токену](src/Examples/paymentByToken.php)
5. [Списание средств](src/Examples/paymentCapture.php)
6. [src/Documentation/paymentRefund.md](src/Examples/paymentRefund.php)
7. [Проверка статуса платежа](src/Examples/paymentGetStatus.php)
8. [Страница после оплаты](src/Examples/returnPage.php)


## Ссылки
- [Основной сайт НКО "Твои Платежи"](https://YPMN.ru/)
- [Докуметация по API](https://dev.YPMN.ru/ru/documents/apiv4/)
- [Реквизиты тестовых банковских карт](https://dev.payu.ru/ru/documents/rest-api/testing/#menu-2)
- [Задать вопрос или сообщить о проблеме](https://github.com/yourpayments/php-api-client/issues/new)

-------------
[YPMN.ru](https://YPMN.ru/ "Платёжная система для сайтов и не только")
