<?php

namespace App\Services;

class EncryptionService
{
    private $key;
    private $cipher = 'aes-256-cbc';

    public function __construct()
    {
        $this->key = 'SisVendas@IFNMG2024!Sec#Key32Chars';
        
        $this->key = str_pad(substr($this->key, 0, 32), 32, "\0");
    }

    public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $encrypted = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public function decrypt($data)
    {
        try {
            list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
            $decrypted = openssl_decrypt($encrypted_data, $this->cipher, $this->key, 0, $iv);
            return $decrypted;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function encryptId($id)
    {
        return $this->encrypt((string)$id);
    }

    public function decryptId($encryptedId)
    {
        $decrypted = $this->decrypt($encryptedId);
        return is_numeric($decrypted) ? (int)$decrypted : null;
    }

    public function isEncryptedId($string)
    {
        if (!is_string($string)) {
            return false;
        }
        
        try {
            $decoded = base64_decode($string, true);
            if ($decoded === false) {
                return false;
            }
            
            return strpos($decoded, '::') !== false;
        } catch (\Exception $e) {
            return false;
        }
    }
}