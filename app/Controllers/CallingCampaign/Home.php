<?php

namespace App\Controllers\CallingCampaign;

use App\Controllers\BaseController;
use App\Models\CampaignModel;
// use App\Libraries\Mconnect;
use MongoDB;

class Home extends BaseController
{


    public $campaignModel;
    public $collection;

    function __construct()
    {
        
    }

    public function index()
    {
        return view('campaign\index');
    }

    public function create()
    {
        if($this->request->getMethod() == 'post')
        {
            $campaignModel = new CampaignModel();
            $validation = $campaignModel->validate();
            if($this->validate($validation))
                {
                
                $name = $this->request->getVar('name');
                $find = $campaignModel->findCampaign($name);
                if(!isset($find))
                {
                    try{
                        
                        $campaignModel->insertCampaign($name);
                    
                    }
                    catch(\Exception $e)
                    {
                        $this->session->setFlashdata('error','Campaign '.$name.' failed to create !');
                    }
                }
                else{
                    $this->session->setFlashdata('error','Campaign '.$name.' failed to create !');
                }
                return redirect()->back();
            }
        }
        return view('campaign\create');
    }
}
