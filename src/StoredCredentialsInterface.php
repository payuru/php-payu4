<?php

namespace payuru\phpPayu4;

interface StoredCredentialsInterface
{
    /**
     * Получить
     * @return string
     */
    public function getUseType(): string;

    /**
     * Установить
     * @param string $useType
     * @return $this
     */
    public function setUseType(string $useType): self;

    /**
     * Получить id исходной операции
     * @return string id исходной операции
     */
    public function getUseId(): string;

    /**
     * Установить id исходной операции
     * @param string $useId id исходной операции
     * @return $this
     */
    public function setUseId(string $useId): self;
}
