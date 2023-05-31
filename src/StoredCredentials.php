<?php

namespace Ypmn;

use Ypmn\Interfaces\StoredCredentialsInterface;

class StoredCredentials implements StoredCredentialsInterface
{
    /** @var string  */
    private string $useType;

    /** @var string id исходной операции */
    private string $useId;

    /** @inheritDoc */
    public function getUseType(): string
    {
        return $this->useType;
    }

    /** @inheritDoc */
    public function setUseType(string $useType): self
    {
        $this->useType = $useType;
        return $this;
    }

    /** @inheritDoc */
    public function getUseId(): string
    {
        return $this->useId;
    }

    /** @inheritDoc */
    public function setUseId(string $useId): self
    {
        $this->useId = $useId;
        return $this;
    }
}
