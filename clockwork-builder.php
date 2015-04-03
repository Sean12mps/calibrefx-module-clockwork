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


function calibrefx_clockwork_admin_scripts(){
		// wp_enqueue_style( 'jquery.mobile', CALIBREFX_MODULE_URL . '/minicfx/theme/assets/css/jquery-mobile.min.css' );
		wp_register_script( 'calibrefx.clockwork', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork.js', array( 'jquery' ), false, true  );
		wp_register_script( 'calibrefx.clockwork.nodes', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork-nodes.js', array( 'jquery' ), false, true  );
		wp_register_script( 'calibrefx.clockwork.functions', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork-functions.js', array( 'jquery' ), false, true  );
		wp_register_script( 'calibrefx.clockwork.init', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/js/clockwork-init.js', array( 'jquery' ), false, true  );

		wp_enqueue_script( 'calibrefx.clockwork' );
		wp_enqueue_script( 'calibrefx.clockwork.nodes' );
		wp_enqueue_script( 'calibrefx.clockwork.functions' );
		wp_enqueue_script( 'calibrefx.clockwork.init' );
}

add_action( 'admin_init', 'calibrefx_clockwork_admin_scripts' );


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



	$clockwork_hooks = get_post_meta( $post->ID, 'clockwork_hooks', true );



	if( is_array( $clockwork_hooks ) ){

		$clockwork_hooks_count = count( $clockwork_hooks );
	} else {

		$clockwork_hooks = 0;
	}

	var_dump( $clockwork_hooks );
	// exit;
	// ( get_post_meta( $post->ID, 'clockwork_hooks', true ) ? count( get_post_meta( $post->ID, 'clockwork_hooks', true ) ) : 0 );

	$clockwork_metas = get_post_meta( $post->ID, 'clockwork_meta', true );

	$temp = '';

	echo 	'	<label for="clockwork_interface_state">';
					_e( 'Clockwork Interface State : ', 'calibrefx' );
	echo 	'	</label> ';

	echo 	'	<select name="clockwork_interface_state" id="clockwork_interface_state" value="'.esc_attr( $value ).'">
					<option '. ( esc_attr( $value ) == 1 ? 'selected': '' ) .' value="1">Active</option>
					<option '. ( esc_attr( $value ) == 0 ? 'selected': '' ) .' value="0">Inactive</option>
				</select>';



	$form_set = '	<br>

					<div class="form-wrapper">
						
						<p>	<select class="loop_action" name="clockwork_meta[loop_action_%]">
								<option value="add">Add Action</option>
								<option value="remove">Remove Action</option>
							</select>
							<button class="delete_clockwork_hook" index="%">Delete Hook</button>
						</p>

						<label>loop_hook</label>
						<input type="text" class="loop_hook" name="clockwork_meta[loop_hook_%]" 		value="">

						<label>loop_template</label>
						<input type="text" class="loop_template" name="clockwork_meta[loop_template_%]" 	value="">

						<label>loop_priority</label>
						<input type="text" class="loop_priority" name="clockwork_meta[loop_priority_%]" 	value="">
					</div>';

	$clockwork_builder['form_set'] = $form_set;
	$clockwork_builder['hooks_data'] = $clockwork_hooks;

	wp_localize_script( 'calibrefx.clockwork.functions', 'clockwork_builder', $clockwork_builder );
	// REFRESH
	// update_post_meta( 'clockwork_meta', '', true );

	echo '	<p>	<div class="clockwork_count">
					<input type="hidden" id="clockwork_hooks" name="clockwork_hooks" value="'. $clockwork_hooks_count .'">
					<button class="add_clockwork_hook" target="#clockwork_hooks">Add Hook</button>
				</div>
			</p>
			';

	echo '	<div id="clockwork_hooks_form">';

	// for( $i = 0; $i < $clockwork_hooks_count; $i++ ){

	// 	// $crk_meta_hook = ( get_post_meta( $post->ID, 'loop_hook_'. $i .'', true ) ? get_post_meta( $post->ID, 'loop_hook_'. $i .'', true ) : '' );
	// 	// $crk_meta_temp = ( get_post_meta( $post->ID, 'loop_template_'. $i .'', true ) ? get_post_meta( $post->ID, 'loop_template_'. $i .'', true ) : '' );
	// 	// $crk_meta_prio = ( get_post_meta( $post->ID, 'loop_priority_'. $i .'', true ) ? get_post_meta( $post->ID, 'loop_priority_'. $i .'', true ) : '' );

	// 	$crk_meta_hook = $clockwork_hooks[0]['loop_hook'];
	// 	$crk_meta_temp = $clockwork_hooks[$i];
	// 	$crk_meta_prio = $clockwork_hooks[$i];

	// 	echo '	<br>
	// 			<div class="form-wrapper">
	// 				<input type="text" 	name="clockwork_meta[loop_hook_'. $i .']" 		value="'. $crk_meta_hook .'">;
	// 				<input type="text" 	name="clockwork_meta[loop_template_'. $i .']" 	value="'. $crk_meta_temp .'">;
	// 				<input type="text" 	name="clockwork_meta[loop_priority_'. $i .']" 	value="'. $crk_meta_prio .'">;
	// 			</div>';
	// }

	$ctr = 0;

	foreach ( $clockwork_hooks as $clockwork_hook ) {

		$crk_meta_actn = $clockwork_hook['loop_action'];
		$crk_meta_hook = $clockwork_hook['loop_hook'];
		$crk_meta_temp = $clockwork_hook['loop_template'];
		$crk_meta_prio = $clockwork_hook['loop_priority'];

		echo '	<br>

				<div class="form-wrapper">
					
					<p>	<select class="loop_action" name="clockwork_meta[loop_action_'. $ctr .']">
							<option value="add" '. ( $crk_meta_actn == 'add' ? 'selected' : '' ) .'>Add Action</option>
							<option value="remove" '. ( $crk_meta_actn == 'remove' ? 'selected' : '' ) .'>Remove Action</option>
						</select>
						<button class="delete_clockwork_hook" index="'. $ctr .'">Delete Hook</button>
					</p>

					<label>loop_hook</label>
					<input type="text" class="loop_hook" name="clockwork_meta[loop_hook_'. $ctr .']" 			value="'. $crk_meta_hook .'">

					<label>loop_template</label>
					<input type="text" class="loop_template" name="clockwork_meta[loop_template_'. $ctr .']" 	value="'. $crk_meta_temp .'">

					<label>loop_priority</label>
					<input type="text" class="loop_priority" name="clockwork_meta[loop_priority_'. $ctr .']" 	value="'. $crk_meta_prio .'">
				</div>';

		$ctr++;
	}


	echo '</div>';






	// if( $value == 1 ){

	// 	$temp .= 	'	<br>';

	// 	$temp .= 	'	Hook Control';

	// 	$temp .= 	'	<br>';

	// 	$temp .= 	'	<label for="clockwork_interface_state">add_action => </label> ';

	// 	// $temp .= 	'	<input type="text" name="calibrefx_settings_clockwork_test" value="'. $value2 .'"  />';
	// 	$temp .= 	'	<input type="text" name="clockwork_metas[loop_hook]" value="'. ( $clockwork_metas['loop_hook'] ? $clockwork_metas['loop_hook'] : '' ) .'"  />';
	// 	$temp .= 	'	<input type="text" name="clockwork_metas[loop_template]" value="'. ( $clockwork_metas['loop_template'] ? $clockwork_metas['loop_template'] : '' ) .'"  />';
	// 	$temp .= 	'	<input type="text" name="clockwork_metas[loop_priority]" value="'. ( $clockwork_metas['loop_priority'] ? $clockwork_metas['loop_priority'] : '' ) .'"  />';
	// 	$temp .= 	'	<br>';
	// 	$temp .= 	'	remove_action => <input type="checkbox" name="clockwork_metas[loop_remove]" value="remove" '. ( $clockwork_metas['loop_remove'] ? 'checked' : '' ) .' />';
	// 	$temp .= 	'	<input type="text" name="clockwork_metas[loop_remove_hook]" value="'. ( $clockwork_metas['loop_remove_hook'] ? $clockwork_metas['loop_remove_hook'] : '' ) .'" />';
	// }

	// echo  	'	<div class="row">
	// 				<div class="col-md-12">
	// 					<div id="clockwork_customize_wrapper" class="clockwork-settings-slug-'. $post->post_title .' clockwork-settings-id-'. $post->post_title .'">
	// 						'. $temp .'
	// 					</div>
	// 				</div>
	// 			</div>';
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

	$crk_count = $_POST['clockwork_hooks'];

	$temp = array();

	for( $x = 0; $x < $crk_count; $x++ ){

		// $temp[''. $_POST['clockwork_meta']['loop_hook_'.$x.''] .''] = $_POST['clockwork_meta']['loop_hook_'.$x.''];
		$temp[''. $_POST['clockwork_meta']['loop_hook_'.$x.''] .''] = array(
			'loop_action'=>$_POST['clockwork_meta']['loop_action_'.$x.''],
			'loop_hook'=>$_POST['clockwork_meta']['loop_hook_'.$x.''],
			'loop_template'=>$_POST['clockwork_meta']['loop_template_'.$x.''],
			'loop_priority'=>$_POST['clockwork_meta']['loop_priority_'.$x.'']
		);
	}

	// for( $y = 0; $y < count( $temp ); $y++ ){

	// 	$temp[$y] = array(
	// 		'loop_hook'=>$_POST['clockwork_meta']['loop_hook_'.$y.''],
	// 		'loop_template'=>$_POST['clockwork_meta']['loop_template'.$y.''],
	// 		'loop_priority'=>$_POST['clockwork_meta']['loop_priority'.$y.'']
	// 	);
	// }

	var_dump( $_POST['clockwork_meta'] ); 
	echo "<br>";
	echo "<br>";
	var_dump( $temp );

	update_post_meta( $post_id, 'clockwork_hooks', $temp );
	exit;



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