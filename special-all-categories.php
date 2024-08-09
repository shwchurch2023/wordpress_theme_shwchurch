<?php
/*
Template Name: Special-All-Categories
*/
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <title>所有分类</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
a {
  text-decoration: none;
  font-size: 13px;
  color:#666;
}
#single_page {
-webkit-column-count:3; /* Safari and Chrome */
column-count:3;
list-style:none;
margin: 20px 30px 50px 30px;
line-height: 2em;
}
#single_page li {
padding: 0 10px;
}
#single_page li:nth-child(2n) {
background: #F3F3F3;
}
@media screen and (max-width: 720px) {
  #single_page {
    -webkit-column-count:1; /* Safari and Chrome */
    column-count:1;
    list-style:none;
    margin: 10px;
    line-height: 2em;
  }
}

</style>
</head>
<body>


<section id="single_page" class="all-cats">
    <div id="content" role="main">

<?php 
$args = array(
  'show_option_all'    => '',
  'orderby'            => 'ID',
  'order'              => 'DESC',
  'style'              => 'list',
  'show_count'         => 0,
  'hide_empty'         => 1,
  'use_desc_for_title' => 1,
  'child_of'           => 0,
  'feed'               => '',
  'feed_type'          => '',
  'feed_image'         => '',
  'exclude'            => '',
  'exclude_tree'       => '',
  'include'            => '',
  'hierarchical'       => 1,
  'title_li'           => '',
  'show_option_none'   => __('No categories'),
  'number'             => null,
  'echo'               => 1,
  'depth'              => -1,
  'current_category'   => 0,
  'pad_counts'         => 0,
  'taxonomy'           => 'category',
  'walker'             => null
); 

wp_list_categories( $args ); 

?>
  </div>
</section><!-- #primary -->
</body>
</html>
