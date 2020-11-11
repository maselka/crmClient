<?php


namespace App\Models;

use Bitrix24\Bitrix24;
use Illuminate\Http\RedirectResponse;

class Bitrix24Client
{
//    Возможно лучше сделать константами
    private $login = 'tt7461023@gmail.com';
    private $password = 'forSpb178';
    private $memberId = '79fb12c8b959c1fc67f824e0bb7ba8ab';
    private $appId = 'local.5fa9abf86ac9e3.37838144';
    private $appSecret = 'dgQp23OpJ4zpd9qmXLgKD2mQF1jJbp1sGosYYNM73QosgxZLUq';
    private $appScope = ['crm', 'bizproc'];
    private $domain = 'b24-f7zipt.bitrix24.ru';
    private $redirectUrl = 'http://crm.localhost/get/lead';

    private $access_token;
    private $refresh_token;

    private $bitrix24Object;

    public function __construct()
    {
        $this->bitrix24Object = new Bitrix24();
    }

    public function FabricateBitrix24Object()
    {
        $this->bitrix24Object->setApplicationId($this->appId);
        $this->bitrix24Object->setApplicationSecret($this->appSecret);
        $this->bitrix24Object->setApplicationScope($this->appScope);
        $this->bitrix24Object->setDomain($this->domain);
        $this->bitrix24Object->setRedirectUri($this->redirectUrl);
    }

    public function redirectToBitrix24Auth($filter = '')
    {
        $url = 'https://' . $this->domain . '/oauth/authorize/' . '?client_id=' . $this->appId . '&state=' . $filter;
        $response = new RedirectResponse($url);
        $response->header('location', $url);

        return $response;
    }

    public function getFirstAccessToken($authCode)
    {
        $b24FirstStepResponse = $this->bitrix24Object->getFirstAccessToken($authCode);
        $this->bitrix24Object->setAccessToken($b24FirstStepResponse['access_token']);
        $this->bitrix24Object->setRefreshToken($b24FirstStepResponse['refresh_token']);

        return $this->getAccessToken();
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function getBitrix24Client()
    {
        return $this->bitrix24Object;
    }
}
