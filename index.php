<?php
  session_start();
  date_default_timezone_set('UTC');
  header('Content-Type: application/json');
  error_reporting(E_ERROR | E_PARSE);

  $jsonOutput = '';

  include './src/loadVars.php';
  include './src/helpers/pageParser.php';
  include './src/helpers/rangeTools.php';
  include './src/models/Connection.php';
  include './src/models/User.php';
  include './src/models/Range.php';
  include './src/models/Post.php';
  include './src/queries.php';

  $connectionParams = loadVars();
  if( !is_object($connectionParams) ) return 0;

  $newConnection = new Connection;
  $connectionInitialization = $newConnection->initializeConnection($connectionParams->client_id, $connectionParams->email, $connectionParams->name);
  $jsonOutput = $connectionInitialization->message;

  if( $connectionInitialization->success ){
    $posts = null;

    $posts = parseAllPagesToPosts($newConnection,1,10);
    $users = assignPostsToUsers($posts);

    $postKeys = array_keys($posts);
    $rangeBetweenFirstAndLastPost = new Range;
    $rangeBetweenFirstAndLastPost->start = $posts[ $postKeys[0] ]->timestamp;
    $rangeBetweenFirstAndLastPost->end = $posts[ $postKeys[ count($postKeys)-1 ] ]->timestamp;
    $ranges = splitRangeToMonths($rangeBetweenFirstAndLastPost);

    $dateFormat = "M d Y, G:i";
    $jsonOutput .= sprintf(
      '"timerange": {"first post":"%s", "last post":"%s"},',
      date($dateFormat,$rangeBetweenFirstAndLastPost->start),
      date($dateFormat,$rangeBetweenFirstAndLastPost->end));

    $usersOutput = '';
    $omitComma = true;
    foreach( $users as $user ){
      if( $omitComma ) $omitComma = false;
      else $usersOutput .= ',';
      $usersOutput .= $user->buildStatistics($posts,$ranges);
    }
    $jsonOutput .= sprintf('"users":[ %s ]', $usersOutput);
  }else unset($newConnection);

  printf('{%s}', $jsonOutput);
?>