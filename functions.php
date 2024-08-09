<?php
/**
 * 北京守望教会 functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, shwchurch_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since 北京守望教会 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
  $content_width = 584;

/**
 * Tell WordPress to run shwchurch_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'shwchurch_setup' );

if ( ! function_exists( 'shwchurch_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override shwchurch_setup() in a child theme, add your own shwchurch_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
 *  and backgrounds, and post formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_setup() {

  /* Make 北京守望教会 available for translation.
   * Translations can be added to the /languages/ directory.
   * If you're building a theme based on 北京守望教会, use a find and replace
   * to change 'shwchurch' to the name of your theme in all the template files.
   */
  load_theme_textdomain( 'shwchurch', get_template_directory() . '/languages' );

  // This theme styles the visual editor with editor-style.css to match the theme style.
  add_editor_style();

  // Load up our theme options page and related code.
  require( get_template_directory() . '/inc/theme-options.php' );

  // Grab 北京守望教会's Ephemera widget.
  require( get_template_directory() . '/inc/widgets.php' );

  // Add default posts and comments RSS feed links to <head>.
  add_theme_support( 'automatic-feed-links' );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menu( 'primary', __( 'Primary Menu', 'shwchurch' ) );

  // Add support for a variety of post formats
  add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

  $theme_options = shwchurch_get_theme_options();
  if ( 'dark' == $theme_options['color_scheme'] )
    $default_background_color = '1d1d1d';
  else
    $default_background_color = 'f1f1f1';

  // Add support for custom backgrounds.
  add_theme_support( 'custom-background', array(
    // Let WordPress know what our default background color is.
    // This is dependent on our current color scheme.
    'default-color' => $default_background_color,
    ) );

  // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
  add_theme_support( 'post-thumbnails' );

  // Add support for custom headers.
  $custom_header_support = array(
    // The default header text color.
    'default-text-color' => '000',
    // The height and width of our custom header.
    'width' => apply_filters( 'shwchurch_header_image_width', 1000 ),
    'height' => apply_filters( 'shwchurch_header_image_height', 288 ),
    // Support flexible heights.
    'flex-height' => true,
    // Random image rotation by default.
    'random-default' => true,
    // Callback for styling the header.
    'wp-head-callback' => 'shwchurch_header_style',
    // Callback for styling the header preview in the admin.
    'admin-head-callback' => 'shwchurch_admin_header_style',
    // Callback used to display the header preview in the admin.
    'admin-preview-callback' => 'shwchurch_admin_header_image',
    );

  add_theme_support( 'custom-header', $custom_header_support );

  if ( ! function_exists( 'get_custom_header' ) ) {
    // This is all for compatibility with versions of WordPress prior to 3.4.
    define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
    define( 'HEADER_IMAGE', '' );
    define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
    define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
    add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
    add_custom_background();
  }

  // We'll be using post thumbnails for custom header images on posts and pages.
  // We want them to be the size of the header image that we just defined
  // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
  set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

  // Add 北京守望教会's custom image sizes.
  // Used for large feature (header) images.
  add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
  // Used for featured posts if a large-feature doesn't exist.
  add_image_size( 'small-feature', 500, 300 );

  // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
  register_default_headers( array(
    'wheel' => array(
      'url' => '%s/images/headers/wheel.jpg',
      'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Wheel', 'shwchurch' )
      ),
    'shore' => array(
      'url' => '%s/images/headers/shore.jpg',
      'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Shore', 'shwchurch' )
      ),
    'trolley' => array(
      'url' => '%s/images/headers/trolley.jpg',
      'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Trolley', 'shwchurch' )
      ),
    'pine-cone' => array(
      'url' => '%s/images/headers/pine-cone.jpg',
      'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Pine Cone', 'shwchurch' )
      ),
    'chessboard' => array(
      'url' => '%s/images/headers/chessboard.jpg',
      'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Chessboard', 'shwchurch' )
      ),
    'lanterns' => array(
      'url' => '%s/images/headers/lanterns.jpg',
      'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Lanterns', 'shwchurch' )
      ),
    'willow' => array(
      'url' => '%s/images/headers/willow.jpg',
      'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Willow', 'shwchurch' )
      ),
    'hanoi' => array(
      'url' => '%s/images/headers/hanoi.jpg',
      'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
      /* translators: header image description */
      'description' => __( 'Hanoi Plant', 'shwchurch' )
      )
    ) );
}
endif; // shwchurch_setup

