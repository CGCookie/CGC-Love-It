<?php

/**
*	Love something
*
*	@param $current_user int id of the current user doing the loving
*	@param $post_id int id of the post the user is loving
*	@since 5.0
*/
function cgc_love_something( $current_user = 0, $post_id = 0 ) {

	if ( empty( $post_id ) )
		return;

	if ( empty( $current_user ) )
		$current_user = get_current_user_ID();

	$db = new CGC_LOVEIT_DB;

	$args = array(
		'user_id' 	=> $current_user,
		'post_id'	=> $post_id
	);

	$db->add_love( $args );
}