<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>


<div class="right-content">
  <div class="right-content-wrapper">
    <!-- start of block of home main-*-hover -->
    <?php
    $i = 1;
    ?>
    <div id="main_worship_hover"
      class="item-<?php echo $i++; ?> main-content hover-layer border-bottom-radius opacity-default">
      <header><span class="title">主日敬拜</span><span class="sw-icon-close sw-icon"></span></header>

      <section>
        <?php

        $args = array(
          'cat' => 90,

        );

        sw_cat_2column($args);
        ?>


      </section>
      <footer>
        <h4 class="post-title"><a href="/category/%E4%B8%BB%E6%97%A5%E6%95%AC%E6%8B%9C%E7%A8%8B%E5%BA%8F/">更多..</a></h4>
      </footer>
    </div>

    <div id="main_sermon_hover"
      class="item-<?php echo $i++; ?>  main-content hover-layer border-bottom-radius opacity-default">
      <header><span class="title">讲道</span><span class="sw-icon-close sw-icon"></span></header>
      <section>
        <?php
        $args = array(
          'cat' => 89,
          'orderby' => 'date',
          'order' => 'DESC',
          'post_type' => 'post',
          'post_status' => 'publish',
          'suppress_filters' => true
        );
        sw_cat_2column($args);


        ?>




      </section>
      <footer>
        <h4 class="post-title"><a href="/category/sermon/">全部讲道..</a></h4>

        <h4 class="post-title"><a
            href="https://www.youtube.com/@%E5%9F%BA%E7%9D%A3%E6%95%99%E5%8C%97%E4%BA%AC%E5%AE%88%E6%9C%9B%E6%95%99%E4%BC%9A/podcasts">YouTube
            讲道</a></h4>

        <h4 class="post-title"><a
            href="https://podcasts.apple.com/us/podcast/%E8%AF%81%E9%81%93%E8%AE%B2%E9%81%93-%E5%9F%BA%E7%9D%A3%E6%95%99%E5%8C%97%E4%BA%AC%E5%AE%88%E6%9C%9B%E6%95%99%E4%BC%9A/id1238003974">iPhone
            播客</a></h4>
      </footer>
    </div>

    <div id="main_news_hover"
      class="item-<?php echo $i++; ?>  main-content hover-layer border-bottom-radius opacity-default">
      <header><span class="title">教会新闻</span><span class="sw-icon-close sw-icon"></span></header>
      <section>
        <?php
        sw_image_news();

        ?>


      </section>
      <footer>
        <h4 class="post-title"><a href="/category/%E6%95%99%E4%BC%9A%E6%96%B0%E9%97%BB/">更多..</a></h4>
      </footer>
    </div>

    <div id="main_ejournal_hover"
      class="item-<?php echo $i++; ?> main-content hover-layer border-bottom-radius opacity-default">
      <header><span class="title">《@守望》</span><span class="sw-icon-close sw-icon"></span></header>

      <section>
        <?php

        $args = array(
          'cat' => 82,

        );

        sw_cat_2column($args);
        ?>


      </section>
      <footer>
        <h4 class="post-title"><a href="/category/%e7%bd%91%e7%bb%9c%e6%9c%9f%e5%88%8a/">更多..</a></h4>
      </footer>
    </div>



    <div id="main_bylaw_hover"
      class="item-<?php echo $i++; ?>  main-content hover-layer border-bottom-radius opacity-default">
      <header><span class="title">教会条例</span><span class="sw-icon-close sw-icon"></span></header>
      <section>
        <?php
        $args = array(
          'cat' => 145,
          'displayType' => 'list-column-2',
          'nopaging' => false
        );
        sw_cat_2column($args);

        ?>


      </section>
      <footer>
        <!-- <h2 class="post-title"><a href="/category/sermon/">全部讲道..</a></h2> -->
      </footer>
    </div>

    <!-- end of block of home main-*-hover -->
  </div>
</div>
<?php
$j = 1;
?>

<div class="left-nav">
  <a id="main_worship" href="/category/%E4%B8%BB%E6%97%A5%E6%95%AC%E6%8B%9C%E7%A8%8B%E5%BA%8F/"
    class="default main-list item-<?php echo $j++; ?>"><span class="txt">主日敬拜</span></a>
  <a id="main_sermon" href="/category/sermon/" class="default main-list  item-<?php echo $j++; ?>"><span
      class="txt">讲道</span></a>
  <a id="main_news" href="" class="default main-list  item-<?php echo $j++; ?>"><span class="txt">教会新闻</span></a>
  <a id="main_ejournal" href="/category/%e7%bd%91%e7%bb%9c%e6%9c%9f%e5%88%8a/"
    class="main-list  item-<?php echo $j++; ?>"><span class="txt">@守望</span></a>
  <a id="main_bylaw" href="" class="main-list item-<?php echo $j++; ?>" title="查看守望各事工部门的规章制度文档"><span
      class="txt">教会条例</span></a>
</div>




<?php get_footer(); ?>