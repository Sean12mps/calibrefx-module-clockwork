
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



childfx.addNode({
	name 		: 'clockwork_interface',
	locations 	: ['wp-admin'],
	func_names 	: ['btn_form_drag','btn_add_form','form_listener','btn_hook_remove','btn_hook_add_next','autocomp_hook','autocomp_reg_hook']
});

childfx.addNode({
	name 		: 'form_listener',
	locations 	: ['wp-admin'],
	func_names 	: ['form_listener','btn_hook_remove','btn_hook_add_next','btn_form_drag','autocomp_hook','autocomp_reg_hook']
});
