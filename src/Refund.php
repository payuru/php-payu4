<?php

namespace payuru\phpPayu4;

use JsonSerializable;

/**
 * Запрос на возврат средств
 */
class Refund implements RefundInterface, JsonSerializable, TransactionInterface
{
    /**
     * Использование режима отладки (вывод системных сообщений)
     * @var bool Использовать режим отладки?
     */
    private bool $debugMode = false;

    /**
     * Использование тестовый сервер Sandbox.PayU.ru
     * Переключение между Sandbox.PayU.ru и Secure.PayU.ru
     * @var bool Использовать тестовый сервер Sandbox.PayU.ru?
     */
    private bool $sandboxMode = false;

    /**
     * @var string Номер платежа PayU
     */
    private string $payuPaymentReference;

    /**
     * @var float Cумма исходной операции на авторизацию
     */
    private float $originalAmount;

    /**
     * @var float Сумма списания
     */
    private float $amount;

    /**
     * @var string Валюта
     */
    private string $currency;

    /**
     * @inheritDoc
     */
    public function setDebugMode(bool $isOn) : self
    {
        $this->debugMode = $isOn;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSandboxMode(bool $isOn) : self
    {
        $this->sandboxMode = $isOn;

        return $this;
    }

    public function setPayuPaymentReference(string $paymentIdString): RefundInterface
    {
        $this->payuPaymentReference = $paymentIdString;

        return $this;
    }

    public function getPayuPaymentReference(): string
    {
        return $this->payuPaymentReference;
    }

    public function setOriginalAmount(float $originalAmount): RefundInterface
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    public function getOriginalAmount(): float
    {
        return $this->originalAmount;
    }

    public function setAmount(float $amount): RefundInterface
    {
        if ($amount > $this->originalAmount) {
            throw new PaymentException('Списываемая сумма не должна быть больше суммы авторизации');
        }
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setCurrency(string $currency): RefundInterface
    {
        // TODO: Implement Currency check method (in Currency Class).
        // TODO: Create Class Currency, pass Currency object to the constructors... (Payment, Capture and Refund Classes)
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function jsonSerialize()
    {
        //TODO: проверка необходимых параметров
        $requestData = [
            'payuPaymentReference'	=> $this->getPayuPaymentReference(),
            'originalAmount'	=> $this->getOriginalAmount(),
            'amount'	=> $this->getAmount(),
            'currency' => $this->getCurrency()
        ];

        return json_encode($requestData, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}