<?php

namespace payuru\phpPayu4;

class Billing implements BillingInterface
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $countryCode;
    private string $city;
    private string $state;
    private string $companyName;
    private string $taxId;
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
    public function setFirstName(string $firstName): self
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
    public function setLastName(string $lastName): self
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
    public function setEmail(string $email): self
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
    public function setPhone(string $phone): self
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
    public function setCountryCode(string $countryCode): self
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
    public function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @inheritDoc
     */
    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTaxId(): string
    {
        return $this->taxId;
    }

    /**
     * @inheritDoc
     */
    public function setTaxId(string $taxId): self
    {
        $this->taxId = $taxId;
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
    public function setAddressLine1(string $addressLine1): self
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
    public function setAddressLine2(string $addressLine2): self
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
    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCity(): string
    {
        return $this->city;
    }
}