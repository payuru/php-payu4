<?php

namespace payuru\phpPayu4;

use \JsonSerializable;

class Authorization implements AuthorizationInterface
{
    const TYPE_CCVISAMC = 'CCVISAMC';
    const TYPE_FASTER_PAYMENTS = 'FASTER_PAYMENTS';

    /**
     * включить страницу оплаты PayU
     * @var bool страница оплаты PayU включена?
     */
    private bool $usePaymentPage = true;
    private string $paymentMethod = self::TYPE_CCVISAMC;

    /** @var CardDetailsInterface|null Данные карты */
    private ?CardDetailsInterface $cardDetails = null;

    /** @var MerchantTokenInterface|null Данные карты (в виде токена) */
    private ?MerchantTokenInterface $merchantToken = null;

    /**
     * Создать Платёжную Авторизацию
     * @param string $paymentMethodType Метод оплаты (из справочника)
     * @param bool $isUsed страница оплаты PayU включена?
     * @return void
     * @throws PaymentException Ошибка оплаты
     */
    public function __constructor(string $paymentMethodType, bool $isUsed) {
        $this->setPaymentMethod($paymentMethodType);
        $this->setUsePaymentPage($isUsed);
    }

    /**
     * @inheritDoc
     * @throws PaymentException Ошибка оплаты
     */
    public function setPaymentMethod(string $paymentMethodType) : self
    {
        switch ($paymentMethodType) {
            case 'CCVISAMC':
                $this->paymentMethod = self::TYPE_CCVISAMC;
                break;
            case 'FASTER_PAYMENTS':
                $this->paymentMethod = self::TYPE_FASTER_PAYMENTS;
                break;
            default:
                throw new PaymentException('Неверный тип оплаты в авторизации');
        }

        return $this;
    }

    /** @inheritDoc */
    public function setUsePaymentPage(bool $isUsed) : self
    {
        if ($isUsed === true) {
            if (is_null($this->merchantToken) && is_null($this->cardDetails)) {
                $this->usePaymentPage = $isUsed;
            } else {
                throw new PaymentException('For using PaymentPage need to make MerchantToken = NULL and CardDetails = NULL');
            }
        } else {
            $this->usePaymentPage = $isUsed;
        }

        return $this;
    }

    /** @inheritDoc */
    public function getUsePaymentPage(): bool
    {
        return $this->usePaymentPage;
    }

    /** @inheritDoc */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /** @inheritDoc */
    public function getCardDetails(): CardDetailsInterface
    {
        return $this->cardDetails;
    }

    /** @inheritDoc */
    public function setCardDetails(CardDetailsInterface $cardDetails): self
    {
        if (is_null($this->merchantToken) && $this->usePaymentPage === false) {
            $this->cardDetails = $cardDetails;

            return $this;
        } else {
            throw new PaymentException('For using CardDetails need to make MerchantToken = NULL and usePaymentPage = false');
        }
    }

    /** @inheritDoc */
    public function getMerchantToken(): ?MerchantTokenInterface
    {
        return $this->merchantToken;
    }

    /**
     * @inheritDoc
     * @throws PaymentException
     */
    public function setMerchantToken(?MerchantTokenInterface $merchantToken): self
    {
        if (is_null($this->getCardDetails()) && $this->getUsePaymentPage() === false) {
            $this->merchantToken = $merchantToken;

            return $this;
        } else {
            throw new PaymentException('For using MerchantToken need to make CardDetails = NULL and usePaymentPage = false');
        }
    }

    /**
     * @return array
     */
    public function arraySerialize(): array
    {
        $resultArray = [
            'usePaymentPage' => ($this->usePaymentPage ? 'YES' : 'NO'),
            'paymentMethod'  => $this->paymentMethod,
        ];

        if (!is_null($this->cardDetails)) {
            $resultArray['cardDetails'] = $this->cardDetails->toArray();
        }

        if (!is_null($this->merchantToken)) {
            $resultArray['merchantToken'] = $this->merchantToken->toArray();
        }

        return $resultArray;
    }
}
