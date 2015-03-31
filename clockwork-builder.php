<?php



/**
 * Adds Clockwork Scripts
 */ 
function calibrefx_clockwork_scripts(){
		// wp_enqueue_style( 'jquery.mobile', CALIBREFX_MODULE_URL . '/minicfx/theme/assets/css/jquery-mobile.min.css' );
		wp_enqueue_script( 'calibrefx.clockwork', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork.js', array( 'jquery' ), false, true  );
		wp_enqueue_script( 'calibrefx.clockwork.nodes', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork-nodes.js', array( 'jquery' ), false, true  );
		wp_enqueue_script( 'calibrefx.clockwork.functions', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork-functions.js', array( 'jquery' ), false, true  );
		wp_enqueue_script( 'calibrefx.clockwork.init', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork-init.js', array( 'jquery' ), false, true  );
}

add_action( 'wp_enqueue_scripts', 'calibrefx_clockwork_scripts' );

add_action( 'admin_init', 'calibrefx_clockwork_scripts' );


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function clockwork_add_meta_box() {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'clockwork_interface',
			__( 'Clockwork Interface', 'clockwork' ),
			'clockwork_interface_metabox',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'clockwork_add_meta_box' );


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function clockwork_interface_metabox( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'clockwork_interface', 'clockwork_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'clockwork_interface_state', true );

	$clockwork_metas = get_post_meta( $post->ID, 'clockwork_metas', true );

	$temp = '';

	echo 	'	<label for="clockwork_interface_state">';
					_e( 'Clockwork Interface State : ', 'calibrefx' );
	echo 	'	</label> ';

	echo 	'	<select name="clockwork_interface_state" id="clockwork_interface_state" value="'.esc_attr( $value ).'">
					<option '. ( esc_attr( $value ) == 1 ? 'selected': '' ) .' value="1">Active</option>
					<option '. ( esc_attr( $value ) == 0 ? 'selected': '' ) .' value="0">Inactive</option>
				</select>';

	if( $value == 1 ){

		$temp .= 	'	<br>';

		$temp .= 	'	Hook Control';

		$temp .= 	'	<br>';

		$temp .= 	'	<label for="clockwork_interface_state">add_action => </label> ';

		// $temp .= 	'	<input type="text" name="calibrefx_settings_clockwork_test" value="'. $value2 .'"  />';
		$temp .= 	'	<input type="text" name="clockwork_metas[loop_hook]" value="'. ( $clockwork_metas['loop_hook'] ? $clockwork_metas['loop_hook'] : '' ) .'"  />';
		$temp .= 	'	<input type="text" name="clockwork_metas[loop_template]" value="'. ( $clockwork_metas['loop_template'] ? $clockwork_metas['loop_template'] : '' ) .'"  />';
		$temp .= 	'	<input type="text" name="clockwork_metas[loop_priority]" value="'. ( $clockwork_metas['loop_priority'] ? $clockwork_metas['loop_priority'] : '' ) .'"  />';
		$temp .= 	'	<br>';
		$temp .= 	'	remove_action => <input type="checkbox" name="clockwork_metas[loop_remove]" value="remove" '. ( $clockwork_metas['loop_remove'] ? 'checked' : '' ) .' />';
		$temp .= 	'	<input type="text" name="clockwork_metas[loop_remove_hook]" value="'. ( $clockwork_metas['loop_remove_hook'] ? $clockwork_metas['loop_remove_hook'] : '' ) .'" />';
	}

	echo  	'	<div class="row">
					<div class="col-md-12">
						<div id="clockwork_customize_wrapper" class="clockwork-settings-slug-'. $post->post_title .' clockwork-settings-id-'. $post->post_title .'">
							'. $temp .'
						</div>
					</div>
				</div>';
}


/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function clockwork_save_meta_box_data( $post_id ) {
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	$crk = $_POST['clockwork_metas'];

	update_post_meta( $post_id, 'clockwork_metas', $crk );

	// Check if our nonce is set.
	if ( ! isset( $_POST['clockwork_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['clockwork_meta_box_nonce'], 'clockwork_interface' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( isset( $_POST['clockwork_interface_state'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['clockwork_interface_state'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'clockwork_interface_state', $my_data );
	}

	if ( isset( $_POST['calibrefx_settings_clockwork_test'] ) ) {
		// Sanitize user input.
		$my_data2 = sanitize_text_field( $_POST['calibrefx_settings_clockwork_test'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'calibrefx_settings_clockwork_test', $my_data2 );
	}
}
add_action( 'save_post', 'clockwork_save_meta_box_data' );


/**
 * If Clockwork Interface is enabled and there template, then display Clockwork Template
 */
function calibrefx_init_clockwork_interface() {

	global $calibrefx;

	add_filter( 'body_class', 'clockwork_body_class' );

	remove_action('calibrefx_loop', 'calibrefx_do_loop');

	add_action('calibrefx_loop', 'clockwork_do_loop');

	// remove_action( 'calibrefx_after_header', 'calibrefx_do_nav' );
	// remove_action( 'calibrefx_after_header', 'calibrefx_do_subnav', 15 );

	// add_action( 'calibrefx_before_header', 'calibrefx_do_top_mobile_nav' );
	// add_action( 'calibrefx_before_wrapper', 'calibrefx_mobile_open_nav' );
	// add_action( 'calibrefx_after_wrapper', 'calibrefx_mobile_close_nav' );

	// add_filter( 'template_include', 'calibrefx_get_mobile_template' );
}
add_action( 'calibrefx_post_init', 'calibrefx_init_clockwork_interface', 15 );

function clockwork_body_class( $body_classes ) {

	global $post;

	$body_classes[] = 'clockwork-interface';

	return $body_classes;
}

// function clockwork_do_loop(){

// 	global $wp_query;

//  	$post_id = $wp_query->get_queried_object_id();

//  	$clockwork_state = get_post_meta( $post_id, 'clockwork_interface_state', true );

//  	if( $clockwork_state > 0 ){

//  		get_template_part( 'clockwork/content', 'page' );
//  	} else {

// 		calibrefx_do_loop();
//  	}
// }


function clockwork_do_loop(){

	global $wp_query;

 	$post_id = $wp_query->get_queried_object_id();

 	$clockwork_state = get_post_meta( $post_id, 'clockwork_interface_state', true );

 	$clockwork_metas = get_post_meta( $post_id, 'clockwork_metas', true );

 	if( $clockwork_state > 0 ){

 		if( $clockwork_metas['loop_remove'] == 'remove' ){

 			remove_action( ''. $clockwork_metas['loop_hook'] .'', ''. $clockwork_metas['loop_remove_hook'] .'' );
 		}

 		add_action( ''. $clockwork_metas['loop_hook'] .'', 'calibrefx_clockwork_func', $clockwork_metas['loop_priority'] );

 		function calibrefx_clockwork_func( $clockwork_metas ){

 			global $wp_query;

		 	$post_id = $wp_query->get_queried_object_id();

		 	$clockwork_metas = get_post_meta( $post_id, 'clockwork_metas', true );

 			get_template_part( 'clockwork/content', $clockwork_metas['loop_template'] );
 		}
 	}

	calibrefx_do_loop();
}