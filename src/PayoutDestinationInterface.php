<?php declare(strict_types=1);

namespace Ypmn;

interface PayoutDestinationInterface
{

    /**
     * Получить Тип направления платежа
     * @return string
     */
    public function getType(): string;

    /**
     * Установить Тип направления платежа
     * @param string $type
     * @return PayoutDestination
     * @throws PaymentException
     */
    public function setType(string $type): self;

    /**
     * Получить Информацию о карте
     * @return CardDetails|null
     */
    public function getCard(): ?CardDetails;

    /**
     * Установить Информацию о карте
     * @param CardDetails|null $card
     * @return PayoutDestination
     */
    public function setCard(?CardDetails $card): self;

    /**
     * Получить биллинговую информацию о Получателе платежа
     * @return Billing|null
     */
    public function getRecipient(): ?Billing;

    /**
     * Установить биллинговую информацию о Получателе платежа
     * @param Billing|null $recipient
     * @return PayoutDestination
     */
    public function setRecipient(?Billing $recipient): self;


    /**
     * Установить номер карты
     * @param string $cardNumber
     * @return PayoutDestination
     */
    public function setCardNumber(string $cardNumber): self;

    public function arraySerialize() : array;
}
