<?php

namespace Ypmn;

use \DateTime;
use \DateTimeInterface;
use \JsonSerializable;

/**
 * Класс отправки запроса к API
 */
class ApiRequest implements ApiRequestInterface
{
    const AUTHORIZE_API = '/api/v4/payments/authorize';
    const CAPTURE_API = '/api/v4/payments/capture';
    const TOKEN_API = '/api/v4/token';
    const REFUND_API = '/api/v4/payments/refund';
    const STATUS_API = '/api/v4/payments/status';
    const HOST = 'https://secure.payu.ru';
    const SANDBOX_HOST = 'https://sandbox.payu.ru';

    /** @var MerchantInterface Мерчант, от имени которого отправляется запрос */
    private MerchantInterface $merchant;

    /** @var bool Режим Песочницы (тестовая панель Ypmn */
    private bool $sandboxModeIsOn = false;

    /** @var bool Режим Отладки (вывод системных сообщений) */
    private bool $debugModeIsOn = false;

    /** @inheritdoc  */
    public function __construct(MerchantInterface $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Отправка GET-запроса
     * @param string $api адрес API (URI)
     * @return array ответ сервера Ypmn
     */
    private function sendGetRequest(string $api): array
    {
        $curl = curl_init();
        $date = (new DateTime())->format(DateTimeInterface::ATOM);
        $urlToPostTo = ($this->getSandboxMode() ? self::SANDBOX_HOST : self::HOST) .  $api;
        $requestHttpVerb = 'GET';

        $setopt_array = [
            CURLOPT_URL => $urlToPostTo,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestHttpVerb,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Header-Date: ' . $date,
                'X-Header-Merchant: ' . $this->merchant->getCode(),
                'X-Header-Signature:' . $this->getSignature(
                    $this->merchant,
                    $date,
                    $urlToPostTo,
                    $requestHttpVerb,
                    md5(''),
                )
            ]
        ];

        curl_setopt_array($curl, $setopt_array);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return ['response' => $response, 'error' => $err];
    }

