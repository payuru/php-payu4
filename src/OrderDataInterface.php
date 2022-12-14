<?php

namespace payuru\phpPayu4;

interface OrderDataInterface
{

    /**
     * Получить Дату Заказа
     * @return string Дата Заказа
     */
    public function getOrderDate(): string;

    /**
     * Установть Дату Заказа
     * @param string $orderDate
     * @return $this Дата Заказа
     */
    public function setOrderDate(string $orderDate): self;

    /**
     * Получить Номер Заказа в PayU
     * @return string Номер Заказа в PayU
     */
    public function getPayuPaymentReference(): string;

    /**
     * Установить Номер Заказа в PayU
     * @param string $payuPaymentReference Номер Заказа в PayU
     * @return $this
     */
    public function setPayuPaymentReference(string $payuPaymentReference): self;

    /**
     * Получить Номер Заказа у Мерчанта
     * @return string Номер Заказа у Мерчанта
     */
    public function getMerchantPaymentReference(): string;

    /**
     * Установить Номер Заказа у Мерчанта
     * @param string $merchantPaymentReference
     * @return $this
     */
    public function setMerchantPaymentReference(string $merchantPaymentReference): self;

    /**
     * Получить Состояние Платежа
     * @return string Состояние Платежа
     */
    public function getStatus(): string;

    /**
     * Установить Состояние Платежа
     * @param string $status Состояние Платежа
     * @return $this
     */
    public function setStatus(string $status): self;

    /**
     * Получить Валюту Платежа
     * @return string Валюта Платежа
     */
    public function getCurrency(): string;

    /**
     * Установить Валюту Платежа
     * @param string $currency Валюта Платежа
     * @return $this
     */
    public function setCurrency(string $currency): self;

    /**
     * Получить Подитог
     * @return float Подитог
     */
    public function getAmount(): ?float;

    /**
     * Установить Подитог
     * @param float $amount Подитог
     * @return $this
     */
    public function setAmount(float $amount): self;

    /**
     * Получить Комиссию
     * @return float Комиссия
     */
    public function getCommission(): ?float;

    /**
     * Установить Комиссию
     * @param float $commission Комиссия
     * @return $this
     */
    public function setCommission(float $commission): self;

    /**
     * Получить
     * @return string
     */
    public function getRefundRequestId(): ?string;

    /**
     * Установить
     * @param string $refundRequestId
     * @return $this
     */
    public function setRefundRequestId(string $refundRequestId): self;

    /**
     * Получить Количество Баллов Лояльности
     * @return string Количество Баллов Лояльности
     */
    public function getLoyaltyPointsAmount(): ?string;

    /**
     * Установить Количество Баллов Лояльности
     * @param string $loyaltyPointsAmount
     * @return $this Количество Баллов Лояльности
     */
    public function setLoyaltyPointsAmount(string $loyaltyPointsAmount): self;

    /**
     * Получить Детализацию Баллов Лояльности
     * @return array|null Детализация Баллов Лояльности
     */
    public function getLoyaltyPointsDetails(): ?array;

    /**
     * Установить Детализацию Баллов Лояльности
     * @param array $loyaltyPointsDetails Детализация Баллов Лояльности
     * @return $this
     */
    public function setLoyaltyPointsDetails(array $loyaltyPointsDetails): self;
}