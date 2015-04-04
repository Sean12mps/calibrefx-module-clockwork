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

		wp_enqueue_style( 'bootstrap', CALIBREFX_CSS_URL . '/bootstrap.min.css' );
		wp_enqueue_style( 'calibrefx.clockwork', CALIBREFX_MODULE_URL . '/clockwork-builder/assets/css/style.css' );
		wp_enqueue_script( 'bootstrap', CALIBREFX_JS_URL . '/bootstrap.min.js', array( 'jquery' ) );

		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'calibrefx.clockwork' );
		wp_enqueue_script( 'calibrefx.clockwork.nodes' );
		wp_enqueue_script( 'calibrefx.clockwork.functions' );
		wp_enqueue_script( 'calibrefx.clockwork.init' );

		register_setting( 'clockwork_reg_functions', 'cfx_functions' );
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


function get_clockwork_form( $enqueue = false, $args = array( 'hook_slug'=>'', 'hook_action'=>'', 'hook_name'=>'', 'hook_temp'=>'', 'hook_prio'=>'', 'hook_indx'=>'' ) ){

	$hook_slug 		= ( $enqueue ? '#' : $args['hook_slug'] );
	$hook_action 	= ( $enqueue ? '%' : $args['hook_action'] );
	$hook_name 		= ( $enqueue ? '%' : $args['hook_name'] );
	$hook_temp 		= ( $enqueue ? '%' : $args['hook_temp'] );
	$hook_prio 		= ( $enqueue ? '%' : $args['hook_prio'] );
	$hook_indx 		= ( $enqueue ? '%' : $args['hook_indx'] );

	$form_set = '	<br>

					<div class="clockwork-hook form-wrapper row">
						
						<div class="col-md-10 col-md-offset-2">

							<div class="form-header col-md-12">

								<div class="col-md-4">
									
									<label>Loop Slug</label><br>
									<input type="text" class="hook_slug" name="hook_slug[]" value="'. $hook_slug .'">
									<input type="hidden" class="hook_index" name="hook_indx['. $hook_slug .']" value="'. $hook_indx .'">
								</div>

								<div class="col-md-4">
									
									<label>Loop Action</label><br>
									<select class="hook_action" name="hook_action['. $hook_slug .']">

										<option value="add" 	'. ( $hook_action == 'add' 		? 'selected' : '' ) .'	>Add Action</option>
										<option value="remove" 	'. ( $hook_action == 'remove' 	? 'selected' : '' ) .'	>Remove Action</option>
									</select>
								</div>

								<div class="col-md-4">
									
									<label class="col-md-12 text-center">Form Action</label><br>
									<i class="glyphicon glyphicon-remove col-md-4 btn-hook_remove"></i>
									<i class="glyphicon glyphicon-plus col-md-4 btn-hook_addnext"></i>
									<i class="glyphicon glyphicon-move col-md-4 btn-hook_drag"></i>
								</div>
							</div>
							
							<div class="form-content col-md-12">
								
								<div class="col-md-4">

									<label>Hook Name</label><br>
									<input type="text" 	class="hook_name" 	name="hook_name['. $hook_slug .']" 		value="'. $hook_name .'">
								</div>

								<div class="col-md-4">

									<label>Function Name</label><br>
									<input type="text" 	class="hook_temp" 	name="hook_temp['. $hook_slug .']" 		value="'. $hook_temp .'">
								</div>

								<div class="col-md-4">

									<label>Hook Priority</label><br>
									<input type="number" class="hook_prio" 	name="hook_prio['. $hook_slug .']" 		value="'. $hook_prio .'">
								</div>
							</div>
						</div>
					</div>';

	return $form_set;
}


