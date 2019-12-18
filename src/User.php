<?php
class User {
    public $client_id;
    public $email;
    public $name;
    public $sl_token;
    public $timestamp;

    function initializeUser($client_id, $email, $name){
      $this->client_id = $client_id;
      $this->email = $email;
      $this->name = $name;
      $this->sl_token = $this->requestToken();
      $this->timestamp = time();
      if($this->sl_token!=-1)return 1;
      else return 0;
    }

    private function requestToken(){
      $params = [
        'client_id'=>$this->client_id,
        'email'=>$this->email,
        'name'=>$this->name
      ];
      $sl_token = postRequest($params);
      return $sl_token;
    }
  }
  ?>