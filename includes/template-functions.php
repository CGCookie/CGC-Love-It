<?php

/**
*	Draw follow/unfollow buttons
*	@since 5.0
*/
function cgc_draw_follow_buttons( $user_to_check, $current_user ){

	if( empty( $user_to_check ) || $current_user == get_current_user_ID() || !is_user_logged_in() )
		return;

	?><div class="cgc-loveit--wrap"><?php

	if ( cgc_user_is_following( $user_to_check, $current_user ) ) { ?>
		<a href="#" class="cgc-loveit cgc-loveit--unfollow button primary tiny">unfollow</a>
		<a href="#" class="cgc-loveit cgc-loveit--follow button primary tiny" style="display:none;">follow</a>
	<?php } else { ?>
		<a href="#" class="cgc-loveit cgc-loveit--follow button primary tiny">follow</a>
		<a href="#" class="cgc-loveit cgc-loveit--unfollow button primary tiny" style="display:none;">unfollow</a>
	<?php } ?>

	</div><?php
}