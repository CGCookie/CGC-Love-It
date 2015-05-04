<?php

/**
*	Love something
*
*	@param $user_id int id of the current user doing the loving
*	@param $post_id int id of the post the user is loving
*	@since 5.0
*/
function cgc_love_something( $user_id = 0, $post_id = 0 ) {

	// if user is empty grab the current
	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	// if teh post id is empty grab the current
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	// bail out if this user has already loved this item
	if ( false !== cgc_has_user_loved( $user_id, $post_id ) )
		return;

	// add the love
	$db = new CGC_LOVEIT_DB;
	$out =  $db->add_love( array( 'user_id' => $user_id, 'post_id' => $post_id ) );
}

/**
*	Get the number of loves for a post id
*	@param $post_id int id of the post that we're getting the loves for
*	@since 5.0
*/
function cgc_get_loves( $post_id = 0 ) {

	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	$db = new CGC_LOVEIT_DB;
	$out = $db->get_loves( $post_id );

	return count($out);

}

/**
*	Check if a user has loved something
*	@param $user_id int id of the user that we're checking for
*	@param $post_id int id of the post that we're checking
*	@since 5.0
*/
function cgc_has_user_loved( $user_id = 0, $post_id = 0 ) {

	// if user is empty grab the current
	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	// if teh post id is empty grab the current
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	// return result
	$db = new CGC_LOVEIT_DB;
	$out = $db->has_loved( $user_id , $post_id );

	return $out;
}