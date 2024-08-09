<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */
?>

</div><!-- #main -->


<div id="sw_tpl">

</div><!-- #page -->


<div id="nav_ev_hover" class="hover-layer border-bottom-radius opacity-default">
	<header><span class="title">福音窗口</span><span class="sw-icon-close sw-icon"></span></header>
	<section>
		<?php 
		$catArgs = array(
			'child_of'                 => 10,
			'order'	=> 'ASC',
			'postArg'	=> array(
				'displayType'	=> 'list-column-3'
				)
			);
		sw_cat_child_2column($catArgs);
			# code...
		?>

	</section>
	<footer>
		<h2 class="post-title"><a href="/category/%E7%A6%8F%E9%9F%B3%E7%AA%97%E5%8F%A3/" target="_blank">更多..</a></h2> 
	</footer>
</div>


<div id="nav_media_hover" class="hover-layer border-bottom-radius opacity-default">
	<header><span class="title">图片</span><span class="sw-icon-close sw-icon"></span></header>
	<section>
		<?php dynamic_sidebar('Nav Pics'); ?>
	</section>
	<footer>
		<h4 class="post-title"><a href="/%E5%9B%BE%E7%89%87">更多..</a></h4>
	</footer>
</div>
<footer id="colophon" role="contentinfo">
	<nav id="access_sw_2" role="navigation"  class="nav-wrapper opacity-header border-top-radius">
		<div class="padding-wrapper">
			<a id="nav_footer_contact" href="/2012/08/03/%E5%AE%88%E6%9C%9B%E6%95%99%E4%BC%9A-%E8%81%94%E7%B3%BB%E6%88%91%E4%BB%AC/" class="nav item_1">联系我们</a>
			<a id="nav_footer_about" href="/2012/08/03/%E5%85%B3%E4%BA%8E%E6%88%91%E4%BB%AC/"  class="nav item_2">教会简介</a>
			<a id="nav_footer_section" href="/category/%E4%BA%8B%E5%B7%A5%E9%83%A8%E9%97%A8/"  class="nav item_3">事工部门</a>
			<a id="nav_footer_faith" href="/2012/08/03/%E5%8C%97%E4%BA%AC%E5%AE%88%E6%9C%9B%E6%95%99%E4%BC%9A%E4%BF%A1%E4%BB%B0%E5%91%8A%E7%99%BD/"  class="nav item_4">信仰告白</a>
		</div>
	</nav><!-- #access -->
</footer><!-- #colophon -->

<div id="nav_group_hover" title="寻找小组" class="border-bottom-radius opacity-default hide">
	<section>
		<article>
			<?php sw_cat_2column(array(
				'page_id' => 3623
				)); ?>
				
			</article>
		</section>
	</div>
</div>
<script src="/wp-includes/js/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/utility.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/common.js"></script>
</body>
</html>

