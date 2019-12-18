<?php
  $dotenv = parse_ini_file(".env");
  $restParams = (object) [
    "client_id" => $dotenv['CLIENT_ID'],
    "email" => $dotenv['EMAIL'],
    "name" => $dotenv['NAME']
  ];
  $GLOBALS['uri_post'] = $dotenv['URI_POST'];
  $GLOBALS['uri_get'] = $dotenv['URI_GET'];
?>