    /**
     * Отправка POST-запроса
     * @param JsonSerializable $data запрос
     * @param string $api адрес API (URI)
     * @return array ответ сервера Ypmn
     * @throws PaymentException
     */
    private function sendPostRequest(JsonSerializable $data, string $api): array
    {
        $encodedJsonData = $data->jsonSerialize();

        $encodedJsonDataHash = md5($encodedJsonData);

        $curl = curl_init();
        $date = (new DateTime())->format(DateTimeInterface::ATOM);
        $urlToPostTo = ($this->getSandboxMode() ? self::SANDBOX_HOST : self::HOST) . $api;
        $requestHttpVerb = 'POST';

        curl_setopt_array($curl, [
            CURLOPT_URL => $urlToPostTo,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestHttpVerb,
            CURLOPT_POSTFIELDS => $encodedJsonData,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Header-Date: ' . $date,
                'X-Header-Merchant: ' . $this->merchant->getCode(),
                'X-Header-Signature:' . $this->getSignature(
                    $this->merchant,
                    $date,
                    $urlToPostTo,
                    $requestHttpVerb,
                    $encodedJsonDataHash
                )
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if (true === $this->getDebugMode()) {
            $this->echoDebugMessage('Запрос к серверу Ypmn:');
            $this->echoDebugMessage($encodedJsonData);
            $this->echoDebugMessage('Ответ от сервера Ypmn:');
            $this->echoDebugMessage(json_encode(json_decode($response), JSON_PRETTY_PRINT));

            if (mb_strlen($err) > 0) {
                $this->echoDebugMessage('Ошибка');
                $this->echoDebugMessage($encodedJsonData);
                echo '<br>Следуйте <a href="http://secure.payu.ru/docs/">документации</a>';
                echo '<br>Вы можете отправить запрос на поддержку на <a href="mailto:help@payu.ru?subject=INTEGRATE">help@payu.ru</a>';
                echo '<br><a href="https://github.com/payuru/php-payu4/">Последняя версия примеров на Github</a>';
                echo '<br><a href="https://github.com/payuru/php-payu4/issues">Оставить заявку на улучшение</a>';
                echo '<br><a href="https://payu.ru/contacts">Контакты</a>';
            } else {
                if ($this->getSandboxMode()) {
                    echo '<br>Внимание! У вас включен тестовый режим (режим песочницы). Все запросы уходят на sandbox.payu.ru';
                }
                $cpanel_url = 'https://' . ($this->getSandboxMode() ? 'sandbox' : 'secure' ). '.payu.ru/cpanel/';
                echo '<br>Отслеживайте состояние транзакции по адресу <a href="' . $cpanel_url . '" target="_b">' . $cpanel_url . '</a>';
                echo '<br><br>';
            }
        }

        if (mb_strlen($err) > 0) {
            throw new PaymentException($err);
        }

        return ['response' => $response, 'error' => $err];
    }

    /** @inheritdoc  */
    public function sendAuthRequest(PaymentInterface $payment): array
    {
        return $this->sendPostRequest($payment, self::AUTHORIZE_API);
    }

    /** @inheritdoc  */
    public function sendCaptureRequest(CaptureInterface $capture): array
    {
        return $this->sendPostRequest($capture, self::CAPTURE_API);
    }

    /** @inheritdoc  */
    public function sendRefundRequest(RefundInterface $refund): array
    {
        return $this->sendPostRequest($refund, self::REFUND_API);
    }

    /** @inheritdoc  */
    public function sendStatusRequest(string $merchantPaymentReference): array
    {
        return $this->sendGetRequest(self::STATUS_API . '/' . $merchantPaymentReference);
    }

    /** @inheritdoc  */
    public function sendTokenCreationRequest(PaymentReference $payuPaymentReference): array
    {
        return $this->sendPostRequest($payuPaymentReference, self::TOKEN_API);
    }

    /** @inheritdoc  */
    public function sendTokenPaymentRequest(MerchantToken $tokenHash): array
    {
        return $this->sendPostRequest($tokenHash, self::AUTHORIZE_API);
    }

    /**
     * Подпись запроса
     * @param MerchantInterface $merchant Мерчант
     * @param string $date Дата
     * @param string $url адрес отправки запроса
     * @param string $httpMethod HTTP
     * @param string $bodyHash md5-хэш запроса
     * @return string подпись
     */
    private function getSignature(MerchantInterface $merchant, string $date, string $url, string $httpMethod, string $bodyHash): string
    {
        $urlParts = parse_url($url);
        $urlHashableParts = $httpMethod . $urlParts['path'];
        $this->echoDebugMessage($urlParts);

        if (isset($urlParts['query'])) {
            $urlHashableParts .= $urlParts['query'];
        }
        $hashableString = $merchant->getCode() . $date . $urlHashableParts . $bodyHash;

        return hash_hmac('sha256', $hashableString, $merchant->getSecret());
    }

    /** @inheritdoc  */
    public function getSandboxMode(): bool
    {
        return $this->sandboxModeIsOn;
    }

    /** @inheritdoc  */
    public function setSandboxMode(bool $sandboxModeIsOn = true): self
    {
        $this->sandboxModeIsOn = $sandboxModeIsOn;
        return $this;
    }

    /** @inheritdoc  */
    public function getDebugMode(): bool
    {
        return $this->debugModeIsOn;
    }

    /** @inheritdoc  */
    public function setDebugMode(bool $debugModeIsOn = true): self
    {
        $this->debugModeIsOn = $debugModeIsOn;
        return $this;
    }

    /**
     * Вывод отладочного сообщения
     * @param $mixedInput
     * @return void
     */
    private function echoDebugMessage($mixedInput): void
    {
        if ($this->getDebugMode()) {
            echo '
                <pre
                    class="w-100 d-block"
                    style="
                        background: aliceblue;
                        color: black;
                        padding: 2px;
                        border: 1px solid green;
                        white-space: pre-wrap;
                    "
                >'.print_r($mixedInput, true).'</pre>';
        }
    }
}
