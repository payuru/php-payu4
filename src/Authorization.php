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
     * @throws PaymentException Ощибка оплаты
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

    /**
     * @param bool $isUsed
     * @return $this
     */
    public function setUsePaymentPage(bool $isUsed) : self
    {
        $this->usePaymentPage = $isUsed;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsePaymentPage(): bool
    {
        return $this->usePaymentPage;
    }

    /**
     * @return string
     */
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
    public function setCardDetails(CardDetailsInterface $cardDetails): Authorization
    {
        $this->cardDetails = $cardDetails;
        return $this;
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

        return $resultArray;
    }
}
