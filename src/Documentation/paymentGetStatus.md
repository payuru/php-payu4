### Получить состояние транзакции в YourPayments (GetStatus)
```php
<php
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
```
