<?php

namespace payuru\phpPayu4;


use JsonSerializable;

class Payment implements PaymentInterface, JsonSerializable
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
     * @var string Идентификатор платежа
     */
    private string $merchantPaymentReference;

    /**
     * @var string код валюты
     */
    private string $currency = 'RUB';

    /**
     * @var string URL страницы после оплаты
     */
    private string $returnUrl;

    /**
     * @var AuthorizationInterface Авторизация
     */
    private AuthorizationInterface $authorization;

    /**
     * @var ClientInterface Клиент
     */
    private ClientInterface $client;

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

    /**
     * @inheritDoc
     */
    public function setMerchantPaymentReference(string $paymentIdString) : self
    {
        $this->merchantPaymentReference = $paymentIdString;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMerchantPaymentReference() : string
    {
        return $this->merchantPaymentReference;
    }

    /**
     * @inheritDoc
     */
    public function setCurrency(string $currency) : self
    {
        // TODO: Implement Currency check method.
        $this->currency = $currency;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @inheritDoc
     */
    public function setReturnUrl(string $returnUrl) : self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getReturnUrl(): string
    {
        return  $this->returnUrl;
    }

    /**
     * @inheritDoc
     */
    public function setAuthorization(AuthorizationInterface $authorization) : self
    {
        $this->authorization = $authorization;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAuthorization() : AuthorizationInterface
    {
        return $this->authorization;
    }

    /**
     * @inheritDoc
     */
    public function setClient(ClientInterface $client) : self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @inheritDoc
     */
    public function addProduct(ProductInterface $product) : self
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @inheritDoc
     */
    public function getProductsArray(): array
    {
        $productsArray = [];
        foreach ($this->getProducts() as $product) {
            $productsArray[] = $product->arraySerialize();
        }

        return $productsArray;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        //TODO: проверка необходимых параметров
        $requestData = [
            'merchantPaymentReference'	=> $this->getMerchantPaymentReference(),
            'currency'	=> $this->getCurrency(),
            'returnUrl'	=> $this->getReturnUrl(),
            'authorization' => $this->getAuthorization()->arraySerialize(),
            'client' => $this->getClient()->arraySerialize(),
            'products' => $this->getProductsArray(),
        ];

        return json_encode($requestData, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}
