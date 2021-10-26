<?php
/**
 * Multi-Factor Authentication Module
 * for BoxBilling (https://github.com/boxbilling/boxbilling)
 * @Author Jason Long (https://londry.cn)
 * @License Apache-2.0
 * @CreatedAt 2021-10-26
 */
namespace Box\Mod\Mfa;

use Box\InjectionAwareInterface;
use PragmaRX\Google2FA\Google2FA;

class Service implements InjectionAwareInterface
{

    protected $di;

    public function setDi($di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }

    /**
     * @param string $emailAddress
     * @return array
     */
    public function createSecretKey($emailAddress)
    {
        $secretKey =  (new Google2FA())->generateSecretKey(23, 'bb-');
        $inlineUrl = (new \PragmaRX\Google2FAQRCode\Google2FA())->getQRCodeInline(
            'Company Name',
            $emailAddress,
            $secretKey
        );
        return [
            'secret'=>$secretKey,
            'inlineUrl'=>$inlineUrl
        ];
    }
}