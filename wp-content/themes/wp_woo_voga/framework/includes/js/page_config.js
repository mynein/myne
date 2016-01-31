jQuery(document).ready(function(){
	/* attach event to  page attributes changed */ 
    if(jQuery("select#page_template").length > 0 ){
        jQuery( "select#page_template" ).on( "change", function() {
            if( jQuery.trim(jQuery( this ).find('option:selected').html()) == 'Portfolio Template'){
                jQuery("li.portfolio_columns").show();
            } else {
                jQuery("li.portfolio_columns").hide();
            }
        });
    }
	/* attach event to  page attributes changed */ 
    if(jQuery("select#page_template").length > 0 ){
		var old_option = jQuery.trim(jQuery( 'select#page_template' ).find('option:selected').html());
		if( old_option == 'Contact Template' || old_option == 'Fullwidth Template' || old_option == 'Sitemap Template' || old_option == 'Archive Template'){
			jQuery("#page_config").hide();
		}
		if( old_option == 'Blog Template' || old_option == 'Portfolio Template'){
			jQuery("li.sub_layout").hide();
		}
        jQuery( "select#page_template" ).on( "change", function() {
			jQuery("#page_config .page_config_list li").show();
			var option = jQuery.trim(jQuery( this ).find('option:selected').html());
            if( option == 'Contact Template' || option == 'Sitemap Template' || option == 'Archive Template'){
                jQuery("#page_config").hide();
            } else if( option == 'Blog Template' || option == 'Portfolio Template'){
				jQuery("#page_config").show();
				jQuery("li.sub_layout").hide();
			} else if( option == 'Fullwidth Template' ){
				jQuery("#page_config").show();
				jQuery("li.sub_layout").hide();
				jQuery('#page_layout, #page_column, #_left_sidebar, #_right_sidebar').parents('li').hide();
			} else {
                jQuery("#page_config").show();
				jQuery("li.sub_layout").show();
            }
			 
        });
		jQuery( "select#page_template" ).trigger('change');
    }
	if(jQuery("select#page_layout").length > 0 ){
        jQuery( "select#page_layout" ).on( "change", function() {
            if( jQuery.trim(jQuery( this ).find('option:selected').html()) == 'Wide'){
				var option = jQuery.trim(jQuery( "select#page_template" ).find('option:selected').html());
				if( option != 'Blog Template' && option != 'Portfolio Template'){
					jQuery("li.sub_layout").show();
				}
            } else {
                jQuery("li.sub_layout").hide();
            }
        });
    }
	
	/* Upload Logo */
	jQuery('.page_config_list .upload_button').bind('click',function() {
		var button = jQuery(this);
		var clear_button = jQuery(this).siblings('.clear_button');
		var input_field = jQuery(this).siblings('input.upload_field');   
		wp.media.editor.send.attachment = function(props, attachment){
			var attachment_url = '';
			attachment_url = attachment.sizes[props.size].url;
			input_field.val(attachment_url);
			if( input_field.siblings('.preview_image').length > 0 ){
				input_field.siblings('.preview_image').attr('src', attachment_url);
			}
			else{
				var img_html = '<img class="preview_image" src="' + attachment_url + '" />';
				input_field.parent().append(img_html);
			}
			clear_button.attr('disabled', false);
		}
		wp.media.editor.open(button);
	});
	
	jQuery('.page_config_list .clear_button').bind('click', function(){
		var button = jQuery(this);
		button.attr('disabled', true);
		button.siblings('input.upload_field').val('');
		button.siblings('.preview_image').fadeOut(300, function(){
			button.siblings('.preview_image').remove();
		});
	});
});