<?php

namespace payuru\phpPayu4;

interface ProductInterface
{
    /**
     * Создание Продукта из массива параметров
     * @param array $params параметры товара
     * @throws PaymentException Ошибка оплаты
     */
    public function __construct(array $params);

    /**
     * Установить Наименование
     * @param string $name
     * @return $this
     */
    public function setName(string $name) : self;

    /**
     * Получить Наименование
     * @return string
     */
    public function getName() : string;

    /**
     * Установить Артикул, либо идентификатор
     * @param string $name
     * @return $this
     */
    public function setSku(string $name) : self;

    /**
     * Получить Артикул, либо идентификатор
     * @return string
     */
    public function getSku() : string;

    /**
     * Установить Цена за 1 штуку
     * @param float $unitPrice
     * @return $this
     */
    public function setUnitPrice(float $unitPrice) : self;

    /**
     * Получить Цена за 1 штуку
     * @return float
     */
    public function getUnitPrice() : float;

    /**
     * Установить Количество
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity) : self;

    /**
     * Получить Количество
     * @return int
     */
    public function getQuantity() : int;

    /**
     * Установить Ставка НДС, по-умолчанию 20
     * @param int $vat
     * @return $this
     */
    public function setVat(int $vat) : self;

    /**
     * Получить Ставка НДС, по-умолчанию 20
     * @return int
     */
    public function getVat() : int;

    /**
     * Установить Подитог
     * ВАЖНО: не должно превышать оригинальную стоимость (unitPrice * quantity) продукта при авторизации
     * @param float $amount Подитог
     * @return $this
     */
    public function setAmount(float $amount) : self;

    /**
     * Получить Подитог
     * @return null|float Подитог
     */
    public function getAmount() : ?float;


    /**
     * Установить Любые доп. сведения
     * @param string $additionalDetails
     * @return $this
     */
    public function setAdditionalDetails(string $additionalDetails) : self;

    /**
     * Получить Любые доп. сведения
     * @return null|string
     */
    public function getAdditionalDetails() : ?string;

    /**
     * @return array получить Продукт в виде массива
     */
    public function arraySerialize(): array;
}