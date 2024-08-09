<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */

get_header(); ?>

<section id="primary" class="xinghua">
		<div id="content" role="main">
<?php


$qo = get_queried_object();

sw_show_xinghua_category($qo->cat_ID);


?>
	</div>
</section><!-- #primary -->
<div id="secondary"  class="xinghua">
	<?php 
	// $currentCats = get_queried_object();

	// $parentCatId = $currentCats->term_id;
	$parentCatId = '30';
	sw_list_child_cat(array(
		'child_of' => $parentCatId,
    'right_top_html' => '<h2 class="post-title"><a href="/%E6%9D%8F%E8%8A%B1pdf%E4%B8%8B%E8%BD%BD/">PDF下载</a></h2><p>&nbsp;</p>'
		));
	
	
		?>

	</div>
	<?php get_footer(); ?>
