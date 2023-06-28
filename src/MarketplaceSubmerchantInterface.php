<?php

namespace Ypmn;

/**
 * Это объект Сабмерчанта (для маркетплейса)
 */
interface MarketplaceSubmerchantInterface
{
    /**
     * Установить Код Сабмерчанта (для маркетплейса)
     * @param string $merchantCode
     * @return $this
     */
    public function setMerchantCode(string $merchantCode) : self;

    /**
     * Получить Код Сабмерчанта (для маркетплейса)
     * @return string
     */
    public function getMerchantCode() : string;

    /**
     * Установить Сумму
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount) : self;

    /**
     * Получить Сумму
     * @return int
     */
    public function getAmount() : int;


    /**
     * Преобразовать в массив
     * @return mixed объект в виде массива
     */
    public function arraySerialize();
}
