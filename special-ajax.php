<?php
/*
Template Name: Special-Ajax
*/
?><?php
$getClientRequestData = $_GET;
if (!array_key_exists('postids', $getClientRequestData)) {
  echo json_encode(array());
  exit;
}

$getClientRequestData = json_decode($getClientRequestData['postids']);

$args = array(
  'post_status' => 'published',
  'orderby' => 'post__in',
  'post_type'=>'post',
  'post__in' => $getClientRequestData
  );

$query = new WP_query($args);

$response = array();
while(  $query->have_posts()) {

  $query->the_post();

  $response[] = array(
    'title' => get_the_title(),
    'content' => get_the_morehandled_content_json(),
    'id' =>get_the_ID(),
    'thumbnail' => get_the_post_thumbnail($theId, array(64,64)),
    );


}
$response = json_encode($response);
header("Content-Length: " . strlen($response));
echo $response; 
wp_reset_query();
?>