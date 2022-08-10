<?php

namespace payuru\phpPayu4;

class Client implements ClientInterface
{
    /**
     * @var BillingInterface Биллинговая информация
     */
    private BillingInterface $billing;

    /**
     * @var string Клиенский IP
     */
    private string $clientIp;

    /**
     * @var string Время оплаты
     */
    private string $clientTime;

    /**
     * @var DeliveryInterface Информация о доставке
     */
    private DeliveryInterface $delivery;

    /**
     * @inheritDoc
     */
    public function getBilling(): BillingInterface
    {
        return $this->billing;
    }

    /**
     * @inheritDoc
     */
    public function setBilling(BillingInterface $billing): self
    {
        $this->billing = $billing;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCurrentClientIp(): self
    {
        $ip = $_SERVER['HTTP_CLIENT_IP']
            ? $_SERVER['HTTP_CLIENT_IP']
            : ($_SERVER['HTTP_X_FORWARDED_FOR']
                ? $_SERVER['HTTP_X_FORWARDED_FOR']
                : $_SERVER['REMOTE_ADDR']);
        $this->setClientIp($ip);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getClientIp(): string
    {
        return $this->clientIp;
    }

    /**
     * @inheritDoc
     */
    public function setClientIp(string $clientIp): self
    {
        $this->clientIp = $clientIp;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function setCurrentClientTime(): self
    {
        // TODO: Implement setCurrentTime() method - установить текущее время оплаты
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getClientTime(): string
    {
        return $this->clientTime;
    }

    /**
     * @inheritDoc
     */
    public function setClientTime(string $clientTime): self
    {
        $this->clientTime = $clientTime;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setDelivery(DeliveryInterface $delivery): ClientInterface
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDelivery(): DeliveryInterface
    {
        return $this->delivery;
    }

    /**
     * @inheritDoc
     */
    public function arraySerialize()
    {
        return [
            'billing'	=> [
                'firstName'	=> "John",
                'lastName'	=> "Doe",
                'email'		=> "test@payu.ro",
                'phone'		=> "0771346934",
                'countryCode'	=> "RU"
            ],
            'ClientIp'		=> "127.0.0.1",
            'ClientTime'	=> "TEST",
        ];
    }
}
