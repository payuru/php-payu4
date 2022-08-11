<?php

namespace payuru\phpPayu4;

use JsonSerializable;

class Capture implements CaptureInterface, JsonSerializable
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
     * @var Product[] Массив продуктов
     */
    private array $products;

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

    public function setPayuPaymentReference(string $paymentIdString): CaptureInterface
    {
        $this->payuPaymentReference = $paymentIdString;

        return $this;
    }

    public function getPayuPaymentReference(): string
    {
        return $this->payuPaymentReference;
    }

    public function setOriginalAmount(float $originalAmount): CaptureInterface
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    public function getOriginalAmount(): float
    {
        return $this->originalAmount;
    }

    public function setAmount(float $amount): CaptureInterface
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

    public function setCurrency(string $currency): CaptureInterface
    {
        // TODO: Implement Currency check method (in Currency Class).
        // TODO: Create Class Currency, pass Currency object to the constructors... (Payment and Capture Class)
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function addProduct(ProductInterface $product): CaptureInterface
    {
        $this->products[] = $product;

        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getProductsArray(): array
    {
        $productsArray = [];
        foreach ($this->getProducts() as $product) {
            $productsArray[] = [
                'sku' => $product->getSku(),
                'amount' => $product->getAmount(),
            ];
        }

        return $productsArray;
    }

    public function jsonSerialize()
    {
        //TODO: проверка необходимых параметров
        $requestData = [
            'payuPaymentReference'	=> $this->getPayuPaymentReference(),
            'originalAmount'	=> $this->getOriginalAmount(),
            'amount'	=> $this->getAmount(),
            'currency' => $this->getCurrency(),
            //'products' => $this->getProductsArray(),
        ];

        return json_encode($requestData, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}