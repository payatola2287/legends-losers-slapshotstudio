<?php
  /*
    Plugin Name: Slapshot Studio Custom Codes
    Description: Here are custom codes for Legends and Losers website. Since we cannot put custom codes into the functions.php of the PARENT THEME which is the BeTheme, we decided to put these codes to the plugin instead.
    Author: Slapshot Studio
    Author URI: //slapshotstudio.com
    Version: 1.0
  */
	require 'updater/plugin-update-checker.php';
	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://github.com/payatola2287/legends-losers-slapshotstudio/',
		__FILE__,
		'legends-losers-slapshotstudio'
	);
function display_latest_podcast_episode( $atts ){
  $s_atts = shortcode_atts( array(
    'post_type' => 'post',
  ),$atts );
  $q_args = array(
    'post_type' => $s_atts['post_type'],
    'posts_per_page' => 1,
  );
  $episode_query = new WP_Query( $q_args );
	ob_start();
  if( $episode_query->have_posts() ){
    while( $episode_query->have_posts() ){
      $episode_query->the_post();
      ?>
        <div class="post-item-wrapper">
            <h1 class="recenttitle"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h1>
            <date ="recentdate"><?php echo get_the_date(); ?></date>
          <?php if( function_exists( 'get_field' ) ): ?>
              <div class="recentplayer">
                <?php
                  echo do_shortcode( get_field( 'player',get_the_ID(),false ) );
                ?>
              </div>
          <?php endif; ?>
        </div>
      <?php
    }
  }
  wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'sss-grid','display_latest_podcast_episode' );

function display_latest_podcast_episode_image( $atts ){
  $s_atts = shortcode_atts( array(
    'post_type' => 'post',
  ),$atts );
  $q_args = array(
    'post_type' => $s_atts['post_type'],
    'posts_per_page' => 1,
  );
  $episode_query = new WP_Query( $q_args );
	ob_start();
  if( $episode_query->have_posts() ){
    while( $episode_query->have_posts() ){
      $episode_query->the_post();
      ?>
        <figure class="thumbnail-item-wrapper">
          <?php the_post_thumbnail( 'full' ); ?>
        </figure>
      <?php
    }
  }
  wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'sss-single-image','display_latest_podcast_episode_image' );