if ( ! function_exists( 'shwchurch_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_header_style() {
  $text_color = get_header_textcolor();

  // If no custom options for text are set, let's bail.
  if ( $text_color == HEADER_TEXTCOLOR )
    return;

  // If we get this far, we have custom styles. Let's do this.
  ?>
  <style type="text/css">
  <?php
    // Has the text been hidden?
  if ( 'blank' == $text_color ) :
    ?>
  #site-title,
  #site-description {
    position: absolute !important;
    clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
    clip: rect(1px, 1px, 1px, 1px);
  }
  <?php
    // If the user has set a custom color for the text use that
  else :
    ?>
  #site-title a,
  #site-description {
    color: #<?php echo $text_color; ?> !important;
  }
  <?php endif; ?>
  </style>
  <?php
}
endif; // shwchurch_header_style

if ( ! function_exists( 'shwchurch_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in shwchurch_setup().
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_admin_header_style() {
  ?>
  <style type="text/css">
  .appearance_page_custom-header #headimg {
    border: none;
  }
  #headimg h1,
  #desc {
    font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
  }
  #headimg h1 {
    margin: 0;
  }
  #headimg h1 a {
    font-size: 32px;
    line-height: 36px;
    text-decoration: none;
  }
  #desc {
    font-size: 14px;
    line-height: 23px;
    padding: 0 0 3em;
  }
  <?php
    // If the user has set a custom color for the text use that
  if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
    ?>
  #site-title a,
  #site-description {
    color: #<?php echo get_header_textcolor(); ?>;
  }
  <?php endif; ?>
  #headimg img {
    max-width: 1000px;
    height: auto;
    width: 100%;
  }
  </style>
  <?php
}
endif; // shwchurch_admin_header_style

if ( ! function_exists( 'shwchurch_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in shwchurch_setup().
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_admin_header_image() { ?>
<div id="headimg">
  <?php
  $color = get_header_textcolor();
  $image = get_header_image();
  if ( $color && $color != 'blank' )
    $style = ' style="color:#' . $color . '"';
  else
    $style = ' style="display:none"';
  ?>
  <h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
  <div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
  <?php if ( $image ) : ?>
  <img src="<?php echo esc_url( $image ); ?>" alt="" />
<?php endif; ?>
</div>
<?php }
endif; // shwchurch_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function shwchurch_excerpt_length( $length ) {
  return 60;
}
add_filter( 'excerpt_length', 'shwchurch_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function shwchurch_continue_reading_link() {
  return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'shwchurch' ) . '</a>';
}

