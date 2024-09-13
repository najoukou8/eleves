<?php

namespace App\Security;

class MyEncryption
{

    public $pubkey  = "" ;
    public $privkey = "";

    public function __construct()
    {
        $this->pubkey  = file_get_contents(__DIR__."/../../config/jwt/public.pem");
        $this->privkey = file_get_contents(__DIR__."/../../config/jwt/private.pem");
    }

    public function encrypt($data)
    {
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
            $data = base64_encode($encrypted);
        else
            throw new \Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }

    public function decrypt($data)
    {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }
}