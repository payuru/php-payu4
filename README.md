# Твои Платежи -- интеграция на PHP
PHP SDK, готовый клиент для нашего API + примеры использования платёжной системы

![](https://repository-images.githubusercontent.com/638835276/ff494b04-d65b-4843-8759-e85c689a7e80)
 
Эта библиотека содержит подробные [примеры](src/Examples/) с комментариями на русском языке 
и предназначена для быстрой интеграции. Подходит для сайтов, платформ и приложений.

Репозиторий опубликован в виде [пакета Composer](https://packagist.org/packages/yourpayments/php-api-client) и может 
использоваться с любыми фреймворками и CMS.
 
Требования: [PHP 7.4 и выше](https://github.com/yourpayments/php-api-client/blob/main/composer.json)

## Установка
### Composer
```shell
$ composer require yourpayments/php-api-client
```

```php
<?php

require vendor/autoload.php;
```

### PHP без фреймворков
Клонируйте или скачайте, а затем подключите ([require](https://www.php.net/manual/ru/function.require.php)) файлы этого репозитория.

## Документация: Примеры + комментарии
1. [Начало работы (настройка интеграции)](src/Examples/start.php)
2. [Cамый простой платёж](src/Examples/simpleGetPaymentLink.php)
3. [Подробный платёж](src/Examples/getPaymentLink.php)
4. [Платёж со сплитом](src/Examples/getPaymentLinkMarketplace.php)
5. [Токенизация карты (чтобы запомнить карту клиента и не вводить повторно)](src/Examples/getToken.php)
6. [Оплата токеном](src/Examples/paymentByToken.php)
7. [Списание средств](src/Examples/paymentCapture.php)
8. [Возврат средств](src/Examples/paymentRefund.php)
9. [Возврат средств со сплитом](src/Examples/paymentRefundMarketplace.php)
10. [Проверка статуса платежа](src/Examples/paymentGetStatus.php)
11. [Выплаты на банковские карты](src/Examples/payoutCreate.php)
12. [Запрос отчёта](src/Examples/getReport.php)
13. [Создание сессии](src/Examples/getSession.php)
14. [Оплата одноразовым токеном](src/Examples/oneTimeTokenPayment.php)
15. [Страница после оплаты](src/Examples/returnPage.php)
16. [Безопасные поля (Secure fields)](src/Examples/secureFields.php)

## Ссылки
- [Основной сайт НКО "Твои Платежи"](https://YPMN.ru/)
- [Докуметация по API](https://dev.YPMN.ru/ru/documents/apiv4/)
- [Реквизиты тестовых банковских карт](https://dev.payu.ru/ru/documents/rest-api/testing/#menu-2)
- [Задать вопрос или сообщить о проблеме](https://github.com/yourpayments/php-api-client/issues/new)
- [Документация Composer](https://getcomposer.org/)

-------------
[НКО "Твои Платежи"](https://YPMN.ru/ "Платёжная система для сайтов, платформ и приложений") - платёжная система для сайтов, платформ, игр и приложений.
