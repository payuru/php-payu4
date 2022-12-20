<?php

namespace payuru\phpPayu4;


use \JsonSerializable;

/**
 * Платеж
 */
class Payment implements PaymentInterface, JsonSerializable, TransactionInterface
{
    /** @var string Идентификатор платежа у Мерчанта */
    private string $merchantPaymentReference;

    /** @var string код валюты */
    private string $currency = 'RUB';

    /** @var string URL страницы после оплаты */
    private string $returnUrl;

    /** @var AuthorizationInterface Авторизация */
    private AuthorizationInterface $authorization;

    /** @var ClientInterface Клиент */
    private ClientInterface $client;

    /** @var Product[] Массив продуктов */
    private array $products;

    /** @inheritDoc */
    public function setMerchantPaymentReference(string $paymentIdString) : self
    {
        $this->merchantPaymentReference = $paymentIdString;

        return $this;
    }

    /** @inheritDoc */
    public function getMerchantPaymentReference() : string
    {
        return $this->merchantPaymentReference;
    }

    /** @inheritDoc */
    public function setCurrency(string $currency) : self
    {
        // TODO: Implement Currency check method.
        $this->currency = $currency;

        return $this;
    }

    /** @inheritDoc */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /** @inheritDoc */
    public function setReturnUrl(string $returnUrl) : self
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /** @inheritDoc */
    public function getReturnUrl(): string
    {
        return  $this->returnUrl;
    }

    /** @inheritDoc */
    public function setAuthorization(AuthorizationInterface $authorization) : self
    {
        $this->authorization = $authorization;

        return $this;
    }

    /** @inheritDoc */
    public function getAuthorization() : AuthorizationInterface
    {
        return $this->authorization;
    }

    /** @inheritDoc */
    public function setClient(ClientInterface $client) : self
    {
        $this->client = $client;

        return $this;
    }

    /** @inheritDoc */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /** @inheritDoc */
    public function addProduct(ProductInterface $product) : self
    {
        $this->products[] = $product;

        return $this;
    }

    /** @inheritDoc */
    public function getProducts(): array
    {
        return $this->products;
    }

    /** @inheritDoc */
    public function getProductsArray(): array
    {
        $productsArray = [];
        foreach ($this->getProducts() as $product) {
            $productsArray[] = $product->arraySerialize();
        }

        return $productsArray;
    }

    /** @inheritdoc */
    public function sumProductsAmount() : float
    {
        $sum = 0;
        foreach ($this->getProducts() as $product) {
            if (null === $product->getAmount() && (null === $product->getUnitPrice())) {
                throw new PaymentException('Опишите цены позиций к оплате');
            }

            $sum += $product->getAmount() ?? ($product->getUnitPrice() * $product->getQuantity());
        }

        return $sum;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): string|bool
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

        $requestData = Std::removeNullValues($requestData);

        return json_encode($requestData, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
    }
}
