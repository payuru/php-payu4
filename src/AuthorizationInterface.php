<?php

namespace Ypmn;

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
     * Получить Данные Карты
     * @return CardDetailsInterface Данные Карты
     */
    public function getCardDetails(): ?CardDetailsInterface;

    /**
     * Установить Данные Карты
     * @param CardDetailsInterface $cardDetails
     * @return Authorization
     */
    public function setCardDetails(CardDetailsInterface $cardDetails): self;

    /**
     * Получить Использование платёжной страницы
     * @return bool Использование платёжной страницы
     */
    public function getUsePaymentPage() : bool;

    /**
     * Получить Токен мерчанта
     * @return MerchantTokenInterface|null Токен мерчанта
     */
    public function getMerchantToken(): ?MerchantTokenInterface;

    /**
     * Установить Токен мерчанта
     * @param MerchantTokenInterface|null $merchantToken Токен мерчанта
     * @return $this
     */
    public function setMerchantToken(?MerchantTokenInterface $merchantToken): self;
}