function debug_hook( $hook ) {
	global $wp_filter;
	
	if( ! isset( $wp_filter[$hook] ) )
		return;
	
	$functions = array();
	$ctr = 0;
	foreach( (array) $wp_filter[$hook] as $key => $actions ) {
		//$functions = array_merge( $functions,  $actions );
		// $functions['priority_' . $key] = array_keys( $actions );
		$functions[$ctr] = array( 'action'=>array_keys( $actions ), 'key'=>$key );
		$ctr++;
	}
	// ksort( $functions );
	return $functions;
}


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function clockwork_interface_metabox( $post ) {

	$post_id = $post->ID;

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'clockwork_interface', 'clockwork_meta_box_nonce' );



	/* 	clockwork_interface handle
			var_dump(get_post_meta( $post_id, 'clockwork_interface', true ));
	 */
		$clockwork_interface = ( get_post_meta( $post_id, 'clockwork_interface', true ) ? get_post_meta( $post_id, 'clockwork_interface', true ) : array( 'state'=>'inactive' ) );
		$hook_slug 		= ( get_post_meta( $post_id, 'hook_slug', true ) ? get_post_meta( $post_id, 'hook_slug', true ) : array() );
		$hook_action 	= ( get_post_meta( $post_id, 'hook_action', true ) ? get_post_meta( $post_id, 'hook_action', true ) : array() );
		$hook_name 		= ( get_post_meta( $post_id, 'hook_name', true ) ? get_post_meta( $post_id, 'hook_name', true ) : array() );
		$hook_temp 		= ( get_post_meta( $post_id, 'hook_temp', true ) ? get_post_meta( $post_id, 'hook_temp', true ) : array() );
		$hook_prio 		= ( get_post_meta( $post_id, 'hook_prio', true ) ? get_post_meta( $post_id, 'hook_prio', true ) : array() );

		$hook_registered= debug_hook( 'calibrefx_loop' );

	/*	clockwork_form
	 */ 
		$clockwork_form = array();

		$clockwork_form['state'] = '	
			<select name="clockwork_interface[state]">
				<option value="active"	 '. ( $clockwork_interface['state'] == 'active' ? 'selected' : '' ) .'>Active</option>
				<option value="inactive" '. ( $clockwork_interface['state'] == 'inactive' ? 'selected' : '' ) .'>Inactive</option>
			</select>
		';

		$clockwork_form['add_button'] = '
			<button class="btn-crk btn-add_hook" style="width: 100%; font-size: 22px; text-align: center; cursor: pointer;">
				+
			</button>
		';

		$clockwork_interface['form_set'] = get_clockwork_form( true );
		$clockwork_interface['form_set_delete'] = '<input type="hidden" name="hook_delete[]" class="form_set_delete">';
		$clockwork_interface['ajax'] = CALIBREFX_MODULE_URL . '/clockwork-builder/clockwork-ajax.php';
		$clockwork_interface['autocomp_func'] = $cfx_registered_funcs;
		$clockwork_interface['autocomp_hook'] = array(
			'calibrefx_before_wrapper',
			'calibrefx_before_header',
			'calibrefx_site_title',
			'calibrefx_site_description',
			'calibrefx_header_right_widget',
			'calibrefx_after_header',
			'calibrefx_before_content_wrapper',
			'calibrefx_before_content',
			'calibrefx_before_loop',
			'calibrefx_loop',
			'calibrefx_after_loop',
			'calibrefx_after_content',
			'calibrefx_after_content_wrapper',
			'calibrefx_before_footer',
			'calibrefx_footer',
			'calibrefx_after_footer',
			'calibrefx_after_wrapper',
			'calibrefx_before_post',
			'calibrefx_before_post_title',
			'calibrefx_post_title',
			'calibrefx_after_post_title',
			'calibrefx_before_post_content',
			'calibrefx_post_content',
			'calibrefx_after_post_content',
			'calibrefx_after_post',
			'calibrefx_after_post_loop',
			'calibrefx_no_post',
		);


	/* 	Localize script
	 */
		wp_localize_script( 'calibrefx.clockwork.functions', 'clockwork_interface', $clockwork_interface );



	/* 	Input for clockwork_interface
	 */	?>	
	 	<div class="clockwork_interface_wrapper">
			
			<div class="interface_state">

				<p><strong><?php _e( 'State', 'calibrefx' ); ?> : </strong>

					<?php echo $clockwork_form['state']; ?>
				</p>
			</div>

			<br>
			
			<?php 	if( $clockwork_interface['state'] == 'active' ){ ?>
						
							<div id="interface_hooks_wrapper">

								<!-- loop here -->
								<?php 	

									for( $ctr = 0; $ctr < count( $hook_slug ); $ctr++ ){
										echo get_clockwork_form( false, array(
											'hook_slug'=>$hook_slug[$ctr],
											'hook_action'=>$hook_action[$hook_slug[$ctr]],
											'hook_name'=>$hook_name[$hook_slug[$ctr]],
											'hook_temp'=>$hook_temp[$hook_slug[$ctr]],
											'hook_prio'=>$hook_prio[$hook_slug[$ctr]],
											'hook_indx'=>$ctr
										) );
									}
								 ?>
							</div>
						<br>
						<br>
						<br>

						<div class="interface_action" >
							
							<p><?php echo $clockwork_form['add_button']; ?></p>
						</div>
			<?php 	} ?>
		</div>	
		<?php
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

	// $crk_count = $_POST['clockwork_hooks'];
	// $temp = array();
	// for( $x = 0; $x < $crk_count; $x++ ){

	// 	// $temp[''. $_POST['clockwork_meta']['loop_hook_'.$x.''] .''] = $_POST['clockwork_meta']['loop_hook_'.$x.''];
	// 	$temp[''. $_POST['clockwork_meta']['loop_hook_'.$x.''] .''] = array(
	// 		'loop_action'=>$_POST['clockwork_meta']['loop_action_'.$x.''],
	// 		'loop_hook'=>$_POST['clockwork_meta']['loop_hook_'.$x.''],
	// 		'loop_template'=>$_POST['clockwork_meta']['loop_template_'.$x.''],
	// 		'loop_priority'=>$_POST['clockwork_meta']['loop_priority_'.$x.'']
	// 	);
	// }

	$clockwork_interface = $_POST['clockwork_interface'];

	$hook_slug = $_POST['hook_slug'];
	$hook_action = $_POST['hook_action'];
	$hook_name = $_POST['hook_name'];
	$hook_temp = $_POST['hook_temp'];
	$hook_prio = $_POST['hook_prio'];

	update_post_meta( $post_id, 'clockwork_interface', $clockwork_interface );

	update_post_meta( $post_id, 'hook_slug', 	$hook_slug );
	update_post_meta( $post_id, 'hook_action', 	$hook_action );
	update_post_meta( $post_id, 'hook_name', 	$hook_name );
	update_post_meta( $post_id, 'hook_temp', 	$hook_temp );
	update_post_meta( $post_id, 'hook_prio', 	$hook_prio );



	// var_dump($hook_slug);

	// if ( isset( $_POST['hook_delete'] ) ) {

	// 	$hook_delete = $_POST['hook_delete'];
	// 	$hook_slug = get_post_meta( $post_id, 'hook_slug', true );
	// 	$id = 0;

	// 	for( $del = 0; $del < count( $hook_delete ); $del++ ){

	// 		$id = array_search( $hook_delete[$del], $hook_slug );

	// 		if( $id > -1 ){

	// 			unset( $hook_slug[$id] );
	// 		}
	// 	}

	// 	$hook_slug = array_values( $hook_slug );

	// 	var_dump($hook_slug);
	// }

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

	global $calibrefx, $post;

	add_filter( 'body_class', 'clockwork_body_class' );

	// remove_action('calibrefx_loop', 'calibrefx_do_loop');

	// add_action('calibrefx_loop', 'clockwork_do_loop');

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



