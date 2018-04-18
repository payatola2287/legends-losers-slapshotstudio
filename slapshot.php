<?php
  /*
    Plugin Name: Slapshot Studio Custom Codes
    Description: Here are custom codes for Legends and Losers website. Since we cannot put custom codes into the functions.php of the PARENT THEME which is the BeTheme, we decided to put these codes to the plugin instead. Any problem with the codes, you can contact us as <a href="//slapshotstudio.com">
    Author: Slapshot Studio
    Author URI: //slapshotstudio.com
    Version: 1.0
  */
require 'plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/payatola2287/legends-losers-slapshotstudio',
	__FILE__, //Full path to the main plugin file or functions.php.
	'legends-losers-slapshotstudio'
);
function display_latest_podcast_episode( $atts ){
  $s_atts = shortcode_atts( array(
    'post_type' => 'post',
    'image' => false,
    'content' => true,
    'player' => true
  ),$atts );
  $q_args = array(
    'post_type' => $s_atts['post_type'],
    'posts_per_page' => 1,
  );
  $episode_query = new WP_Query( $q_args );
  if( $episode_query->have_posts() ){
    while( $episode_query->have_posts() ){
      $episode_query->the_post();
      ?>
        <?php if( $s_atts['image'] == true ): ?>
          <figure class="post-item-thumbnail">
            <?php the_post_thumbnail(); ?>
          </figure>
        <?php endif; ?>
        <div class="post-item-wrapper">
          <?php if( $s_atts['content'] == true ): ?>
            <h1 class="recenttitle"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h1>
            <date ="recentdate"><?php echo get_the_date(); ?></date>
          <?php endif; ?>
          <?php if( function_exists( 'get_field' ) ): ?>
            <?php if( $s_atts['player'] == true ): ?>
              <div class="recentplayer">
                <?php
                  echo do_shortcode( get_field( 'player',get_the_ID(),false ) );
                ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      <?php
    }
  }
  wp_reset_postdata();
}
add_shortcode( 'sss-grid','display_latest_podcast_episode' );
