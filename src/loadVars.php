<?php
  $dotenv = parse_ini_file(".env");
  $connectionParams = (object) [
    "client_id" => $dotenv['CLIENT_ID'],
    "email" => $dotenv['EMAIL'],
    "name" => $dotenv['NAME'],
    "uri_post" => $dotenv['URI_POST'],
    "uri_get" => $dotenv['URI_GET']
  ];
  $GLOBALS['uri_post'] = $dotenv['URI_POST'];
  $GLOBALS['uri_get'] = $dotenv['URI_GET'];
?>