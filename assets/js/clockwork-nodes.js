
childfx.addNode({
	name 		: 'init_clockwork_forms',
	locations 	: ['wp-admin'],
	func_names 	: ['init_form']
});


childfx.addNode({
	name 		: 'button_handler',
	locations 	: ['wp-admin'],
	func_names 	: ['button_add_hook']
});


childfx.addNode({
	name 		: 'append_form_modal',
	locations 	: ['wp-admin'],
	func_names 	: ['append_modal']
});