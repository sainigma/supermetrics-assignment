<?php

function sortPostsByTimestamp($posts){
  function cmp($a, $b){ return $a->timestamp > $b->timestamp; }
  uasort($posts, "cmp");
  return $posts;
}

function assignPostsToUsers($posts){
  $users = [];
  foreach($posts as $post){
    $user_id = $post->from_id;
    if( ISSET( $users[ $user_id ] )){
      $users[ $user_id ]->appendPost($post);
    }else{
      $newUser = new User;
      $newUser->initializeUser($post);
      $users[ $user_id ] = $newUser;
    }
  }
  return $users;
}

function parsePage($page,$posts){
  foreach( $page->data->posts as $post ){
    $newPost = new Post;
    $newPost->process($post);
    $posts[$post->id] = $newPost;
  }
  return $posts;
}

function parseAllPagesToPosts($connection, $start, $end){
  $posts = [];
  for( $i=$start; $i<=$end; $i++ ){
    $page = requestPage($connection->sl_token,$i);
    $posts = parsePage($page,$posts);
  }
  $posts = sortPostsByTimestamp($posts);
  return $posts;
}

?>