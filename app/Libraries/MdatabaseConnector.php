<?php
namespace App\Libraries;

use function PHPUnit\Framework\throwException;

use MongoDB;

use Exception;

class MdatabaseConnector{

  private $client;
  public $database;
  
  function __construct()
  {
    
    $uri = getenv('MONGO_URI');
    $database = getenv('MONGO_DATABASE');

    if(empty($uri) || empty($database))
    {
      throw new Exception('Please declare MONGO_URI AND MONGO_DATABASE in your .env file');
    }

    try{
      $this->client = new MongoDB\Client($uri);
    }
    catch(MongoDB\Driver\Exception\MongoConnectionException $ex)
    {
      throw new Exception('Colud\'t connect to database: '.$ex->getMessage(), 500);
    }

    try{
      $this->database =  $this->client->selectDatabase($database);
    }
    catch(MongoDB\Driver\Exception\RuntimeException $ex)
    {
      throw new Exception('Error while fetching database with name: '.$database.$ex->getMessage(),500);
    }

  }

  function getDatabase()
  {
    // return  new MongoDB\BSON\UTCDateTime(strtotime($date) *1000);
    return $this->database;
  }
	
}