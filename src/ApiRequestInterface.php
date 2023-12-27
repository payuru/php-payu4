<?php

namespace Ypmn;

interface ApiRequestInterface
{
    /**
     * Создание запроса от лица Мерчанта
     * @param MerchantInterface $merchant Мерчант
     */
    function __construct(MerchantInterface $merchant);

    /**
     * Запрос ID сессии
     * @param SessionRequest $sessionRequest
     * @return array
     */
    function sendSessionRequest(SessionRequest $sessionRequest): array;

    /**
     * Отправить Запрос на Оплату
     * @param PaymentInterface $payment Оплата
     * @return array
     */
    public function sendAuthRequest(PaymentInterface $payment): array;

    /**
     * Отправить Запрос на Списание Средств
     * @param CaptureInterface $capture Списание Средств
     * @return array
     */
    public function sendCaptureRequest(CaptureInterface $capture): array;

    /**
     * Отправить Запрос на Возврат
     * @param RefundInterface $refund Возврат
     * @return array
     */
    public function sendRefundRequest(RefundInterface $refund): array;

    /**
     * Отправить Запрос о статусе платежа
     * @param string $merchantPaymentReference Номер транзакции на стороне мерчанта
     * @return array
     */
    public function sendStatusRequest(string $merchantPaymentReference): array;

    /**
     * Установить режим песочницы
     * Переключить режим тестирования Ypmn Sandbox
     * оплата будет перенаправлена на тестовый сервер
     * @param bool $sandboxModeIsOn Режим песочницы включен?
     * @return $this
     */
    public function setSandboxMode(bool $sandboxModeIsOn): self;

    /**
     * Получить, установлен ли режим песочницы
     * @return bool Режим песочницы включен?
     */
    public function getSandboxMode(): bool;

    /**
     * Установить режим отладки
     * (скрипт будет выводить отладочные сообщения)
     * @param bool $debugModeIsOn Режим отладки включен?
     * @return $this
     */
    public function setDebugMode(bool $debugModeIsOn): self;

    /**
     * Получить, установлен ли режим отладки
     * @return bool Режим отладки включен?
     */
    public function getDebugMode(): bool;

    /**
     * Установить тип позвращаемого значения в режиме отладки
     * @return $this
     */
    public function  setJsonDebugResponse(bool $jsonDebugResponse): self;

    /**
     * Получить тип позвращаемого значения в режиме отладки
     * @return bool
     */
    public function  getJsonDebugResponse(): bool;

    /**
     * Отправить Запрос на Токенизацию
     * @param PaymentReference $payuPaymentReference Оплата
     * @return array
     */
    public function sendTokenCreationRequest(PaymentReference $payuPaymentReference): array;

    /**
     * Отправить Запрос на Оплату токеном
     * @param PaymentReference $payuPaymentReference Оплата
     * @return array
     */
    public function sendTokenPaymentRequest(MerchantToken $tokenHash): array;

    /**
     * Отправить запрос для получения графика
     * @param array $params
     */
    public function sendReportChartRequest(array $params);

    /**
     * Отправить запрос для получения JSON для обновления графика
     * @param array $params
     */
    public function sendReportChartUpdateRequest(array $params);

    /**
     * Отправить запрос для получения JSON данных отчета
     * @param array $params
     */
    public function sendReportGeneralRequest(array $params);
}
