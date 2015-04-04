childfx.addFunction({
	name 		: 'register_function',
	selector 	: '#clockwork_interface_state',
	func 		: function( $, el ){
		console.log( el );
	}
});






childfx.addFunction({
	name 		: 'autocomp_reg_hook',
	selector 	: '.hook_temp',
	func 		: function( $, el ){

		$( el ).on( 'focus', function(){

			var parent = $( this ).parents( '.clockwork-hook' ),
				action = $( parent ).find( '.hook_action' ).val(),
				hook = $( parent ).find( '.hook_name' ).val();

			if( action == 'remove' ){

				// $.ajax({
				// 	type: "POST",
				//   	url: ajaxurl,
				//   	data: { 
				// 		"action" 	: clockwork_interface.ajax_action, 
	   //                  "do" 		: 'registered_hooks', 
	   //                  "data" 		: hook
	   //              },
	   //             	dataType : "json",
	   //              success: function(result){
	   //              	console.log(result);
	   //              }
				// })

				var data = {
					"action" 	: 'clockwork', 
                    "do" 		: 'registered_hooks', 
                    "data" 		: hook
				}

				$.post( 
					ajaxurl, 
					data, 
					function( response ) {

						var hooks = [],
							prior = [],
							temp;

						for( var i = 0; i < response.length; i++ ){

							temp = response[i];
							hooks.push( temp.action[0] );
							prior.push( temp.key );
						}

						$( parent ).find( '.hook_temp' ).autocomplete( {
							source: hooks,
							close: function() {

								var index = hooks.indexOf( $( this ).val() );
								$( parent ).find( '.hook_prio' ).val( prior[index] );
							}
						} );
					}
				);
			}
			
		});
	}
});

childfx.addFunction({
	name 		: 'autocomp_hook',
	selector 	: '.hook_name',
	func 		: function( $, el ){

		$( el ).autocomplete({
			source: clockwork_interface.autocomp_hook,
			minLength: 10
		});
	}
});

childfx.addFunction({
	name 		: 'btn_form_drag',
	selector 	: '.clockwork-hook',
	func 		: function( $, el ){

		$( '#interface_hooks_wrapper' ).sortable({
			cursor: 'move',
			handle: '.btn-hook_drag',
			stop: function( event, ui ) {

				var list = $( '#interface_hooks_wrapper' ).find( '.clockwork-hook' );
			}
		});

    	$( '#interface_hooks_wrapper' ).disableSelection();
	}
});

childfx.addFunction({
	name 		: 'btn_add_form',
	selector 	: '.btn-add_hook',
	func 		: function( $, el ){

		$( el ).on( 'click', function( e ){

			e.preventDefault();

			var modal = clockwork_interface.form_set;

			$( '#interface_hooks_wrapper' ).append( clockwork_interface.form_set );
			
			childfx.init( 'form_listener' );
		} );
	}
});

childfx.addFunction({
	name 		: 'btn_hook_remove',
	selector 	: '.btn-hook_remove',
	func 		: function( $, el ){

		$( el ).on( 'click', function( e ){

			e.preventDefault();

			var parent = $( this ).parents( '.clockwork-hook' ),
				slug = $( parent ).find( '.hook_slug' ).val(),
				modal = clockwork_interface.form_set_delete,
				mod = $( modal ).val( slug );

			$( '.interface_action' ).append( mod );

			$( parent ).remove();
		} );
	}
});

childfx.addFunction({
	name 		: 'btn_hook_add_next',
	selector 	: '.btn-hook_addnext',
	func 		: function( $, el ){

		$( el ).on( 'click', function( e ){

			e.preventDefault();

			var parent = $( this ).parents( '.clockwork-hook' ),
				modal = clockwork_interface.form_set;

			$( parent ).after( clockwork_interface.form_set );
			
			childfx.init( 'form_listener' );
		} );
	}
});

childfx.addFunction({
	name 		: 'form_listener',
	selector 	: '.hook_slug',
	func 		: function( $, el ){

		$( el ).on( 'change keyup', function(){

			var val = $( this ).val(),
				parent = $( this ).parents( '.clockwork-hook' );

				val = val.replace(/\s+/g, '');
				val = val.toLowerCase();

			$( this ).val( val );
			
			$( parent ).find( '.hook_action' ).attr( 'name', 'hook_action['+ val +']' );
			$( parent ).find( '.hook_name' ).attr( 'name', 'hook_name['+ val +']' );
			$( parent ).find( '.hook_temp' ).attr( 'name', 'hook_temp['+ val +']' );
			$( parent ).find( '.hook_prio' ).attr( 'name', 'hook_prio['+ val +']' );
		} );
	}
});












childfx.addFunction({
	name 		: 'append_modal',
	selector 	: '#clockwork_hooks_form',
	func 		: function( $, el ){
		
		var modal = clockwork_builder.form_set,
			i = $( '#clockwork_hooks' ).val(),
			mod = '';

			mod = modal.replace( /%/g, ''+ i +'' ); 

			$( el ).append( mod );
	}
});


childfx.addFunction({
	name 		: 'init_form',
	selector 	: '#clockwork_hooks_form',
	func 		: function( $, el ){

		var modal = clockwork_builder.form_set,
			model = clockwork_builder.hooks_data,
			mod = '',
			i = 0;
			
			$( model ).each( function( index, el ) {
				
console.log(index);
			});

			for( ; i < model.length; i++ ){

				mod = modal.replace( /%/g, ''+ i +'' );

				$( mod ).find( '.loop_hook' ).val( model[i].loop_hook );
				$( mod ).find( '.loop_template' ).val( model[i].loop_template );
				$( mod ).find( '.loop_priority' ).val( model[i].loop_priority );
				$( mod ).find( '.loop_action option[value='+ model[i].loop_action +']' ).attr( 'selected', 'selected' );

				$( el ).append( mod );
			}
	}
});


childfx.addFunction({
	name 		: 'button_add_hook',
	selector 	: '.add_clockwork_hook',
	func 		: function( $, el ){

		$( el ).on( 'click', function( e ){

			e.preventDefault();

			var selc_target = $( this ).attr( 'target' ),
				vals_target = parseInt( $( ''+ selc_target +'' ).val() );

			if( vals_target == 0 ){

				childfx.init( 'append_form_modal' );
			} else {

				childfx.init( 'append_form_modal' );
				$( ''+ selc_target +'' ).val( vals_target + 1 );
			}

		} );
	}
});