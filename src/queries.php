<?php

  function runQuery( $URI, $method, $params, $useFields ){
    $query = curl_init();

    if( !$useFields ) $urlParams = '?'.http_build_query($params);
    else $urlParams = '';

    curl_setopt($query, CURLOPT_URL, $URI.$urlParams);
    if( !strcmp($method,"POST") )curl_setopt($query, CURLOPT_POST, true);
    if( $useFields )curl_setopt($query, CURLOPT_POSTFIELDS, $params);
    curl_setopt($query, CURLOPT_RETURNTRANSFER, true);

    $result = json_decode( curl_exec($query) );

    if( !curl_errno($query) ){
      $responseStatus = curl_getinfo($query, CURLINFO_HTTP_CODE);
    }
    curl_close($query);
    $response['result'] = $result;
    $response['status'] = $responseStatus;
    return $response;
  }

  function requestToken($params){
    $response = runQuery( $GLOBALS['uri_post'], "POST", $params, true);
    if( $response['status'] != 400 && !strcmp( $response['result']->data->client_id, $params['client_id'] ) ){
      return $response['result']->data->sl_token;
    }else return -1;
  }

  function requestPage($sl_token, $page){
    $params = [
      'sl_token'=>$sl_token,
      'page'=>$page
    ];
    $response = runQuery( $GLOBALS['uri_get'], "GET", $params, false);
    if( $response['status']!==400 ) return $response['result'];
    else return -1;
  }
?>