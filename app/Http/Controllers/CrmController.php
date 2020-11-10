<?php


namespace App\Http\Controllers;

use Bitrix24\Bizproc\Activity;
use Bitrix24\Bitrix24;
use Bitrix24\CRM\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    private $login = 'tt7461023@gmail.com';
    private $password = 'forSpb178';
    private $appId = 'local.5fa9abf86ac9e3.37838144';
    private $appSecret = 'dgQp23OpJ4zpd9qmXLgKD2mQF1jJbp1sGosYYNM73QosgxZLUq';
    private $appScope = ['crm', 'bizproc'];
    private $appDomain = 'b24-f7zipt.bitrix24.ru';
    private $redirectUrl = 'http://crm.localhost/get/lead';
    private $memberId = '79fb12c8b959c1fc67f824e0bb7ba8ab';

    public function getLeadByFilter(Request $request)
    {
        if(!$request->has('code')) {
            $filter = http_build_query([$request->get('title') => $request->get('value')]);
            $url = 'https://' . $this->appDomain . '/oauth/authorize/' . '?client_id=' . $this->appId . '&state=' . $filter;
            $response = new RedirectResponse($url);
            $response->header('location', $url);

            return ($response);
        }

        $b24Client = new Bitrix24();
        $b24Client->setApplicationId($this->appId);
        $b24Client->setApplicationSecret($this->appSecret);
        $b24Client->setApplicationScope($this->appScope);
        $b24Client->setDomain($this->appDomain);
        $b24Client->setRedirectUri($this->redirectUrl);

        $b24FirstStepResponse = $b24Client->getFirstAccessToken($request->get('code'));
        $b24Client->setAccessToken($b24FirstStepResponse['access_token']);
        $b24Client->setRefreshToken($b24FirstStepResponse['refresh_token']);

        $b24Lead = new Lead($b24Client);

        return $b24Lead->getList([], ['COMPANY_TITLE' => 'Нужная компания']);
    }
}
