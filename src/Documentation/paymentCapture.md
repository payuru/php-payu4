### Списание средств (Capture)
В зависимости от настройки мерчанта, Ypmn может списывать денежные средства автоматически, либо с помощью дополнительного запроса, описанного ниже.
```php
<?php
// Создадим запрос на списание денег:
$capture = (new Capture);

// Номер платежа Ypmn (возвращается в ответ на запрос на авторизацию в JSON Response)
$capture->setPaymentReference(2297597);

// Cумма исходной операции на авторизацию
$capture->setOriginalAmount(5300);
// Cумма фактического списания
$capture->setAmount(3700);
// Валюта
$capture->setCurrency('RUB');

// Создадим HTTP-запрос к API
$apiRequest = new ApiRequest($merchant);
// Включить режим отладки (удалите после окончания интеграции)
$apiRequest->setDebugMode();
// Переключиться на тестовый сервер (удалите после окончания интеграции)
$apiRequest->setSandboxMode();
// Отправим запрос к API
$responseData = $apiRequest->sendCaptureRequest($capture, $merchant);

```
