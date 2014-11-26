<?php
/* 	
	Plugin Name: Duplicate Title Checker
	Plugin URI: http://wordpress.org/extend/plugins/duplicate-title-checker/
	Description: This plugin provides alert message for duplicate post title and unique post title when adding new post.
	Author: Ketan Ajani
	Version: 1.0
	Author URI: http://www.webconfines.com
*/
	
//////////////////////////this is duplicate title check///////////////////////////////////

	//jQuery to send AJAX request - only available on the post editing page
	function duplicate_titles_enqueue_scripts( $hook ) {

		if( !in_array( $hook, array( 'post.php', 'post-new.php' ) ) )
			return;

		wp_enqueue_script( 'duptitles',wp_enqueue_script( 'duptitles',plugins_url().'/duplicate-title-checker/js/duptitles.js',array( 'jquery' )), array( 'jquery' )  );
	}
	add_action( 'admin_enqueue_scripts', 'duplicate_titles_enqueue_scripts', 2000 );

	add_action('wp_ajax_title_check', 'duplicate_title_check_callback');

	function duplicate_title_check_callback() {

		function title_check() {

			$title = $_POST['post_title'];
			$post_id = $_POST['post_id'];

			global $wpdb;

			$sim_titles = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' 
						AND post_title = '{$title}' AND ID != {$post_id} ";

			$sim_results = $wpdb->get_results($sim_titles);

			if($sim_results) {
				$titles = '<ul>';
				foreach ( $sim_results as $the_title ) 
				{
					$titles .= '<li>'.$the_title->post_title.'</li>';
				}
				$titles .= '</ul>';

				//return $titles;
				return "<div style='color:red'>Please enter another title it's already exists</div>";
			} else {
				return '<div style="color:green">This title is unique</div>';
			}
		}		
		echo title_check();
		die();
	}

	function disable_autosave() {
		wp_deregister_script('autosave');
	}
	add_action( 'wp_print_scripts', 'disable_autosave' );


?>
