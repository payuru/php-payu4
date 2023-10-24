<?php

declare(strict_types=1);

$examples = [
    'start' => [
        'name'  => 'Начало работы',
        'about'  => '
                Первый шаг интеграции с YPMN API &ndash; это получение кода мерчанта и секретного ключа после <a href="https://ypmn.ru/ru/connect/?utm_source=header_btn_1">подключения</a> (спросите у Вашего менеджера). 
                <br>
                <br>Они нужны для отправки всех запросов к API.
                <br>
                <br>На стороне клиента они используются для создания объекта Merchant (смотрите <a href="https://github.com/yourpayments/php-api-client/blob/main/src/Examples/start.php">файл с примером</a>).
                
        ',
        'docLink'  => '',
        'link'  => '',
    ],
    'simpleGetPaymentLink' => [
        'name'  => 'Самая простая кнопка оплаты',
        'about'  => 'В этом примере показана самая простая реализация. С минимальным набором полей без детализации, просто оплата заказа c определённой суммой.',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1authorize/post',
        'link'  => '',
    ],
    'getPaymentLink' => [
        'name'  => 'Подробный платёж',
        'about'  => 'Это пример платежа с максимальным набором полей.',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1authorize/post',
        'link'  => '',
    ],
    'getPaymentLinkMarketplace' => [
        'name'  => 'Платёж со сплитом',
        'about'  => 'Это пример платежа со сплитом (разделением оплаты на несколько плательщиков).',
        'docLink'  => '',
        'link'  => '',
    ],
    'getToken' => [
        'name'  => 'Создание токена',
        'about'  => 'Приложение передаёт номер успешно оплаченного заказа в YPMN API, и получает в ответ платёжный токен',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Token-API/paths/~1v4~1token/post',
        'link'  => '',
    ],
    'paymentByToken' => [
        'name'  => 'Оплата токеном',
        'about'  => 'Оплата с помощью токена (теперь не нужно повторно вводить данные банковской карты)',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1authorize/post',
        'link'  => '',
    ],
    'paymentCapture' => [
        'name'  => 'Списание средств',
        'about'  => 'Списание ранее заблокированной на счету суммы. Не обязательно, если у Вас настроена оплата в 1 шаг.',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1capture/post',
        'link'  => '',
    ],
    'paymentRefund' => [
        'name'  => 'Возврат средств',
        'about'  => 'Запрос на полный или частичный возврат средств.',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1refund/post',
        'link'  => '',
    ],
    'paymentRefundMarketplace' => [
        'name'  => 'Возврат средств со сплитом',
        'about'  => 'Запрос на полный или частичный возврат средств с разделением на несколько получателей.',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1refund/posts',
        'link'  => '',
    ],
    'paymentGetStatus' => [
        'name'  => 'Проверка статуса платежа',
        'about'  => 'Запрос к YPMN API о состоянии платежа.',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1status~1{merchantPaymentReference}/get',
        'link'  => '',
    ],
    'payoutCreate' => [
        'name'  => 'Создание выплаты',
        'about'  => 'Запрос к YPMN для совершения выплаты на карту (для компаний, сертифицированных по PCI-DSS). У вас должно быть достаточно средств на специальном счету для выплат.<br><br>Тестовая карта (для выплат на тестовом контуре): 4149605380309302',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payouts-API',
        'link'  => '',
    ],
    'getReport' => [
        'name'  => 'Запрос отчёта',
        'about'  => 'Запрос к YPMN для генерации отчёта',
        'docLink'  => 'https://dev.ypmn.ru/ru/documents/api-dlia-otchetov/',
        'link'  => '',
    ],
    'getSession' => [
        'name'  => 'Создание сессии',
        'about'  => 'Создание уникальной сессии YPMN',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Sessions/paths/~1v4~1payments~1sessions/post',
        'link'  => '',
    ],
    'oneTimeTokenPayment' => [
        'name'  => 'Оплата одноразовым токеном',
        'about'  => 'Оплата одноразовым токеном',
        'docLink'  => 'https://secure.ypmn.ru/docs/#tag/Payment-API/paths/~1v4~1payments~1authorize/post',
        'link'  => '',
    ],
    'returnPage' => [
        'name'  => 'Страница после оплаты',
        'about'  => 'Это пример странцы, на которую плательщик возвращается после совершения платежа.',
        'docLink'  => '',
        'link'  => '',
    ],
];
