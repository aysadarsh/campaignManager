<?php

namespace App\Validation;

use App\Models\User;
use App\Models\Store;

class MongoRules{

    public function validUsername($str='', $fields=''){
        
        // $str is username input field

        $userModel = new User();
        $storeModel = new Store();

        $user = $userModel->findById($str);
        $store = $storeModel->findById($str);

        if(!$user && !$store)
        {
            return false;
        }
        
        return true;
    }
    
    public function validateUser($str='', $fields='', $data = []){
        $userModel = new User();
        $storeModel = new Store();

        $user = $userModel->findById($data['username']);
        $store = $storeModel->findById($data['username']);

        if(!$user && !$store)
        {
            return false;
        }
        
        if($store)
        {
            
            $validPre = ['fr','or','sw','aes']; 
            $exp = explode('_',$data['username']);

            if((isset($exp[0]) && in_array($exp[0],$validPre)) || $store->storetype == 5)
            {
                return password_verify($data['password'], $store->password) || md5($data['password']) == $store->password;
            }    
            // store manager login check
            $user = $userModel->findById($store->sm_olmsid);
            if(!$user)
            {
                return false;
            }
        }
        return password_verify($data['password'], $user->password) || md5($data['password']) == $user->password;
    }
}