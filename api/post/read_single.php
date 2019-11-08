<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$document_root = $_SERVER['DOCUMENT_ROOT'];
include($document_root.'/php_rest/config/Databse.php');
include_once '../../models/Post.php';

// instantiate DB and connect
$database = new Database();
$db = $database->connect();

// instantiate blog post
$post = new Post($db);

// Get ID from URL
$post->id = isset($_GET['id']) ? $_GET['id'] : die;

// GET post from query
$post->read_single();

// create array
$post_arr = array('single post' => 
array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
    )
);

// make json
print_r(json_encode($post_arr));