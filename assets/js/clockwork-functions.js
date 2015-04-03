childfx.addFunction({
	name 		: 'register_function',
	selector 	: '#clockwork_interface_state',
	func 		: function( $, el ){
		console.log( el );
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