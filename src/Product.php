<?php

namespace payuru\phpPayu4;

/**
 * Продукт или Услуга
 * (позиция на оплату)
 */
class Product implements ProductInterface
{
    /**
     * @var string Наименование
     */
    private string $name;

    /**
     * @var string Артикул, либо идентификатор
     */
    private string $sku;

    /**
     * @var int Цена за 1 штуку
     */
    private int $unitPrice;

    /**
     * @var int Количество
     */
    private int $quantity;

    /**
     * @var int Ставка НДС
     */
    private int $vat = 20;

    /**
     * @var int Подитог
     */
    private int $amount;

    /**
     * @var string Любые доп. сведения
     */
    private string $additionalDetails;

    /** @inheritDoc */
    public function __construct(array $params=[])
    {
        if (isset($params['name'])) {
            $this->setName($params['name']);
        }
        if (isset($params['sku'])) {
            $this->setSku($params['sku']);
        }
        if (isset($params['unitPrice'])) {
            $this->setUnitPrice($params['unitPrice']);
        }
        if (isset($params['quantity'])) {
            $this->setQuantity($params['quantity']);
        }
        if (isset($params['vat'])) {
            $this->setVat($params['vat']);
        }
        if (isset($params['amount'])) {
            $this->setAmount($params['amount']);
        }
    }

    /** @inheritDoc */
    public function getName(): string
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /** @inheritDoc */
    public function getSku(): string
    {
        return $this->sku;
    }

    /** @inheritDoc */
    public function setSku(string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    /** @inheritDoc */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /** @inheritDoc */
    public function setUnitPrice(float $unitPrice): Product
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /** @inheritDoc */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /** @inheritDoc */
    public function setQuantity(int $quantity): Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    /** @inheritDoc */
    public function getVat(): int
    {
        return $this->vat;
    }

    /** @inheritDoc */
    public function setVat(int $vat): Product
    {
        $this->vat = $vat;
        return $this;
    }

    /** @inheritDoc */
    public function getAmount(): ?float
    {
        return ($this->amount ?? null);
    }

    /** @inheritDoc */
    public function setAmount(float $amount): Product
    {
        //TODO: ВАЖНО: не должно превышать оригинальную стоимость (unitPrice * quantity) продукта при авторизации
        $this->amount = $amount;
        return $this;
    }

    /** @inheritDoc */
    public function getAdditionalDetails(): ?string
    {
        return ($this->additionalDetails ?? null);
    }

    /** @inheritDoc */
    public function setAdditionalDetails(string $additionalDetails): Product
    {
        $this->additionalDetails = $additionalDetails;
        return $this;
    }

    /** @inheritDoc */
    public function arraySerialize(): array
    {
        return [
            'name'              => $this->getName(),
            'sku'               => $this->getSku(),
            'unitPrice'         => $this->getUnitPrice(),
            'quantity'          => $this->getQuantity(),
            'additionalDetails' => $this->getAdditionalDetails(),
            'amount'            => $this->getAmount(),
            'vat'               => $this->getVat(),
        ];
    }
}
