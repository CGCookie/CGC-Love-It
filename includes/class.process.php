<?php

/**
*	Class responsible for processing the ajax call to love or unlove a post id
*	@since 5.0
*/
class cgcProcessLoving {

	public function __construct(){

		add_action('wp_ajax_process_love',		array($this,'process_lovin'));
		add_action('wp_ajax_process_unlove',		array($this,'process_lovin'));

	}

	public function process_lovin(){

		if ( isset( $_POST['action'] ) ) {

	    	$user_id 	= get_current_user_id();

	    	$post_id 	= isset( $_POST['post_id'] ) ? $_POST['post_id'] : false;

	    	if ( empty ( $post_id ) )
	    		return;

			if ( $_POST['action'] == 'process_love' && wp_verify_nonce( $_POST['nonce'], 'process_love' )  ) {


	    		// do lovin
	    		cgc_love_something( $user_id, $post_id );


	    		//var_dump('madeit');wp_die();

		        wp_send_json_success();

			} elseif ( $_POST['action'] == 'process_unlove' && wp_verify_nonce( $_POST['nonce'], 'process_love' ) ) {

	    		// do unlovin

		        wp_send_json_success();

			} else {

				wp_send_json_error();

			}

		} else {

			wp_send_json_error();

		}

	}

}
new cgcProcessLoving;