<?php

namespace Omnipay\ComfortPay\Message;

use SoapClient;
use SimpleXMLElement;

class ListOfExpirePerIdRequest extends AbstractSoapRequest
{
    public function getCardIds()
    {
        return $this->getParameter('cardIds');
    }

    public function setCardIds($value)
    {
        return $this->setParameter('cardIds', $value);
    }

    public function getData()
    {
        $this->validate('cardIds');

        $data = parent::getData();
        $data['cardIds'] = $this->getCardIds();
        return $data;
    }

    public function sendData($data)
    {
        if ($this->getTestmode()) {
            return $this->response = new ListOfExpirePerIdResponse($this, array_map(function ($id) {
                return [
                    'id' => $id,
                    'date' => '0199',
                ];
            }, $data['cardIds']));
        }

        $client = $this->getSoapClient();
        $client->__call('getListOfExpirePerId', ['listOfIds' => $data['cardIds']]);

        $xmlResponse = $client->__getLastResponse();
        $xml = new SimpleXMLElement($xmlResponse);
        $pairs = $xml->xpath('//pair');

        $resultData = array_map(function ($element) {
            return [
                'id' => (string)$element->idOfCard,
                'date' => (string)$element->expirationDate
            ];
        }, $pairs);

        return $this->response = new ListOfExpirePerIdResponse($this, $resultData);
    }
}
