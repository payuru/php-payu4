<?php
/**
 * Страница после оплаты.
 * Параметры передаются в $_GET или $_POST, в зависимости от настройки мерчанта в YPMN:
 */
$statusResponseFromServer = (json_decode($_POST['body'] ?? '{}', true))['status'] ?? null;

if ($statusResponseFromServer === 'SUCCESS') {
    echo '<h1>Благодарим за оплату</h1>Чек выслан вам на почту.<br/><br/>';
} elseif ($statusResponseFromServer) {
    echo '<h1>Оплата не прошла</h1>';
    $messageResponseFromServer = (json_decode($_POST['body'], true))['message'] . '<br/><br/>' ?? '';
    echo $messageResponseFromServer;
}

echo '<pre>$_GET: ' . print_r($_GET, true) . '</pre>';
echo '<pre>$_POST: ' . print_r($_POST, true) . '</pre>';
