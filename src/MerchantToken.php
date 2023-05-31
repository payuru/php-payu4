<?php

namespace Ypmn;

class MerchantToken implements MerchantTokenInterface, \JsonSerializable
{
    /** @var string Хэш Токен карты */
    private string $tokenHash;

    /** @var string CVV Карты */
    private string $cvv;

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
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /** @inheritDoc */
    public function setCvv(string $cvv): MerchantToken
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

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        if(is_null($this->tokenHash)){
            throw new PaymentException("Не хватает токена");
        }

        $resultArray = [
            'tokenHash'  => $this->tokenHash,
        ];

        return json_encode($resultArray, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}