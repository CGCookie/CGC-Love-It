<?php

/**
*	UnLove something
*
*	@param $user_id int id of the current user doing the loving
*	@param $post_id int id of the post the user is loving
*	@since 5.0
*/
function cgc_unlove_something( $user_id = 0, $post_id = 0 ) {

	// if user is empty grab the current
	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	// if teh post id is empty grab the current
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	// add the love
	$db = new CGC_LOVEIT_DB;
	$out =  $db->remove_love( array( 'user_id' => $user_id, 'post_id' => $post_id ) );
}

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

	return $out ? $out : 0;

}

/**
*	Get the items a specific user has loved
*	@param $user_id int id of the user that we're getting items for
*	@since 5.0
*/
function cgc_get_users_loves( $user_id = 0, $count = false ) {

	if ( empty( $user_id ) )
		return;

	$db = new CGC_LOVEIT_DB;
	$out = $db->get_user_loves( $user_id );

	return true == $count ? count( $out ) : $out;

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

/**
*	Get the total number of loves a user has recieved on tehir images
*
*/
function cgc_get_users_total_loves( $user_id = 0 ){

	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	$images = function_exists('cgc_gallery_get_users_images') ? cgc_gallery_get_users_images( $user_id ) : false;

	$loves = '';
	if ( $images ) {

		foreach ($images as $image) {

			// find loves for iamges
			$loves += cgc_get_loves( $image );

		}
	}

	return $loves ? $loves : '0';
}