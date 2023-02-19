<?php 

namespace App\Models;

use App\Libraries\MdatabaseConnector;

class CampaignModel{
    
    private $collection;

    function __construct()
    {
        $connection = new MdatabaseConnector();
        $databse = $connection->getDatabase();
        $this->collection = $databse->campaigns;

    }

    function validate()
    {
        return [
            'name'=>'required'
        ];
    }

    function findCampaign($name = '')
    {
        $campaign = $this->collection->findOne(array("name"=>'test'));

        try{
            $campaign = $this->collection->findOne(['name'=>$name]);
            return $campaign;
        }
        catch(\MongoDB\Exception\RuntimeException $e)
        {
            throw new Exception("Error while finding campaign ".$name);
        }
    }

    function insertCampaign($name)
    {
      try{

        $currentTime = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s')) *1000);

        $data = [
            'name'=>$name,
            'status'=>false,
            'created_at'=> $currentTime
        ];

        print_r($data);

        $insertOneResult = $this->collection->insertOne($data);
  
        if($insertOneResult->getInsertedCount() == 1)
        {
          return true;
        }
        return false;
      }
      catch(\MongoDB\Exception\RuntimeException $ex)
      {
        throw new Exception("Error while creating campaign ".$name);
      }
    }

}