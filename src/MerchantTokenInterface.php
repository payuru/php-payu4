<?php

namespace Ypmn;

interface MerchantTokenInterface
{
    /**
     * Установить Хэш Токен карты
     * @param string $tokenHash Хэш Токен карты
     * @return $this
     */
    public function setTokenHash(string $tokenHash) : self;

    /**
     * Получить Хэш Токен карты
     * @return string $tokenHash Хэш Токен карты
     */
    public function getTokenHash() : string;

    /**
     * Установить CVV Карты
     * @param string $cvv CVV Карты
     * @return $this
     */
    public function setCvv(string $cvv) : self;

    /**
     * Получить CVV Карты
     * @return string CVV Карты
     */
    public function getCvv() : string;

    /**
     * Установить Имя Владельца Карты
     * @param string $owner Имя Владельца Карты
     * @return $this
     */
    public function setOwner(string $owner) : self;

    /**
     * Получить Имя Владельца Карты
     * @return string Имя Владельца Карты
     */
    public function getOwner() : string;
}
