<?php
  function postRequest($params){
    $responseStatus = 400;
    $query = curl_init();

    curl_setopt($query, CURLOPT_URL, $GLOBALS['uri_post']);
    curl_setopt($query, CURLOPT_POST, true);
    curl_setopt($query, CURLOPT_POSTFIELDS, $params);
    curl_setopt($query, CURLOPT_RETURNTRANSFER, true);

    $result = json_decode( curl_exec($query) );

    if( !curl_errno($query) ){
      $responseStatus = curl_getinfo($query, CURLINFO_HTTP_CODE);
    }
    curl_close($query);

    if( $responseStatus!=400 && !strcmp( $result->client_id, $params['client_id'] ) ){
      return $result->sl_token;
    }
    return -1;
  }
?>