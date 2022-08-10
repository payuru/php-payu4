<?php

namespace payuru\phpPayu4;

interface DeliveryInterface
{
    /**
     * Получить Имя
     * @param string $firstName Имя
     * @return $this
     */
    public function setFirstName(string $firstName) : self;

    /**
     * Установить Имя
     * @return string Имя
     */
    public function getFirstName() : string;

    /**
     * Установить Фамилию
     * @param string $lastName Фамилия
     * @return $this
     */
    public function setLastName(string $lastName) : self;

    /**
     * Получить Фамилию
     * @return string Фамилия
     */
    public function getLastName() : string;

    /**
     * Установить Email
     * @param string $email Email
     * @return $this
     */
    public function setEmail(string $email) : self;

    /**
     * Получить Email
     * @return string Email
     */
    public function getEmail() : string;

    /**
     * Установить Номер телефона
     * @param string $phone Номер телефона
     * @return $this
     */
    public function setPhone(string $phone) : self;

    /**
     * Получить Номер телефона
     * @return string
     */
    public function getPhone() : string;

    /**
     * Установить Код Страны
     * @param string $countryCode Код Страны
     * @return $this
     */
    public function setCountryCode(string $countryCode) : self;

    /**
     * Получить Код Страны
     * @return string Код Страны
     */
    public function getCountryCode() : string;

    /**
     * Установить Регион
     * @param string $state Регион
     * @return $this
     */
    public function setState(string $state) : self;

    /**
     * Получить Регион
     * @return string Регион
     */
    public function getState() : string;

    /**
     * Установить Адрес - Первую Строку
     * @param string $addressLine1 Адрес - Первая Строка
     * @return $this
     */
    public function setAddressLine1(string $addressLine1) : self;

    /**
     * Получить Адрес - Первую Строку
     * @return string Адрес - Первая Строка
     */
    public function getAddressLine1() : string;

    /**
     * Получить Адрес - Вторую Строку
     * @param string $addressLine2 Адрес - Вторую Строку
     * @return $this
     */
    public function setAddressLine2(string $addressLine2) : self;

    /**
     * Установить Адрес - Вторую Строку
     * @return string Адрес - Вторая Строка
     */
    public function getAddressLine2() : string;

    /**
     * Установить Почтовый Индекс
     * @param string $zipCode Почтовый Индекс
     * @return DeliveryInterface
     */
    public function setZipCode(string $zipCode) : self;

    /**
     * Плучить Почтовый Индекс
     * @return string Почтовый Индекс
     */
    public function getZipCode() : string;
}
