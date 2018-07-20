<?php

namespace Omnipay\CardPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Core\Message\AbstractRequest;
use Omnipay\Core\Sign\HmacVerify;

class PurchaseNotifyResponse extends AbstractResponse implements NotificationInterface {

    const RESPONSE_STATUS_OK        = 'OK';
    const RESPONSE_STATUS_ERROR     = 'FAIL';

    public function getTransactionStatus()
    {
        // TODO: Implement getTransactionStatus() method.
    }

    public function getMessage()
    {
        // TODO: Implement getMessage() method.
    }

    public function isSuccessful()
    {
        $verified = $this->verifyResponse();
        return $verified;
    }


    private function verifyResponse()
    {
        $request = $this->getRequest();
        $data = $this->data;

        $stringToSign = [
            $data["AMT"],
            $data["CURR"],
            $data["VS"],
            $data["RES"],
            $data["AC"],
            $data["TID"],
            $data["TIMESTAMP"],
            $data["HMAC"]
        ];

        $sign = new HmacVerify();
        $publicKey = config("eshop.payment_cardpay.public_ecdsa")[$data["ECDSA_KEY"]];
        return $sign->verify(implode("", $stringToSign), $data["ECDSA"], $publicKey)
                && $data["RES"] == self::RESPONSE_STATUS_OK;
    }


}
