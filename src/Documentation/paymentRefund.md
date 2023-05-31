### Отмена платежа и возврат средств (Refund)
```php
<?php
// Инициировать возврат средств

// Создадим запрос
$refund = (new Refund);

// Установим номер платежа Ypmn - возвращается в ответ на запрос на авторизацию платежа в JSON Response
// См. пример с запросом Payment выше
$refund->setPaymentReference(2297597);
// Cумма исходной операции на списание (Capture)
// Пример: если сумма авторизации была 5300, а сумма списания 3700 (частичное списание), указать 3700 
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
