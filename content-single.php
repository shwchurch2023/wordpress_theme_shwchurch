<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<footer class="entry-meta" id="current_cat_container">
		<?php
		$categories = get_the_category();
		$seperator = ' ';
		$output = '';
		if($categories){
			foreach($categories as $category) {
				$output .= '<a class="nav category" href="'.get_category_link($category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$seperator;
			}
			echo trim($output, $seperator);
		}
		$tags = get_the_tags( );
		$output = '';
		if ( $tags ):
			foreach($tags as $tag) {
				$output .= '<a class="nav tag" href="'.get_tag_link($tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a>'.$seperator;
				echo trim($output, $seperator);
			}
		endif; // End if $tags_list 
		?>

		

		


	</footer>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta post-date">
			<?php shwchurch_posted_on(); ?>
		</div><!-- .entry-meta -->
	<?php endif; ?>
</header><!-- .entry-header -->

<div class="entry-content">
	<?php the_morehandled_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'shwchurch' ) . '</span>', 'after' => '</div>' ) ); ?>
</div><!-- .entry-content -->

		<!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->