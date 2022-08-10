<?php

namespace payuru\phpPayu4;

interface ClientInterface
{
    /**
     * Установить биллинговую информацию
     * @param BillingInterface $billing
     * @return ClientInterface
     */
    public function setBilling(BillingInterface $billing) : self;

    /**
     * Получить биллинговую информацию
     * @return BillingInterface
     */
    public function getBilling() : BillingInterface;

    /**
     * Установить IP текущего посетителя
     * @return ClientInterface
     */
    public function setCurrentClientIp() : self;

    /**
     * Установить IP посетителя в явном виде
     * @param string $clientIp
     * @return $this
     */
    public function setClientIp(string $clientIp) : self;

    /**
     * Получить IP
     * @return string
     */
    public function getClientIp() : string;

    /**
     *
     * Установить текущее Время оплаты
     * @return $this
     */
    public function setCurrentClientTime() : self;

    /**
     * Установить Время оплаты в явном виде
     * @param string $clientTime
     * @return $this
     */
    public function setClientTime(string $clientTime) : self;

    /**
     * Получить Время оплаты
     * @return string
     */
    public function getClientTime() : string;

    /**
     * Установить Подробности доставки
     * @param DeliveryInterface $delivery
     * @return $this
     */
    public function setDelivery(DeliveryInterface $delivery) : self;

    /**
     * Получить Подробности доставки
     * @return DeliveryInterface
     */
    public function getDelivery() : DeliveryInterface;

    /**
     * Преобразовать в массив
     * @return mixed объект в виде массива
     */
    public function arraySerialize();
}