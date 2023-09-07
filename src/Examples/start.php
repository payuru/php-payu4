<?php

declare(strict_types=1);

use Ypmn\Merchant;

/**
 * Создадим объект Мерчанта
 * (получите Интеграционный Код Мерчанта и Секретный Ключ у вашего менеджера YPMN)
 *
 * Теперь включайте этот файл везде, где работаете с платежами
 *
 * Запросы от вашего приложения будут отправляться на:
 *      https://secure.ypmn.ru/
 *      https://sandbox.ypmn.ru/
 * Убедитесь, что эти адреса разрешены в вашем Firewall
 */
$merchant = new Merchant('CC1', 'SECRET_KEY');
