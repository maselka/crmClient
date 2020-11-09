<?php


namespace App\Http\Controllers;

use Bitrix24\Bizproc\Activity;
use Bitrix24\Bitrix24;
use Bitrix24Authorization\Bitrix24Authorization;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CrmController extends Controller
{
    public function startForAllLeads()
    {
        $b24Object = new Bitrix24();
        $b24Auth = new Bitrix24Authorization ();
        $b24Auth->setApplicationId('local.5fa41825ec5307.82173491');
        $b24Auth->setApplicationSecret('aZ87e88YqzZ9E9esHb3sNhCG3ZamU1uo4uywhE7TJtAcwbIU2p');
        $b24Auth->setApplicationScope('crm, bizproc');
        $b24Auth->setBitrix24Domain('crm.localhost');
        $b24Auth->setBitrix24Login('gabdullinmr@gmail.com');
        $b24Auth->setBitrix24Password('A4tech1234');
        $b24AuthUser = $b24Auth->initialize($b24Object);



        var_dump($b24Auth->bitrix24_access);
        return '1';
    }
}
