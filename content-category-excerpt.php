<?php
/**
 * The template for displaying page content in the showcase.php page template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" >
	<header class="entry-header">
		<h2 class="entry-title show-link"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> &gt;&gt; </a></h2>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php echo get_the_excerpt(); ?>
	</div><!-- .entry-content -->
</article>
