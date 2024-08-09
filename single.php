<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	while ( have_posts() ) : the_post();
	$response = array(
		'title' => get_the_title(),
		'content' => get_the_morehandled_content_json(),
		'id' =>get_the_ID()
		);

	echo json_encode($response);
	endwhile;
	?>
<?php 
} else {
get_header(); ?>

<div id="primary">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>


		<?php get_template_part( 'content', 'single' ); ?>
		<nav id="nav-single">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'shwchurch' ); ?></h3>
			<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'shwchurch' ) ); ?></span>
			<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'shwchurch' ) ); ?></span>
		</nav><!-- #nav-single -->

		<div id="disqus_thread"></div>	
		<!--<//?php comments_template( '', true ); //?>-->

	<?php endwhile; // end of the loop. ?>

</div><!-- #content -->
</div><!-- #primary -->
<?php 
get_template_part('content', 'asidesw');
?>

<?php 

get_footer();

} ?>