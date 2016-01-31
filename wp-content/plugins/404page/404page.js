jQuery(document).ready(function($) {
  jQuery( '#select404page' ).change(function() {
    jQuery( '#edit_404_page' ).prop( 'disabled', !( jQuery( '#select404page' ).val() == jQuery( '#404page_current_value').text() != 0 ) );
  });
  jQuery( '#select404page' ).trigger( 'change' );
  jQuery( '#edit_404_page' ).click(function() {
    window.location.replace( jQuery( '#404page_edit_link' ).text() );
  });
});