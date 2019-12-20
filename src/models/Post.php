<?php
class Post{
  public $id;
  public $from_name;
  public $from_id;
  public $message;
  public $type;
  public $timestamp;

  public function process($post){
    $this->id = $post->id;
    $this->from_name = $post->from_name;
    $this->from_id = $post->from_id;
    $this->message = $post->message;
    $this->type = $post->type;
    $this->timestamp = strtotime($post->created_time);
  }  
}
?>