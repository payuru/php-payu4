<?php

namespace Ypmn;

/**
 * Класс для хранения номера транзакции на стороне YPMN
 */
class PaymentReference implements \JsonSerializable
{
    private ?int $paymentReference = null;

    /**
     * @param string $paymentReference номер транзакции
     */
    public function __construct(string $paymentReference)
    {
        $this->setPaymentReference($paymentReference);
    }

    private function setPaymentReference(int $paymentReference) : self
    {
        $this->paymentReference = $paymentReference;
        return $this;
    }

    /**
     * @throws PaymentException
     */
    public function jsonSerialize(): string
    {
        if(is_null($this->paymentReference)){
            throw new PaymentException("Не хватает номера оплаты для токенизации");
        }

        $resultArray = [
            'payuPaymentReference'  => $this->paymentReference,
        ];

        return json_encode($resultArray, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}