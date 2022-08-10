<?php

namespace payuru\phpPayu4;

interface AuthorizationInterface
{
    /**
     * Установить Cпособ оплаты (из справочника)
     * @param string $paymentMethodType Cпособ оплаты (из справочника)
     * @return AuthorizationInterface
     */
    public function setPaymentMethod(string $paymentMethodType) : self;

    /**
     * Получить Cпособ оплаты (из справочника)
     * @return string Cпособ оплаты (из справочника)
     */
    public function getPaymentMethod(): string;

    /**
     * Установить Использование платёжной страницы
     * @param bool $isUsed Использовать платёжную страницу
     * @return AuthorizationInterface
     */
    public function setUsePaymentPage(bool $isUsed) : self;

    /**
     * Получить Использование платёжной страницы
     * @return bool Использование платёжной страницы
     */
    public function getUsePaymentPage() : bool;
}