function clockwork_function( $args=null ){

	get_template_part( 'clockwork/cfx', 'functions' );
}



function clockwork_before_wrapper(){

	global $post;

	$post_id = $post->ID;

	$clockwork_interface 	= ( get_post_meta( $post_id, 'clockwork_interface', true ) ? get_post_meta( $post_id, 'clockwork_interface', true ) : array( 'state'=>'inactive' ) );

	if( $clockwork_interface['state'] == 'active' ){

		$hook_slug		= ( get_post_meta( $post_id, 'hook_slug', true ) ? get_post_meta( $post_id, 'hook_slug', true ) : array() );
		$hook_action	= ( get_post_meta( $post_id, 'hook_action', true ) ? get_post_meta( $post_id, 'hook_action', true ) : array() );
		$hook_name		= ( get_post_meta( $post_id, 'hook_name', true ) ? get_post_meta( $post_id, 'hook_name', true ) : array() );
		$hook_temp		= ( get_post_meta( $post_id, 'hook_temp', true ) ? get_post_meta( $post_id, 'hook_temp', true ) : array() );
		$hook_prio		= ( get_post_meta( $post_id, 'hook_prio', true ) ? get_post_meta( $post_id, 'hook_prio', true ) : array() );

		for( $ctr = 0; $ctr < count( $hook_slug ); $ctr++ ){
			
			$action 	= $hook_action[$hook_slug[$ctr]];
			$tag 		= $hook_name[$hook_slug[$ctr]];
			$temp 		= $hook_temp[$hook_slug[$ctr]];
			$priority 	= ( $hook_prio[$hook_slug[$ctr]] == '' ? 10 : $hook_prio[$hook_slug[$ctr]] );
			if( $action == 'add' ){

				add_action( $tag, $temp, $priority );
			} else {
				
				remove_action( $tag, $temp, $priority );
			}
		}

		clockwork_function();
	}

}
add_action( 'calibrefx_before_wrapper', 'clockwork_before_wrapper' );


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


function clockwork_ajax_handler() {

	if( empty( $_REQUEST['do'] ) ) return;

	$do = $_REQUEST['do'];

	switch($do){

		case 'registered_hooks':

			$data = $_POST['data'];

			$hooks = debug_hook( $data );
// var_dump('expression');
			$response = $hooks;
			// echo $response;
			break;
	}
	wp_send_json($response);
	// echo json_encode($response);
	wp_die();
}
add_action( 'wp_ajax_clockwork', 'clockwork_ajax_handler' );