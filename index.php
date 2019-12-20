<?php
  session_start();
  date_default_timezone_set('UTC');
  header('Content-Type: application/json');

  $posts_exist_locally = true;

  include './src/loadVars.php';
  include './src/helpers/pageParser.php';
  include './src/helpers/rangeTools.php';
  include './src/models/Connection.php';
  include './src/models/User.php';
  include './src/models/Range.php';
  include './src/models/Post.php';
  include './src/queries.php';

  printf('{');
  $newConnection = new Connection;
  $userInitializationSuccess=$newConnection->initializeConnection($connectionParams->client_id, $connectionParams->email, $connectionParams->name);
  
  if(!$userInitializationSuccess){
    printf('"status":"Failed to initialize connection"');
    unset($newConnection);
  }
  else{
    $posts = null;
    if($posts_exist_locally){
      $localPosts = file_get_contents('localPosts');
      $posts = unserialize($localPosts);
    }else{
      $posts = parseAllPagesToPosts($newConnection,1,10);
      $localPosts = serialize($posts);
      file_put_contents('localPosts',$localPosts);
    }

    $postKeys = array_keys($posts);
    $totalRange = new Range;
    $totalRange->start = $posts[ $postKeys[0] ]->timestamp;
    $totalRange->end = $posts[ $postKeys[ count($postKeys)-1 ] ]->timestamp;
    $ranges = splitRangeToMonths($totalRange);

    $users = assignPostsToUsers($posts);
    $usersOutput = '';
    $omitComma = true;
    foreach($users as $user){
      if($omitComma)$omitComma=false;
      else $usersOutput.=',';
      $usersOutput.=$user->buildStatistics($posts,$ranges);
    }
    printf('"users":[ %s ]', $usersOutput);
  }
  printf('}');
?>