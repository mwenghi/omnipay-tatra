<?php

namespace Omnipay\CardPay\Message;

use Illuminate\Support\Facades\Request;
use Omnipay\Common\Http\Client;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Core\Message\AbstractRequest;

class PurchaseNotifyRequest extends AbstractRequest implements NotificationInterface
{
    /**
     * Copy of the POST data sent in.
     */
    protected $data;
    /**
     * Initialise the data from the server request.
     */
    public function __construct(Client $httpClient, \Symfony\Component\HttpFoundation\Request $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);
        // Grab the data from the request if we don't already have it.
        // This would be a good place to convert the encoding if required
        // e.g. ISO-8859-1 to UTF-8.
        $this->data = $httpRequest->request->all();
    }

    public function getData()
    {
        return $this->data;
    }

    public function setTransactionReference($reference)
    {
    }


    public function sendData($data)
    {
        $query = $this->httpRequest->query;

        $data["AMT"] = $query->get("AMT");
        $data["CURR"] = $query->get("CURR");
        $data["VS"] = $query->get("VS");
        $data["RES"] = $query->get("RES");
        $data["AC"] = $query->get("AC");
        $data["TID"] = $query->get("TID");
        $data["TIMESTAMP"] = $query->get("TIMESTAMP");
        $data["HMAC"] = $query->get("HMAC");
        $data["ECDSA_KEY"] = $query->get("ECDSA_KEY");
        $data["ECDSA"] = $query->get("ECDSA");

        return $this->response = new PurchaseNotifyResponse($this, $data);
    }

    public function getTransactionStatus()
    {
        // TODO: Implement getTransactionStatus() method.
    }

    public function getMessage()
    {
        // TODO: Implement getMessage() method.
    }


}
