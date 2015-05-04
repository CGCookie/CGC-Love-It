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
	*	Add a single follower
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
					`post-id`  		= '%d'
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


}