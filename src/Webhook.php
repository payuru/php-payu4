<?php

namespace payuru\phpPayu4;

class Webhook implements WebhookInterface
{
    /** @var PaymentResultInterface Результат Платежа */
    private PaymentResultInterface $paymentResult;

    /** @var OrderDataInterface Информация о Заказе */
    private OrderDataInterface $orderData;

    /** @inheritDoc */
    public function catchJsonRequest(): self
    {
        try {
            $request = json_decode(file_get_contents('php://input'), true);
        } catch (\Exception $exception) {
            throw new PaymentException('Не удалось преобразовать ответ от платёжной системы.
            Проверьте настройку веб-сервера.');
        }

        $this->orderData = new OrderData;
        $this->orderData->setOrderDate($request['orderData']['orderDate']);
        $this->orderData->setPayuPaymentReference($request['orderData']['payuPaymentReference']);
        $this->orderData->setMerchantPaymentReference($request['orderData']['merchantPaymentReference']);
        $this->orderData->setStatus($request['orderData']['status']);
        $this->orderData->setCurrency($request['orderData']['currency']);
        $this->orderData->setAmount($request['orderData']['amount']);
        $this->orderData->setCommission((float) $request['orderData']['commission']);
        $this->orderData->setLoyaltyPointsAmount((int) $request['orderData']['loyaltyPointsAmount']);
        $this->orderData->setLoyaltyPointsDetails((array) $request['orderData']['loyaltyPointsDetails']);

        $cardDetails = new CardDetails;
        $cardDetails->setBin($request['paymentResult']['paymentMethod']['cardDetails']['bin']);
        $cardDetails->setOwner($request['paymentResult']['paymentMethod']['cardDetails']['owner']);
        $cardDetails->setPan($request['paymentResult']['paymentMethod']['cardDetails']['pan']);
        $cardDetails->setType($request['paymentResult']['paymentMethod']['cardDetails']['type']);
        $cardDetails->setCardIssuerBank($request['paymentResult']['paymentMethod']['cardDetails']['cardIssuerBank']);

        $this->paymentResult = new PaymentResult;
        $this->paymentResult->setCardDetails($cardDetails);
        $this->paymentResult->setPaymentMethod($request['paymentResult']['paymentMethod']);
        $this->paymentResult->setPaymentDate($request['paymentResult']['paymentDate']);
        $this->paymentResult->setAuthCode((int) $request['paymentResult']['authCode']);
        $this->paymentResult->setMerchantId($request['paymentResult']['merchantId']);

        if (isset($request['paymentResult']['rrn'])) {
            $this->paymentResult->setRrn((int) $request['paymentResult']['rrn']);
        }

        if (isset($request['paymentResult']['installmentsNumber'])) {
            $this->paymentResult->setInstallmentsNumber($request['paymentResult']['installmentsNumber']);
        }

        if (isset($request['paymentResult']['cardProgramName'])) {
            $this->paymentResult->setCardProgramName($request['paymentResult']['cardProgramName']);
        }

        if (isset($request['paymentResult']['captureDate'])) {
            $this->paymentResult->setCaptureDate($request['paymentResult']['captureDate']);
        }

        return $this;
    }

    /** @inheritDoc */
    public function getPaymentResult(): PaymentResultInterface
    {
        return $this->paymentResult;
    }

    /** @inheritDoc */
    public function setPaymentResult(PaymentResultInterface $paymentResult): self
    {
        $this->paymentResult = $paymentResult;
        return $this;
    }

    /** @inheritDoc */
    public function getOrderData(): OrderDataInterface
    {
        return $this->orderData;
    }

    /** @inheritDoc */
    public function setOrderData(OrderDataInterface $orderData): self
    {
        $this->orderData = $orderData;
        return $this;
    }
}