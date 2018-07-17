<?php

namespace Omnipay\Core\Sign;

class HmacVerify implements VerifyInterface
{
    public function verify($input, $sign, $sing_key = null)
    {
        $publicKey = "-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEozvFM1FJP4igUQ6kP8ofnY7ydIWksMDk1IKXyr/T
RDoX4sTMmmdiIrpmCZD4CLDtP0j2LfD7saSIc8kZUwfILg==
-----END PUBLIC KEY-----"; // openssl_get_publickey($sing_key);
        return openssl_verify($input, pack("H*", $sign), $publicKey, "sha256");
    }
}
