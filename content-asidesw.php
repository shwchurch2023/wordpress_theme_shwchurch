<?php
/**
 * The template for displaying posts in the same catagories  in the Aside 
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */
?>


<?php 
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt');
?>
<div id="secondary">
	<?php 
	$cats = get_the_category();

	$cats = array_reverse($cats);


	$postId = get_the_ID();

	foreach ($cats as $key => $cat) :
		# code...

		?>
	<section class="cat-<?php echo $cat->cat_ID; ?> category">

		<h2 class="post-title"><a href="/category/<?php echo $cat->slug; ?>"><?php echo $cat->name; ?> &gt;&gt; </a></h2>
		<article>
			<?php 
			$args = array(
				'cat'        => $cat->cat_ID,
				'orderby'         => 'date',
				'order'           => 'DESC',
				'post_type'       => 'post',
				'post_status'     => 'publish',
				'posts_per_page'  =>100,
				'post__not_in'					=> array($postId),
				); 


			$the_query = new WP_Query( $args );

			while ( $the_query->have_posts() ) :

				$the_query->the_post();
			?>

			<li class="post-title"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></li>

		</article>
		<?php 
		endwhile;
		?>
		<h2 class="post-title"><a href="/category/<?php echo $cat->slug; ?>">全部 <?php echo $cat->name; ?> &gt;&gt; </a></h2>
	</section>
	<?php
	endforeach;
	?>
</div>
<?php 
add_filter('get_the_excerpt', 'wp_trim_excerpt');
remove_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt');
?>
