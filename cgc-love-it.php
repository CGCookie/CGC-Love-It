<?php
/**
 * Plugin Name: CGC Love It
 * Description: Love functionality from the cgcookie theme
 *
 */

// check whether a user has loved a post / iamge
function cgc_user_has_loved_post($user_id, $post_id) {
	$loved = cgc_get_users_loved_posts($user_id);
	if(is_array($loved) && in_array($post_id, $loved)) {
		return true; // user has loved post
	}
	return false; // user has not loved post
}

// get post IDs a user has loved
function cgc_get_users_loved_posts($user_id) {
	return get_user_option('cgc_user_loves', $user_id);
}


// increments a love count
function cgc_mark_post_as_loved($post_id, $user_id) {

	$love_count = get_post_meta($post_id, '_cgc_love_count', true);
	if($love_count)
		$love_count = $love_count + 1;
	else
		$love_count = 1;

	if(update_post_meta($post_id, '_cgc_love_count', $love_count)) {
		if(is_user_logged_in()) {
			cgc_store_loved_id_for_user($user_id, $post_id);
			do_action( 'cgc_post_loved', $user_id, $post_id );
		}
		return true;
	}
	return false;
}

// adds the loved ID to the users meta so they can't love it again
function cgc_store_loved_id_for_user($user_id, $post_id) {
	$loved = cgc_get_users_loved_posts($user_id);
	if(is_array($loved)) {
		$loved[] = $post_id;
	} else {
		$loved = array($post_id);
	}
	update_user_option($user_id, 'cgc_user_loves', $loved);
}

// returns a love count for a post
function cgc_get_love_count($post_id) {
	$love_count = get_post_meta($post_id, '_cgc_love_count', true);
	if($love_count)
		return $love_count;
	return 0;
}

// processes the ajax request
function cgc_process_love() {
	if ( isset( $_POST['image_id'] ) && wp_verify_nonce($_POST['cgc_nonce'], 'cgc-nonce') ) {
		if(cgc_mark_post_as_loved($_POST['image_id'], $_POST['user_id'])) {
			echo 'loved';
		} else {
			echo 'failed';
		}
	}
	die();
}
add_action('wp_ajax_love_image', 'cgc_process_love');
add_action('wp_ajax_nopriv_love_image', 'cgc_process_love');