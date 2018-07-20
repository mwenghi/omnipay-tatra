<?php

namespace Omnipay\Core\Sign;

class HmacVerify implements VerifyInterface
{
    public function verify($input, $sign, $publicKey = null)
    {
        return openssl_verify($input, pack("H*", $sign), $publicKey, "sha256");
    }
}
