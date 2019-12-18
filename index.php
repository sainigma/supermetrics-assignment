<?php
  include './src/loadVars.php'; //loads user parameters to object $restParams, environment variables to global
  include './src/User.php'; //class for user
  include './src/queries.php';

  $newUser = new User;
  $userInitializationSuccess=$newUser->initializeUser($restParams->client_id, $restParams->email, $restParams->name);
  if(!$userInitializationSuccess)unset($newUser);
  echo $userInitializationSuccess;
  print_r($newUser);

?>