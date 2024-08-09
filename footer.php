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
      'order' => 'ASC',
      'postArg' => array(
        'displayType' => 'list-column-3'
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

<div id="nav_all_cat_hover" class="hover-layer border-bottom-radius opacity-default">
  <header><span class="title">所有分类</span><span class="sw-icon-close sw-icon"></span></header>
  <section>
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
  'depth'              => 1,
  'current_category'   => 0,
  'pad_counts'         => 0,
  'taxonomy'           => 'category',
  'walker'             => null
); 

wp_list_categories( $args ); 

?>

  </section>
  <footer>
    <h2 class="post-title"><a href="/%E6%89%80%E6%9C%89%E5%88%86%E7%B1%BB/" target="_blank">更多..</a></h2> 
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
		<a id="nav_footer_wechat" href="https://shwchurch7.github.io/"  class="nav item_5">国内主页（镜像）</a>
		
		<a id="nav_footer_youtube" href="https://www.youtube.com/@%E5%9F%BA%E7%9D%A3%E6%95%99%E5%8C%97%E4%BA%AC%E5%AE%88%E6%9C%9B%E6%95%99%E4%BC%9A/podcasts"  class="nav item_6">YouTube</a>
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

<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/utility.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/common.js"></script>
</body>
</html>
