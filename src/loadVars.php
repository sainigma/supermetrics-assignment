<?php
  function loadVars(){
    if(!file_exists('./src/.env')){
      printf('{ "status":"failed to load environment variables from .env, does the file exist? (file is omitted by .gitignore)"   }');
      return 0;
    }
    $dotenv = parse_ini_file(".env");
    
    $connectionParams = (object) [
      "client_id" => $dotenv['CLIENT_ID'],
      "email" => $dotenv['EMAIL'],
      "name" => $dotenv['NAME']
    ];
    $GLOBALS['uri_post'] = $dotenv['URI_POST'];
    $GLOBALS['uri_get'] = $dotenv['URI_GET'];
    return $connectionParams;
  }
?>