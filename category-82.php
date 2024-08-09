<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */

get_header(); ?>

<section id="primary" class="ejournal">
		<div id="content" role="main">
<?php


$qo = get_queried_object();

sw_show_ejournal_category($qo->cat_ID);

?>
	</div>
</section><!-- #primary -->
<div id="secondary"  class="ejournal">
	<?php 
	// $currentCats = get_queried_object();

	// $parentCatId = $currentCats->term_id;
	$parentCatId = '82';
	sw_list_child_cat(array(
		'parent' => $parentCatId,
    'right_top_html' => '<h2 class="post-title"><a href="/%E7%BD%91%E5%88%8Apdf%E4%B8%8B%E8%BD%BD/">PDF下载</a></h2><p>&nbsp;</p>'
		));
	
	
		?>

	</div>
	<?php get_footer(); ?>
