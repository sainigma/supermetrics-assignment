<?php
class Connection {
    public $client_id;
    public $email;
    public $name;
    public $sl_token;
    public $timestamp;

    public function tokenIsValid(){ return( !($this->sl_token==null || time()-$this->timestamp>3600) ); }

    public function initializeConnection($client_id, $email, $name){
      $this->client_id = $client_id;
      $this->email = $email;
      $this->name = $name;
      $this->loadTokenFromMemory();
      if( $this->tokenIsValid() ){
        printf('"status":"Token loaded from memory",');
        return 1;
      }else $this->requestAndSetToken();
      return $this->tokenIsValid();
    }

    private function requestAndSetToken(){
      printf('"status":"New token requested",');
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