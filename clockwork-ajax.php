<?php 

global $calibrefx;

function debug_hook( $hook ) {
	global $wp_filter;
	
	if( ! isset( $wp_filter[$hook] ) )
		return;
	
	$functions = array();
	foreach( (array) $wp_filter[$hook] as $key => $actions ) {
		//$functions = array_merge( $functions,  $actions );
		$functions['priority_' . $key] = array_keys( $actions );
	}
	ksort( $functions );
	return $functions;
}


if( empty( $_REQUEST['do'] ) ) return;

	$do = $_REQUEST['do'];

	switch($do){

		case 'registered_hooks':

			$data = $_POST['data'];

			$hooks = debug_hook( $data );
var_dump($hooks);
			$response = array(
	            "hooks" => $hooks,
	        );
			break;
}