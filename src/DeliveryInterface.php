<?php

namespace payuru\phpPayu4;

interface DeliveryInterface
{
    /**
     * Установить Имя
     * @param string $firstName Имя
     * @return $this
     */
    public function setFirstName(string $firstName) : self;

    /**
     * Получить Имя
     * @return null|string Имя
     */
    public function getFirstName() : ?string;

    /**
     * Установить Фамилию
     * @param string $lastName Фамилия
     * @return $this
     */
    public function setLastName(string $lastName) : self;

    /**
     * Получить Фамилию
     * @return null|string Фамилия
     */
    public function getLastName() : ?string;

    /**
     * Установить Email
     * @param string $email Email
     * @return $this
     */
    public function setEmail(string $email) : self;

    /**
     * Получить Email
     * @return null|string Email
     */
    public function getEmail() : ?string;

    /**
     * Установить Номер телефона
     * @param string $phone Номер телефона
     * @return $this
     */
    public function setPhone(string $phone) : self;

    /**
     * Получить Номер телефона
     * @return null|string
     */
    public function getPhone() : ?string;

    /**
     * Установить Код Страны
     * @param string $countryCode Код Страны
     * @return $this
     */
    public function setCountryCode(string $countryCode) : self;

    /**
     * Получить Код Страны
     * @return null|string Код Страны
     */
    public function getCountryCode() : ?string;

    /**
     * Установить Регион
     * @param string $state Регион
     * @return $this
     */
    public function setState(string $state) : self;

    /**
     * Получить Регион
     * @return null|string Регион
     */
    public function getState() : ?string;

    /**
     * Установить Город
     * @param string $city
     * @return $this
     */
    public function setCity(string $city) : self;

    /**
     * Получить Город
     * @return null|string
     */
    public function getCity() : ?string;

    /**
     * Установить Адрес - Первую Строку
     * @param string $addressLine1 Адрес - Первая Строка
     * @return $this
     */
    public function setAddressLine1(string $addressLine1) : self;

    /**
     * Получить Адрес - Первую Строку
     * @return null|string Адрес - Первая Строка
     */
    public function getAddressLine1() : ?string;

    /**
     * Получить Адрес - Вторую Строку
     * @param string $addressLine2 Адрес - Вторую Строку
     * @return $this
     */
    public function setAddressLine2(string $addressLine2) : self;

    /**
     * Установить Адрес - Вторую Строку
     * @return null|string Адрес - Вторая Строка
     */
    public function getAddressLine2() : ?string;

    /**
     * Установить Почтовый Индекс
     * @param string $zipCode Почтовый Индекс
     * @return DeliveryInterface
     */
    public function setZipCode(string $zipCode) : self;

    /**
     * Плучить Почтовый Индекс
     * @return null|string Почтовый Индекс
     */
    public function getZipCode() : ?string;

    /**
     * Установить Наименование Компании
     * @param string $companyName Наименование Компании
     * @return $this
     */
    public function setCompanyName(string $companyName): self;

    /**
     * Плучить Наименование Компании
     * @return null|string Наименование Компании
     */
    public function getCompanyName(): ?string;

    /**
     * Установить Удостоверение личности
     * @param IdentityDocumentInterface $identityDocument Удостоверение личности
     * @return $this
     */
    public function setIdentityDocument(IdentityDocumentInterface $identityDocument): self;

    /**
     * Получить Удостоверение личности
     * @return IdentityDocumentInterface|null Удостоверение личности
     */
    public function getIdentityDocument(): ?IdentityDocumentInterface;
}
