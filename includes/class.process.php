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

			global $post;

	    	$user_id 	= get_current_user_id();

	    	$post_id 	= isset( $_POST['post_id'] ) ? $_POST['post_id'] : false;
	    	$location 	= isset( $_POST['location'] ) ? sanitize_text_field( $_POST['location'] ) : false;

	    	if( 'live-session' == $location ) {

	    		$author = function_exists('cgc_get_single_discussion') && isset( $post_id ) ? cgc_get_single_discussion( $post_id )->author_id : false;

	    	} else {

	    		$author     = $post_id ? get_post( $post_id )->post_author : false;
	    	}

	    	if ( empty ( $post_id ) )
	    		return;

			if ( $_POST['action'] == 'process_love' && wp_verify_nonce( $_POST['nonce'], 'process_love' )  ) {

				// bail out if this user has already loved this item
				if ( cgc_has_user_loved( $user_id, $post_id ) ) {

					wp_send_json_success( array('message' => 'already-loved') );

				} else if ( $user_id == $author ) {

					wp_send_json_success( array('message' => 'self-lovin') );

				} else {

					cgc_love_something( $user_id, $post_id );

					do_action('cgc_user_loved', $user_id, $post_id );

					wp_send_json_success( array( 'message'=> 'loved' ) );
				}

			} elseif ( $_POST['action'] == 'process_unlove' && wp_verify_nonce( $_POST['nonce'], 'process_love' ) ) {

	    		cgc_unlove_something( $user_id, $post_id );

		       	wp_send_json_success( array( 'message'=> 'un-loved' ) );

			} else {

				wp_send_json_error();

			}

		} else {

			wp_send_json_error();

		}

	}

}
new cgcProcessLoving;