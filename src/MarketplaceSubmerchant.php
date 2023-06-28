<?php

namespace Ypmn;

use JsonSerializable;
use stdClass;

/**
 * Это объект Сабмерчанта
 * (для маркетплейса/сплита/разделения платежа)
 */
class MarketplaceSubmerchant implements MarketplaceSubmerchantInterface, JsonSerializable
{
    /** @var string Код Сабмерчанта (можно получить в личном кабинете) */
    private string $merchantCode;

    /** @var float|null Сумма этого Сабмерчанта в заказе */
    private ?float $amount = null;

    /** @throws PaymentException */
    public function __construct(string $merchantCode, float $amount = null)
    {
        $this->setMerchantCode($merchantCode);
        if (null !== $amount) {
            $this->setAmount($amount);
        }
    }

    /** @inheritDoc */
    public function setMerchantCode(string $merchantCode): self
    {
        $this->merchantCode = $merchantCode;

        return $this;
    }

    /** @inheritDoc */
    public function getMerchantCode(): string
    {
        return $this->merchantCode;
    }

    /** @inheritDoc
     * @throws PaymentException
     */
    public function setAmount(float $amount): self
    {
        if ($amount <= 0) {
            throw new PaymentException('Отрицательные суммы не принимаются');
        }

        $this->amount = $amount;

        return $this;
    }

    /** @inheritDoc */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /** @inheritDoc */
    public function arraySerialize()
    {
        $resultArray = [
          'merchantCode' => $this->merchantCode,
        ];

        if ($this->amount > 0) {
            $resultArray['amount'] = $this->amount;
        }

        return $resultArray;
    }

    public function jsonSerialize(){
        $dto = (object) [
            'merchantCode' => $this->getMerchantCode(),
            'amount' => $this->getAmount(),
        ];

        return json_encode($dto, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}
