<?php

namespace payuru\phpPayu4;

interface CardDetailsInterface
{
    /**
     * Установить Номер карты
     * @param string $number Номер карты
     * @return $this
     */
    public function setNumber(string $number) : self;

    /**
     * Получить Номер карты
     * @return string Номер карты
     */
    public function getNumber() : string;

    /**
     * Установить Месяц прекращения действия Карты
     * @param int $month Месяц прекращения действия Карты
     * @return $this
     * @throws PaymentException
     */
    public function setExpiryMonth(int $month) : self;

    /**
     * Получить Месяц прекращения действия Карты
     * @return int
     */
    public function getExpiryMonth() : int;

    /**
     * Установить Год прекращения действия Карты
     * @param int $year Год прекращения действия Карты
     * @return $this
     * @throws PaymentException
     */
    public function setExpiryYear(int $year) : self;

    /**
     * Получить Год прекращения действия Карты
     * @return int Год прекращения действия Карты
     */
    public function getExpiryYear() : int;

    /**
     * Установить CVV Карты
     * @param int $code CVV Карты
     * @return $this
     */
    public function setCvv(int $code) : self;

    /**
     * Получить CVV Карты
     * @return int CVV Карты
     */
    public function fetCvv() : int;

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

    /**
     * Установить Время набора Номера Карты (сек)
     * @param int $timeSpentTypingNumber Время набора Номера Карты (сек)
     * @return $this
     */
    public function setTimeSpentTypingNumber(int $timeSpentTypingNumber) : self;

    /**
     * Получить Время набора номера Карты (сек)
     * @return int Время набора Номера Карты (сек)
     */
    public function getTimeSpentTypingNumber() : int;

    /**
     * Установить Время набора Имени Владельца Карты (сек)
     * @param int $timeSpentTypingOwner Время набора Имени Владельца Карты (сек)
     * @return $this
     */
    public function setTimeSpentTypingOwner(int $timeSpentTypingOwner) : self;

    /**
     * Получить Время набора Имени Владельца Карты
     * @return int Время набора Имени Владельца Карты (сек)
     */
    public function getTimeSpentTypingOwner() : int;
}
