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
	$cats = get_the_category();

	$cats = array_reverse($cats);


	$postId = get_the_ID();

	foreach ($cats as $key => $cat) :
		# code...

		?>
	<section class="cat-<?php echo $cat->cat_ID; ?> category-post-list no-excerpt">

		<h2 class="post-title"><a href="/category/<?php echo $cat->slug; ?>"><?php echo $cat->name; ?> &gt;&gt; </a></h2>
		<article>
			<?php 
			$args = array(
				'cat'        	  => $cat->cat_ID,
				'orderby'         => 'date',
				'order'           => 'DESC',
				'post_type'       => 'post',
				'post_status'     => 'publish',
				'post__not_in'					=> array($postId),
				'posts_per_page'  =>-1
				); 


			$the_query = new WP_Query( $args );

			while ( $the_query->have_posts() ) :

				$the_query->the_post();
			?>

			<li class="post-title"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></li>

			<?php 
			endwhile;
			?>
		</article>
	</section>
	<?php
	endforeach;
	?>

