<?php

namespace Alive2212\LaravelCryptService;

use Alive2212\LaravelCrawlerService\LaravelCrawlerService;
use Exception;
use Illuminate\Support\Facades\App;

class LaravelCryptService
{
    /**
     * @var
     */
    protected $publicKey;

    /**
     * @var
     */
    protected $privateKey;

    /**
     * LaravelCryptService constructor.
     */
    public function __construct()
    {
        //
    }

    public function loadKeys()
    {
        $this->setPrivateKey(file_get_contents(App::basePath().'/'.$this->getPrivateKeyAddress()));
        $this->setPublicKey(file_get_contents(App::basePath().'/'.$this->getPublicKeyAddress()));
    }


    /**
     * @param $data
     * @return string
     * @throws Exception
     */
    public function encrypt($data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        if (openssl_public_encrypt($data, $encrypted, $this->publicKey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }

    /**
     * @param $data
     * @return string
     */
    public function decrypt($data)
    {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privateKey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param mixed $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param mixed $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return string
     */
    public function getPrivateKeyAddress()
    {
        return config('laravel-crypt-service.file.address') .
            '/' .
            config('laravel-crypt-service.file.name');
    }

    /**
     * @return string
     */
    public function getPublicKeyAddress()
    {
        return config('laravel-crypt-service.file.address') .
            '/' .
            config('laravel-crypt-service.file.name') .
            '.pub';
    }
}