<?php
/***********************************************
 * WordPress Tweet Panel
 *
 * Search and embed tweets from the post edit screen.
 **********************************************/
class WP_Tweet_Panel {
	/**
	 * Initialize this module
	 */
	static function init() {
		global $pagenow;
		if( is_admin() && $pagenow == 'post.php' ) {
			wp_enqueue_script( 'wp-tweet-panel', plugins_url( 'wp-tweet-panel.js', 'wp-tweet-panel' ), array(), 1, true );
		}
		add_action( 'add_meta_boxes', array( get_called_class(), 'add_meta_boxes' ) );
	}

	static function add_meta_boxes() {
		add_meta_box( 'wp-tweet-panel', "Tweet Panel", array( get_called_class(), 'meta_box' ), null, 'side', 'core' );
	}	

	static function meta_box() { 
		$search = apply_filters( 'wp_tweet_panel_search_default', '' );

?>
		<input type="text" id="wp-tweet-panel-search" value="<?php echo esc_attr( $search ); ?>" placeholder="Search term..." />

		<div id="wp-tweet-panel-results">
		<?php if ( $search ) { ?>
		<script>wpTwitterPanel && wpTwitterPanel(<?php echo json_encode( $search ); ?>)</script>
		<?php } ?>
			<ul id="wp-tweet-panel-tweets"></ul>
		</div>
	<?php
	}
}
add_action( 'init', array( 'WP_Tweet_Panel', 'init' ) );
