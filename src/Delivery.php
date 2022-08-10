<?php

namespace payuru\phpPayu4;

/**
 * PayU поддерживает широкие возможности
 * по интеграции с системами доставок.
 * Обратитесь к вашему менеджеру PayU
 * за подробностями
 */
class Delivery implements DeliveryInterface
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $countryCode;
    private string $state;
    private string $addressLine1;
    private string $addressLine2;
    private string $zipCode;

    /**
     * @inheritDoc
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @inheritDoc
     */
    public function setFirstName(string $firstName): Delivery
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @inheritDoc
     */
    public function setLastName(string $lastName): Delivery
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function setEmail(string $email): Delivery
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @inheritDoc
     */
    public function setPhone(string $phone): Delivery
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @inheritDoc
     */
    public function setCountryCode(string $countryCode): Delivery
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @inheritDoc
     */
    public function setState(string $state): Delivery
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    /**
     * @inheritDoc
     */
    public function setAddressLine1(string $addressLine1): Delivery
    {
        $this->addressLine1 = $addressLine1;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    /**
     * @inheritDoc
     */
    public function setAddressLine2(string $addressLine2): Delivery
    {
        $this->addressLine2 = $addressLine2;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @inheritDoc
     */
    public function setZipCode(string $zipCode): Delivery
    {
        $this->zipCode = $zipCode;
        return $this;
    }
}
