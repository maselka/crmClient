<?php


namespace App\Http\Controllers;

use Bitrix24\Bizproc\Activity;
use Bitrix24\Bitrix24;
use App\Models\Bitrix24Client;
use Bitrix24\CRM\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    public function getLeadsByFilter($title, $value)
    {
        $b24Client = new Bitrix24Client();
        $filter = http_build_query([$title => $value]);

        return $b24Client->redirectToBitrix24Auth($filter);
    }

    public function getAllLeads()
    {
        $b24Client = new Bitrix24Client();

        return $b24Client->redirectToBitrix24Auth();
    }

    public function getLeads(Request $request)
    {
        $b24Client = new Bitrix24Client();
        $b24Client->FabricateBitrix24Object();
        $b24Client->getFirstAccessToken($request->get('code'));
        $b24Lead = new Lead($b24Client->getBitrix24Client());

        return $b24Lead->getList([], $this->getFilterFromState($request->get('state')));
    }

    private function getFilterFromState($state)
    {
        parse_str($state, $filter);

        return $filter;
    }
}
