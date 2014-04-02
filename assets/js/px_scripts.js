jQuery(document).ready(function($){

    $('.txtDatePick').each(function(){
        $(this).datepicker({
            dateFormat : 'dd-mm-yy'
        });
    });

	// Uploading files
	var file_frame;
	var attachment_str = new Array();
	var count = 0;
 
	jQuery('.upload_image_button').live('click', function( event ) {
			
		event.preventDefault();
 
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}
 
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Upload Wallpapers',
			button: {
				text: 'Add',
			},
			multiple: true // Set to true to allow multiple files to be selected
		});
 
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
	
			var selection = file_frame.state().get('selection');
 
			selection.map( function( attachment ) {
 
				attachment = attachment.toJSON();
				// Do something with attachment.id and/or attachment.url here
				//jQuery('#attach_ids').val(attachment.id);  
				attachment_str.push(attachment.id);
				count++;
			});
			jQuery('#attach_stat').html('<h4>' + count + ' Wallpaper(s) uploaded</h4><br>');  
			jQuery('#attach_ids').val(attachment_str);  
		});

		// Finally, open the modal
		file_frame.open();
	});

});

