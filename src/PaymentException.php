<?php

namespace payuru\phpPayu4;

class PaymentException extends \Exception
{
    /**
     * Ошибка в формате Bootstrap
     * @return string текст ошибки
     */
    public function getHtmlMessage(): string
    {
        return '
            <div class="alert alert-danger" role="alert">
              <strong>Ошибка оплаты:</strong>
              <br>
              <br>
              ' . htmlspecialchars($this->getMessage()) . '
            </div>
        ';
    }
}
