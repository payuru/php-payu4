<?php

namespace payuru\phpPayu4;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
/**
 * Класс отправки запроса к API
 */
class ApiRequest
{
    const AUTHORIZE_API = '/api/v4/payments/authorize';
    const CAPTURE_API = '/api/v4/payments/capture';
    const REFUND_API = '/api/v4/payments/refund';
    const STATUS_API = '/api/v4/payments/status';
    const HOST = 'https://sandbox.payu.ru';

    private Merchant $merchant;

    public function __construct(MerchantInterface $merchant)
    {
        $this->merchant = $merchant;
    }

    private function sendGetRequest(string $api): array
    {
        $curl = curl_init();
        $date = (new DateTime())->format(DateTimeInterface::ATOM);
        $urlToPostTo = self::HOST . $api;
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
    private function sendPostRequest(JsonSerializable $data, string $api): array
    {
        $encodedJsonData = $data->jsonSerialize();
        $encodedJsonDataHash = md5($encodedJsonData);

        $curl = curl_init();
        $date = (new DateTime())->format(DateTimeInterface::ATOM);
        $urlToPostTo = self::HOST . $api;
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
                    $encodedJsonDataHash)
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return ['response' => $response, 'error' => $err];
    }

    public function sendAuthRequest(PaymentInterface $payment): array
    {
        return $this->sendPostRequest($payment, self::AUTHORIZE_API);
    }

    public function sendCaptureRequest(CaptureInterface $capture): array
    {
        return $this->sendPostRequest($capture, self::CAPTURE_API);
    }

    public function sendRefundRequest(RefundInterface $refund): array
    {
        return $this->sendPostRequest($refund, self::REFUND_API);
    }

    public function sendStatusRequest(string $merchantPaymentReference): array
    {
        return $this->sendGetRequest(self::STATUS_API . '/' . $merchantPaymentReference);
    }

    private function getSignature(MerchantInterface $merchant, $date, $url, $httpMethod, $bodyHash): string
    {
        $urlParts = parse_url($url);
        $urlHashableParts = $httpMethod . $urlParts['path'];

        if (isset($urlParts['query'])) {
            $urlHashableParts .= $urlParts['query'];
        }
        $hashableString = $merchant->getCode() . $date . $urlHashableParts . $bodyHash;

        return hash_hmac('sha256', $hashableString, $merchant->getSecret());
    }
}