<?php

namespace payuru\phpPayu4;

class CardDetails implements CardDetailsInterface
{
    /** @var string Номер карты */
    private string $number;

    /** @var int Месяц прекращения действия Карты */
    private int $expiryMonth;

    /** @var int Год прекращения действия Карты */
    private int $expiryYear;

    /** @var int CVV Карты */
    private int $cvv;

    /** @var string Имя Владельца Карты */
    private string $owner;

    /** @var int Время набора Номера Карты (сек) */
    private int $timeSpentTypingNumber;

    /** @var int Время набора Имени Владельца Карты (сек) */
    private int $timeSpentTypingOwner;

    /** @var int BIN (Bank Identification Number) */
    private int $bin;

    /** @var string PAN (Permanent Account Number) */
    private string $pan;

    /** @var string Тип Карты (например, Visa, MIR) */
    private string $type;

    /** @var string Банк, выпустивший карту */
    private string $cardIssuerBank;

    /** @inheritDoc */
    public function getNumber(): string
    {
        return $this->number;
    }

    /** @inheritDoc */
    public function setNumber(string $number): CardDetails
    {
        $this->number = $number;
        return $this;
    }

    /** @inheritDoc */
    public function getExpiryMonth(): int
    {
        return $this->expiryMonth;
    }

    /** @inheritDoc */
    public function setExpiryMonth(int $expiryMonth): CardDetails
    {
        $this->expiryMonth = $expiryMonth;
        return $this;
    }

    /** @inheritDoc */
    public function getYear(): int
    {
        return $this->year;
    }

    /** @inheritDoc */
    public function setYear(int $year): CardDetails
    {
        $this->year = $year;
        return $this;
    }

    /** @inheritDoc */
    public function getExpiryYear(): int
    {
        return $this->expiryYear;
    }

    /** @inheritDoc */
    public function setExpiryYear(int $expiryYear): CardDetails
    {
        $this->expiryYear = $expiryYear;
        return $this;
    }

    /** @inheritDoc */
    public function getCvv(): int
    {
        return $this->cvv;
    }

    /** @inheritDoc */
    public function setCvv(int $cvv): CardDetails
    {
        $this->cvv = $cvv;
        return $this;
    }

    /** @inheritDoc */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /** @inheritDoc */
    public function setOwner(string $owner): CardDetails
    {
        $this->owner = $owner;
        return $this;
    }

    /** @inheritDoc */
    public function getTimeSpentTypingNumber(): int
    {
        return $this->timeSpentTypingNumber;
    }

    /** @inheritDoc */
    public function setTimeSpentTypingNumber(int $timeSpentTypingNumber): CardDetails
    {
        $this->timeSpentTypingNumber = $timeSpentTypingNumber;
        return $this;
    }

    /** @inheritDoc */
    public function getTimeSpentTypingOwner(): int
    {
        return $this->timeSpentTypingOwner;
    }

    /** @inheritDoc */
    public function setTimeSpentTypingOwner(int $timeSpentTypingOwner): CardDetails
    {
        $this->timeSpentTypingOwner = $timeSpentTypingOwner;
        return $this;
    }

    /** @inheritDoc */
    public function getBin(): int
    {
        return $this->bin;
    }

    /** @inheritDoc */
    public function setBin(int $bin): CardDetails
    {
        $this->bin = $bin;
        return $this;
    }

    /** @inheritDoc */
    public function getPan(): string
    {
        return $this->pan;
    }

    /** @inheritDoc */
    public function setPan(string $pan): CardDetails
    {
        $this->pan = $pan;
        return $this;
    }

    /** @inheritDoc */
    public function getType(): string
    {
        return $this->type;
    }

    /** @inheritDoc */
    public function setType(string $type): CardDetails
    {
        $this->type = $type;
        return $this;
    }

    /** @inheritDoc */
    public function getCardIssuerBank(): string
    {
        return $this->cardIssuerBank;
    }

    /** @inheritDoc */
    public function setCardIssuerBank(string $cardIssuerBank): CardDetails
    {
        $this->cardIssuerBank = $cardIssuerBank;
        return $this;
    }
}