<?php
/*
Template Name: Special-Xmas-2012
*/
?>

<?php

?>



<?php get_template_part( 'header', 'simple' ); ?>
<?php
?>

  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/smoothness/special-xmas-2012.css" />

		<div id="primary">
			<div id="content" role="main">
        <article id="height_wrapper"></article>

				<?php

        $defaultView = array(
          'view' => 'left-excerpt',
          'ids' => array()
          );

        $args = array(
          'post_status' => 'published',
          'orderby' => 'post__in',
          'post_type'=>'post',
          'post__in' => array(  6690, 6684, 6682, 6680, 6678, 6676, 6674, 6672, 6670, 6667, 6665, 6663, 6661, 6659, 6657, 6655),
          'post_mymeta' => array(
            6670 => array(
              'tile_type' => 'left_image' // default: bottom_image; options: left_image | right_image | bottom_image | no_image
              ),
            6665 => array(
              'tile_type' => 'left_image' // default: bottom_image; options: left_image | right_image | bottom_image | no_image
              ),
            6676 => array(
              'tile_type' => 'right_image' // default: bottom_image; options: left_image | right_image | bottom_image | no_image
              ),
            ), 
          );

        $query = new WP_query($args);


        $countPosts = $query->post_count;

        $ids = array();

        $rightAside = array();

        if ( $query->have_posts() ) {
          $i = 0;
          while(  $query->have_posts()) {

            $query->the_post();

            global $more;
            $more = 0;
            // show image
            $theId = get_the_ID();

            $theLink = '/?p=' . $theId;

            $theTitle = get_the_title();

            $ids[] = $theId;

            $hasThumbnail = has_post_thumbnail();

            $rightAside['post_' . $theId] = array(
              'thumbnail' => $hasThumbnail ? get_the_post_thumbnail($theId, array(64,64)): '',
              'title' => $theTitle,
              'id' => $theId
              );

            $position_left = '';
            $position_right = '';
            $position_bottom = '';
            $articleLayoutClass = 'inline';

            $postMyMeta = $args['post_mymeta'];
            if (array_key_exists($theId, $postMyMeta)) {
              if (array_key_exists('tile_type', $postMyMeta[$theId])) {
                switch ($postMyMeta[$theId]['tile_type']) {
                  case 'left_image':
                    $position_left .= get_the_post_thumbnail($theId, array(160,120)) ; 
                    $articleLayoutClass .= ' left-image';
                    break;

                  case 'right_image':
                    $position_right .= get_the_post_thumbnail($theId, array(160,120)); 
                    $articleLayoutClass .= ' right-image';
                    break;

                  case 'no_image':
                    $articleLayoutClass .= ' no-image';
                    break;
                  
                  default:
                    $position_bottom .= get_the_post_thumbnail($theId, array(400,300));
                    break;
                }
                
              } else {
                $position_bottom .= get_the_post_thumbnail($theId, array(400,300));
              }
            } else {
                $position_bottom .= get_the_post_thumbnail($theId, array(400,300));
              } 

            if (!$hasThumbnail) {
              $articleLayoutClass = ' no-thumbnail ';
              $position_left = $position_right = $position_bottom = ''; 
            } elseif (!empty($position_bottom)) {
              $articleLayoutClass = ' bottom-image';
            }
            ?>
            <article id="article_<?php echo $i ?>" data-id="<?php echo $theId;?>" class="item-<?php echo $i ?> <?php echo $i%2 ? 'even' : 'odd' ?> <?php echo $i == $countPosts - 1 ? 'last' : '' ?> <?php echo $articleLayoutClass;?>  post-<?php echo $theId;?> " <?php post_class(); ?>>
              <div class="inner">
                <header class="entry-header">
                  <h1 class="entry-title"><a href="<?php echo the_permalink(); ?>" class="title" ><?php echo $theTitle; ?></a></h1>
                </header><!-- .entry-header -->
                <div class="entry-content">
                  <?php 
                  echo $position_left;
                  ?>
                  <?php the_content('');?>
                  <?php 
                  echo $position_right;
                  ?>
                  <?php 
                  echo $position_bottom;
                  ?>
                </div>
                <div class="entry-foot">
                  <?php  /*comments_template( '', true );*/ ?>
                </div>
              </div>
            </article>

            <?php 
            $i++;
          }
        }
        wp_reset_query();


        ?>

			</div><!-- #content -->
		</div><!-- #primary -->
    <div id="tpl_container">
      <article class="single" id="single-%_id_%">
        <div class="inner">
          <a class="back-icon" href="javascript:void(0)" title="后退到概览列表.."></a>
          <header class="entry-header">%_title_%
          </header><!-- .entry-header -->
          <div class="entry-content">%_content_%</div>
          <div class="entry-foot">
            <?php  /*comments_template( '', true );*/ ?>
          </div>
        </div>
      </article> 
      <article class="item-%_i_% no-thumbnail   post-%_id_% " data-id="%_id_%" id="article_%_i_%">
        <div class="inner">
          <header class="entry-header">
            <h1 class="entry-title"><a class="title" href="%_link_%">%_title_%</a></h1>
          </header><!-- .entry-header -->
          <div class="entry-content">%_content_%</div>
          <div class="entry-foot">
          </div>
        </div>
      </article>
    </div>
    <div id="data_container" data-viewdata='<?php echo json_encode($defaultView); ?>' data-ids='<?php echo json_encode($ids); ?>' data-rightaside='<?php echo json_encode($rightAside); ?>'>
    </div>

    <?php get_template_part( 'footer', 'simple' ); ?>
    <script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/special-xmas-2012.js"></script>
