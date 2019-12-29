<?php
class Connection {
    public $client_id;
    public $email;
    public $name;
    public $sl_token;
    public $timestamp;

    public function tokenIsValid(){ return( !($this->sl_token==null || time()-$this->timestamp>3600) ); }

    public function initializeConnection($client_id, $email, $name){
      $result = (object) array(
        'message' => 'error',
        'success' => 0
      );
      $this->client_id = $client_id;
      $this->email = $email;
      $this->name = $name;
      $this->loadTokenFromMemory();
      if( $this->tokenIsValid() ){
        $result->message = '"status":"Token loaded from memory",';
        $result->success = 1;
      }else{
        $result->message = '"status":"New token requested",';
        $this->requestAndSetToken();
        $result->success = $this->tokenIsValid();
      }
      if(!$result->success){
        $result->message = '"status":"Failed to initialize connection"';
      }
      return $result;
    }

    private function requestAndSetToken(){
      $params = [
        'client_id'=>$this->client_id,
        'email'=>$this->email,
        'name'=>$this->name
      ];
      $sl_token = requestToken($params);
      if( $sl_token!=-1 ){
        $this->sl_token = $sl_token;
        $this->timestamp = time();
        $_SESSION['sl_token'] = $this->sl_token;
        $_SESSION['timestamp']= $this->timestamp;
      }
    }

    private function loadTokenFromMemory(){
      if( ISSET($_SESSION['sl_token']) && ISSET($_SESSION['timestamp'])){
        $this->sl_token=$_SESSION['sl_token'];
        $this->timestamp=$_SESSION['timestamp'];
      }else{
        $this->sl_token=null;
        $this->timestamp=null;
      }
    }
  }
  ?>