function shwchurch_replace_content_unblock_gfw($content)
{
	return preg_replace('/http(s?):\/\/(\w)*?\.shwchurch\.org\//i', site_url() . '/', $content);
}
add_filter('the_content','shwchurch_replace_content_unblock_gfw');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and shwchurch_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function shwchurch_auto_excerpt_more( $more ) {
  return ' &hellip;' . shwchurch_continue_reading_link();
}
add_filter( 'excerpt_more', 'shwchurch_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_content filter hook.
 */
function shwchurch_custom_excerpt_more( $output ) {
  if ( has_excerpt() && ! is_attachment() ) {
    $output .= shwchurch_continue_reading_link();
  }
  return $output;
}
add_filter( 'get_the_content', 'shwchurch_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function shwchurch_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'shwchurch_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_widgets_init() {

  register_widget( 'Twenty_Eleven_Ephemera_Widget' );


  register_sidebar( array(
    'name' => __( 'Nav Pics', 'shwchurch' ),
    'id' => 'nav_pic',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );


  register_sidebar( array(
    'name' => __( 'Main Sidebar', 'shwchurch' ),
    'id' => 'sidebar-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

  register_sidebar( array(
    'name' => __( 'Showcase Sidebar', 'shwchurch' ),
    'id' => 'sidebar-2',
    'description' => __( 'The sidebar for the optional Showcase Template', 'shwchurch' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

  register_sidebar( array(
    'name' => __( 'Footer Area One', 'shwchurch' ),
    'id' => 'sidebar-3',
    'description' => __( 'An optional widget area for your site footer', 'shwchurch' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

  register_sidebar( array(
    'name' => __( 'Footer Area Two', 'shwchurch' ),
    'id' => 'sidebar-4',
    'description' => __( 'An optional widget area for your site footer', 'shwchurch' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

  register_sidebar( array(
    'name' => __( 'Footer Area Three', 'shwchurch' ),
    'id' => 'sidebar-5',
    'description' => __( 'An optional widget area for your site footer', 'shwchurch' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'shwchurch_widgets_init' );

if ( ! function_exists( 'shwchurch_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function shwchurch_content_nav( $nav_id ) {
  global $wp_query;

  if ( $wp_query->max_num_pages > 1 ) : ?>
  <nav id="<?php echo $nav_id; ?>">
    <h3 class="assistive-text"><?php _e( 'Post navigation', 'shwchurch' ); ?></h3>
    <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'shwchurch' ) ); ?></div>
    <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'shwchurch' ) ); ?></div>
  </nav><!-- #nav-above -->
  <?php endif;
}
endif; // shwchurch_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since 北京守望教会 1.0
 * @return string|bool URL or false when no link is present.
 */
function shwchurch_url_grabber() {
  if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
    return false;

  return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function shwchurch_footer_sidebar_class() {
  $count = 0;

  if ( is_active_sidebar( 'sidebar-3' ) )
    $count++;

  if ( is_active_sidebar( 'sidebar-4' ) )
    $count++;

  if ( is_active_sidebar( 'sidebar-5' ) )
    $count++;

  $class = '';

  switch ( $count ) {
    case '1':
    $class = 'one';
    break;
    case '2':
    $class = 'two';
    break;
    case '3':
    $class = 'three';
    break;
  }

  if ( $class )
    echo 'class="' . $class . '"';
}

if ( ! function_exists( 'shwchurch_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own shwchurch_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
  case 'pingback' :
  case 'trackback' :
  ?>
  <li class="post pingback">
    <p><?php _e( 'Pingback:', 'shwchurch' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'shwchurch' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
    break;
    default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
      <article id="comment-<?php comment_ID(); ?>" class="comment">
        <footer class="comment-meta">
          <div class="comment-author vcard">
            <?php
            $avatar_size = 68;
            if ( '0' != $comment->comment_parent )
              $avatar_size = 39;

            echo get_avatar( $comment, $avatar_size );

            /* translators: 1: comment author, 2: date and time */
            printf( __( '%1$s on %2$s <span class="says">said:</span>', 'shwchurch' ),
              sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
              sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                esc_url( get_comment_link( $comment->comment_ID ) ),
                get_comment_time( 'c' ),
                /* translators: 1: date, 2: time */
                sprintf( __( '%1$s at %2$s', 'shwchurch' ), get_comment_date(), get_comment_time() )
                )
              );
              ?>

              <?php edit_comment_link( __( 'Edit', 'shwchurch' ), '<span class="edit-link">', '</span>' ); ?>
            </div><!-- .comment-author .vcard -->

            <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'shwchurch' ); ?></em>
            <br />
          <?php endif; ?>

        </footer>

        <div class="comment-content"><?php comment_text(); ?></div>

        <div class="reply">
          <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'shwchurch' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- .reply -->
      </article><!-- #comment-## -->

      <?php
      break;
      endswitch;
    }
endif; // ends check for shwchurch_comment()

if ( ! function_exists( 'shwchurch_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own shwchurch_posted_on to override in a child theme
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_posted_on() {
  printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'shwchurch' ),
    esc_url( get_permalink() ),
    esc_attr( get_the_time() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_attr( sprintf( __( 'View all posts by %s', 'shwchurch' ), get_the_author() ) ),
    get_the_author()
    );
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since 北京守望教会 1.0
 */
function shwchurch_body_classes( $classes ) {

  if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
    $classes[] = 'single-author';

  if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
    $classes[] = 'singular';

  return $classes;
}
add_filter( 'body_class', 'shwchurch_body_classes' );

function sw_cat_2column($args) {

  $defaultArgs = array(
    // show content or excerpt for first or not
    //'cat' => @int,
    'orderby' => 'date',
    'post_status' => 'published',
    'order' => 'DESC',
    // value among: default/default-first-excerpt/default-others-excerpt/list-column-1/list-column-2/list-column-3
    'displayType' => 'default',
    // if false, then paging support; if true, show all
    'nopaging'  => false,
    'posts_per_page' => 30,
    'paged' => 0
    );

  $args = array_merge($defaultArgs, $args);


  $catName = get_cat_name($args['cat']);

  $catName = !empty($catName) ? $catName : get_cat_name($args['child_of']);
  $catName = !empty($catName) ? $catName : get_cat_name($args['parent']);

  $catLink = get_category_link($args['cat']);

  $catLink = !empty($catLink) ? $catLink : get_category_link($args['child_of']) ;
  $catLink = !empty($catLink) ? $catLink : get_category_link($args['parent']) ;

  $query = new WP_query($args);

  if ( $query->have_posts() ) {
    $key = 0;
    $countPosts = $query->post_count;

    while ($query->have_posts()) {
      $query->the_post();

      if (preg_match('/default/i', $args['displayType'])) {

        $firstClass = 'first the-content ';
        $othersClass = 'others';
        if ($countPosts === 1) {
          $firstClass .= ' single-post';
          $othersClass = '';
        }
        if (preg_match('/others-list/i', $args['displayType'])) {
          $othersClass .= ' no-excerpt';
        }
        if (preg_match('/first-excerpt/i', $args['displayType'])) {
          $firstClass .= ' only-excerpt';
        }

        if ($key === 0 ) {
          ?>
          <article class="<?php echo $firstClass; ?>">
            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry">
              <p><?php
              if (preg_match('/first-excerpt/i', $args['displayType'])) {
                the_content();
              } else {
                the_content();
              } ?></p>
            </div>
          </article>
          <?php
        } else {
          if ($key === 1) {
            echo '<article class="' . $othersClass . '">';
            echo '<h2><a href="' . $catLink . '">' . $catName . '</a></h2>';
          }
          ?>
          <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <?php
          if (preg_match('/others-excerpt/i', $args['displayType'])) {
            ?>
            <div class="entry">
              <p><?php   the_content(); ?></p>
            </div>
            <?php
          }
          ?>
          <?php
          if ($key === $countPosts - 1){
            echo '<h2 class="bottom-more"><a href="' . $catLink . '">全部 ' . $catName . '</a></h2>';
            echo '</article>';
          }
          ?>

          <?php
        }

      } else if (preg_match('/list-column-(\d+)/i', $args['displayType'], $matches)) {

        $extraClass = '';
        $lastKey = $countPosts - 1;

        if ($key === 0) {
          echo '<article class="list-column first css3-column-' . $matches[1] . ' ">';
          $extraClass = 'first';
        } else if ($key === $lastKey){
          $extraClass = 'last';
        }
        ?>
        <h4 class="post-title <?php echo $extraClass;?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php
        if ($key === $lastKey){
          echo '</article>';
        }
      }
      $key++;
    }
  }
}
function sw_cat_child_2column($catArgs) {

  $defaultArgs = array(
    // show excerpt for others or not
    'swChildCat' => 'all', // all, latest
    'orderby' => 'ID',
    'post_status' => 'published',
    'order' => 'DESC',
    'postArg' => array(
      )
    );

  $catArgs = array_merge($defaultArgs, $catArgs);
  $categories = get_categories( $catArgs );

  foreach ($categories as $key => $cat) {

    echo '<div class="category cat-wrapper cat-' . $cat->cat_ID . '">';
    echo '  <h1 class="category-name"><a href="/category/' . $cat->slug . '/"">' . $cat->name . '</a></h1>';
    $args = $catArgs['postArg'];
    $args['cat'] = $cat->cat_ID;

    sw_cat_2column($args);
    echo '</div>';
    if ($catArgs['swChildCat'] === 'latest') {
      break;
    }
  }

}

function sw_show_static_postObj() {
  ?>
  <article class="post">
    <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="entry">
      <p><?php the_content();?></p>
    </div>
  </article>
  <?php
}

function sw_show_static_post($args) {
  // show a post

  $defaultArgs = array(
    // show excerpt for others or not
    'articleClass' => '',
    'post_status' => 'published',

    );

  $args = array_merge($defaultArgs, $args);

  $query = new WP_query($args);


  if ( $query->have_posts() ) {
    $key = 0;
    $countPosts = $query->post_count;
    while ($query->have_posts()) {
      $query->the_post();
      sw_show_static_postObj();

    }
  }
}

function sw_list_child_cat($catArgs) {
  // show a post

  $defaultArgs = array(
    // show excerpt for others or not
    //'parent'  => @int,
    'title_li' => '',
    'orderby' => 'ID',
    'post_status' => 'published',
    'order' => 'DESC',
    'current_category' => 1,
    'right_top_html' => ''
    );

  $catArgs = array_merge($defaultArgs, $catArgs);

  $catName = get_cat_name($catArgs['parent']);

  $catName = !empty($catName) ? $catName : get_cat_name($catArgs['child_of']);
  $catName = !empty($catName) ? $catName : get_cat_name($catArgs['cat']);

  $catLink = get_category_link($catArgs['parent']);

  $catLink = !empty($catLink) ? $catLink : get_category_link($catArgs['child_of']) ;
  $catLink = !empty($catLink) ? $catLink : get_category_link($catArgs['cat']) ;

  echo $catArgs['right_top_html'];

  wp_list_categories($catArgs);


}

function sw_show_single_cat($category) {
  echo '  <h1 class="category-name category cat-' . $category->cat_ID . '"><a href="/category/' . $category->slug . '/"">' . $category->name . '</a></h1>';
}

function sw_show_lastest_child_cat($catId) {
  $categories = get_categories(array(
    'parent' => $catId,
    'orderby' => 'ID',
    'post_status' => 'published',
    'order' => 'DESC'
    ));
  $latestCat = $categories[0];

  sw_show_single_cat($latestCat);
  sw_post(array(
    'cat' => $latestCat->cat_ID
    ));

}

function sw_show_ejournal_child_categories($category) {
  sw_show_single_cat($category);

  sw_post(array(
    'cat' => $category->cat_ID
    ));
}

function sw_show_ejournal_category($catId) {
  $cat;
  if ($catId == '82') {
    $categories = get_categories(array(
      'parent' => $catId,
      'orderby' => 'ID',
      'post_status' => 'published',
      'order' => 'DESC'
      ));
    $cat = $categories[0];
  } else {
    $cat = get_category($catId);
  }
  sw_show_ejournal_child_categories($cat);

}

function sw_show_xinghua_category($catId) {

  sw_show_latestpost_xinghua($catId);

}

function sw_show_latestpost_of_cat($catId) {

  $defaultArgs = array(
  // show content or excerpt for first or not
  //'cat' => @int,
    'orderby' => 'date',
    'post_status' => 'published',
    'order' => 'DESC',
  // value among: default/default-first-excerpt/default-others-excerpt/list-column-1/list-column-2/list-column-3
    'displayType' => 'default',
  // if false, then paging support; if true, show all
    'nopaging'  => false,
    'posts_per_page' => 30,
    'paged' => 0,
    'cat' => $catId
    );

  $query = new WP_query($defaultArgs);

  $key = 0;
  while ($query->have_posts() && $k < 1) {
    $k++;
    $query->the_post();
    sw_show_static_postObj();

  }
}

function sw_show_latestpost_xinghua($catId) {

  $defaultArgs = array(
  // show content or excerpt for first or not
  //'cat' => @int,
    'orderby' => 'date',
    'post_status' => 'published',
    'order' => 'DESC',
  // value among: default/default-first-excerpt/default-others-excerpt/list-column-1/list-column-2/list-column-3
    'displayType' => 'default',
  // if false, then paging support; if true, show all
    'nopaging'  => false,
    'posts_per_page' => 30,
    'paged' => 0,
    'cat' => $catId
    );

  $query = new WP_query($defaultArgs);

  $key = 0;
  while ($query->have_posts() && $k < 1) {
    $k++;
    $query->the_post();
    sw_show_static_postObj();

  }
}


function sw_post($args) {

  $defaultArgs = array(
    'showTitle' => true
    );

  $args = array_merge($defaultArgs, $args);

  $query = new WP_query($args);

  $countPosts = $query->post_count;

  if ( $query->have_posts() ) {
    while(  $query->have_posts()) {
      $query->the_post();
      ?>
      <article>
        <?php
        if ($args['showTitle']) {
          ?>
          <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <?php
        }
        ?>
        <div class="entry">
          <p><?php  the_content(); ?></p>
        </div>
      </article>

      <?php
    }
  }

}

function sw_image_news($args = array()) {
  // show news with image for home page
  $defaultArgs = array(
    'cat' => 3,
    'orderby' => 'date',
    'post_status' => 'published',
    'order' => 'DESC',
    'posts_per_page' => 30,
    'news_count' => 4,
    'paged' => 1 // show the latest 4
    );

  $args = array_merge($defaultArgs, $args);

  $query = new WP_query($args);

  $newsCount = $args['news_count'];

  if ( $query->have_posts() ) {
    while(  $query->have_posts() && $newsCount) {
      $query->the_post();


      if (has_post_thumbnail()) {
        $newsCount--;
        $theId = get_the_ID();
        $src = get_the_post_thumbnail($theId, array(400,300));
        echo '<div class="image-news">';
        echo '<a href="' . get_permalink() . '">' . $src . '</a>';
        echo '<div class="title">';
        the_title();
        echo '</div>';
        echo '<div class="excerpt  text-indent">';
        $content = get_the_content();
        $postOutput = preg_replace('/<img[^>]+./','', $content);
        echo $postOutput;
        echo '</div>';
        echo '</div>';
      }

      ?>


      <?php
    }
  }


}


/**
 * force to use category template
*/

function child_force_category_template($template) {

  $cat = get_query_var('cat');

    // assing special template for child categories
  if ( cat_is_ancestor_of( 82, $cat ) ) {
    $cat_template = TEMPLATEPATH . '/category-82.php';
  }
  else if ( cat_is_ancestor_of( 30, $cat ) ) {
    $cat_template = TEMPLATEPATH . '/category-30.php';
  }
  else{
    $cat_template = $template;
  }

  return $cat_template;
}

function get_the_morehandled_content_json () {
  $content = get_the_morehandled_content();
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

add_action('category_template', 'child_force_category_template');

// if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// remove_action('template_redirect', 'redirect_canonical');
// }

// seperate more before and more after
function the_morehandled_content() {
  $postContent = get_the_content();
  if(preg_match('/<span id="more-/', $postContent )) :
    global $more; $more = 0;       // Set (inside the loop) to display content above the more tag.
    ?>
    <div class="more-before add-radius-10">
    <?php
    the_content('');
    ?>
    </div>
    <div class="more-after">
      <?php $more = 1;
    the_content('', true ); // Set to hide content above the more tag.
    ?>
    </div>
  <?php

  else : the_content();
  endif;
}

function get_the_morehandled_content() {
  $postContent = get_the_content('');
  $newContent = '';
  if(is_single() && preg_match('/<span id="more-/', $postContent )) :
    global $more; $more = 0;       // Set (inside the loop) to display content above the more tag.
    $newContent = '<div class="more-before add-radius-10">';
    $newContent .= get_the_content('');
    $newContent .= '</div>';
    $newContent .= '<div class="more-after">';
    $more = 1;
    $newContent .= get_the_content('', true ); // Set to hide content above the more tag.
    $newContent .= '</div>';
  else : $newContent = $postContent;
  endif;
  $newContent = apply_filters('the_content', $newContent);
  return $newContent;

}

function wpse_allowedtags() {
    // Add custom tags to this string
        return '<br>,<em>,<i>,<a>,<p>,<img>,<video>,<audio>,<div>,<span>';
}

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) :

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
    $raw_excerpt = $wpse_excerpt;
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            $wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 400;
                #$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
                $excerpt_length = $excerpt_word_count;
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>])/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) {

                    if ($count >= $excerpt_length && preg_match('/[\;\?\.\!\。\？\；]$/uS', $token)) {
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));

                $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;&raquo;&nbsp;' . sprintf(__( 'Read more about: %s &nbsp;&raquo;', 'wpse' ), get_the_title()) . '</a>';
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

                //$pos = strrpos($wpse_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                $wpse_excerpt .= $excerpt_more; /*Add read more in new paragraph */
           return $wpse_excerpt;

        }
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif;

// change jQuery to fix wechat first load issue
// in wechat / webkit, on first load, Dom ready doesn't fire
function modify_jquery_version() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri() . '/js/lib/jquery-3.2.0.min.js');
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'modify_jquery_version');

