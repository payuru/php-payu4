<?php

namespace payuru\phpPayu4;

class MerchantToken implements MerchantTokenInterface
{
    /** @var string Хэш Токен карты */
    private string $tokenHash;

    /** @var int CVV Карты */
    private int $cvv;

    /** @var string Имя Владельца Карты */
    private string $owner;

    /** @inheritDoc */
    public function getTokenHash(): string
    {
        return $this->tokenHash;
    }

    /** @inheritDoc */
    public function setTokenHash(string $tokenHash): MerchantToken
    {
        $this->tokenHash = $tokenHash;
        return $this;
    }

    /** @inheritDoc */
    public function getCvv(): int
    {
        return $this->cvv;
    }

    /** @inheritDoc */
    public function setCvv(int $cvv): MerchantToken
    {
        $this->cvv = $cvv;
        return $this;
    }

    /** @inheritDoc */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /** @inheritDoc */
    public function setOwner(string $owner): MerchantToken
    {
        $this->owner = $owner;
        return $this;
    }

    /** @inheritDoc */
    public function toArray() : array
    {
        $resultArray = get_object_vars($this);

        foreach ($resultArray as &$value) {
            if (is_object($value) && method_exists($value, 'toArray')) {

                $value = $value->toArray();

            } else {
                if (is_array($value)) {
                    foreach ($value as &$arrayValue) {
                        if (is_object($arrayValue) && method_exists($arrayValue, 'toArray')) {

                            $arrayValue = $arrayValue->toArray();
                        }
                    }
                }
            }
        }

        return $resultArray;
    }
}