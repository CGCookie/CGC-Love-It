<?php

class CGC_LOVEIT_DB {


	private $table;
	private $db_version;

	function __construct() {

		global $wpdb;

		$this->table   		= $wpdb->base_prefix . 'cgc_loveit';
		$this->db_version = '1.0';

	}

	/**
	*	Add a love
	*
	*	@since 5.0
	*/
	public function add_love( $args = array() ) {

		global $wpdb;

		$defaults = array(
			'user_id'		=> '',
			'post_id'		=> ''
		);

		$args = wp_parse_args( $args, $defaults );

		$add = $wpdb->query(
			$wpdb->prepare(
				"INSERT INTO {$this->table} SET
					`user_id`  		= '%d',
					`post_id`  		= '%d'
				;",
				absint( $args['user_id'] ),
				absint( $args['post_id'] )
			)
		);

		do_action( 'cgc_love_added', $args, $wpdb->insert_id );

		if ( $add )
			return $wpdb->insert_id;

		return false;
	}

	/**
	*	Remove a love
	*
	*	@since 5.0
	*/
	public function remove_love( $args = array() ) {

	}

	/**
	*	Get the number of loves for a specific post id
	*
	*	@since 5.0
	*/
	public function get_loves( $post_id = 0 ) {

		global $wpdb;

		$result = $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM {$this->table} WHERE `post_id` = '%d'; ", absint( $post_id ) ) );

		return $result;
	}

	/**
	*	Has this user loved a specific post id
	*
	*	@param $user_id int id of the user we're checking for
	*	@param $post_id int id of the post we're cecking to see if the user loved
	*/
	public function has_loved( $user_id = 0, $post_id = 0 ) {

		global $wpdb;

		$result = $wpdb->get_results( $wpdb->prepare( "SELECT user_id FROM {$this->table} WHERE `post_id` = '%d' AND `user_id` = '%d'; ", absint( $post_id ), absint( $user_id ) ) );

		if ( $result )
			return $result;
		else
			return false;
	}

}