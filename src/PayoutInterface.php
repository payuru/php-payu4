<?php declare(strict_types = 1);

namespace Ypmn;

interface PayoutInterface
{
    /**
     * @return string|null
     */
    public function getMerchantPayoutReference(): ?string;

    /**
     * @param string|null $merchantPayoutReference
     * @return Payout
     */
    public function setMerchantPayoutReference(?string $merchantPayoutReference): self;

    /**
     * @return Amount|null
     */
    public function getAmount(): ?Amount;

    /**
     * @param Amount|null $amount
     * @return Payout
     */
    public function setAmount(?Amount $amount): self;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     * @return Payout
     */
    public function setDescription(?string $description): self;

    /**
     * @return PayoutDestination|null
     */
    public function getDestination(): ?PayoutDestination;

    /**
     * @param PayoutDestination|null $destination
     * @return Payout
     */
    public function setDestination(?PayoutDestination $destination): self;

    /**
     * @return PayoutSource|null
     */
    public function getSource(): ?PayoutSource;

    /**
     * @param PayoutSource|null $source
     * @return Payout
     */
    public function setSource(?PayoutSource $source): self;

}
