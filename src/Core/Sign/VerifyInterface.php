<?php

namespace Omnipay\Core\Sign;

interface VerifyInterface
{
    public function verify($input, $sign, $sing_key = null);
}
