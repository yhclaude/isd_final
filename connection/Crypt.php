<?php
class Crypt
{
    public function __construct()
    {
        $this->key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
        $this->alg = MCRYPT_RIJNDAEL_128;
    }

    public function encrypt2($data) {
        $blocksize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $pad = $blocksize - (strlen($data) % $blocksize);
        $data .= str_repeat(chr($pad), $pad);
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $data, MCRYPT_MODE_ECB);
        return base64_encode($encrypted);
    }

    public function decrypt2($encrypted) {
        $encrypted = base64_decode($encrypted);
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $encrypted, MCRYPT_MODE_ECB);
        $strPad = ord($decrypted[strlen($decrypted)-1]);
        return substr($decrypted, 0, -$strPad);
    }

    public function encrypt($plaintext) {
        $iv_size = mcrypt_get_iv_size($this->alg, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $ciphertext = mcrypt_encrypt($this->alg, $this->key, $plaintext, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;
        return base64_encode($ciphertext);
    }

    public function decrypt($ciphertext_base64) {
        $iv_size = mcrypt_get_iv_size($this->alg, MCRYPT_MODE_CBC);
        $ciphertext_dec = base64_decode($ciphertext_base64);
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);
        $plaintext_dec = @mcrypt_decrypt($this->alg, $this->key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
        return rtrim($plaintext_dec, "\0");
    }
}
