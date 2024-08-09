<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */

get_header(); 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt'); 

?>

<section id="primary">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php
			printf( __( 'Category Archives: %s', 'shwchurch' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			?></h1>

			<?php
			$category_description = category_description();
			if ( ! empty( $category_description ) )
				echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
			?>
		</header>

		<?php shwchurch_content_nav( 'nav-above' ); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

		<?php
		#get_template_part( 'content', get_post_format() );
		get_template_part( 'content-category-excerpt');
		?>

	<?php endwhile; ?>

	<?php shwchurch_content_nav( 'nav-below' ); ?>

<?php else : ?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'shwchurch' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'shwchurch' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

<?php endif; ?>

</div><!-- #content -->
</section><!-- #primary -->
<div id="secondary">
	<?php 
	$currentCats = get_queried_object();

	$parentCatId = $currentCats->term_id;
	if ($parentCatId !== "0") {
		sw_list_child_cat(array(
			'parent' => $parentCatId
			));
	}

	get_template_part( 'content-asidesw-noexcert');


	?>

</div>
<?php 
add_filter('get_the_excerpt', 'wp_trim_excerpt');
remove_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt'); 
get_footer(); 
?>
