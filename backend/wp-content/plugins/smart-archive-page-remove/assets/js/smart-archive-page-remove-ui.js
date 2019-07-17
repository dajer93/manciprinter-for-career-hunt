jQuery( document ).ready( function( $ ) {
  
  $( '.pp-smart-archive-page-remove-admin-notice' ).on( 'click', '.notice-dismiss', function ( event ) {
    event.preventDefault();
		data = {
			action: 'pp_smart_archive_page_remove_dismiss_admin_notice',
			pp_smart_archive_page_remove_dismiss_admin_notice: $( this ).parent().attr( 'id' )
		};
		$.post( ajaxurl, data );
		return false;
	});
  
});