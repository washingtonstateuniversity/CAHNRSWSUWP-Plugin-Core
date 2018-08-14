// CAHNRS Analytics JS Version 0.0.1
/*
 * Link Tracking - Requires jQuery
*/
( function( document, window ) {
	
	var docType = [
		{ type : 'doc' , name : 'Microsoft Word Document'},
		{ type : 'docx' , name : 'Microsoft Word Open XML Document'},
		{ type : 'log' , name : 'Log File'},
		{ type : 'msg' , name : 'Outlook Mail Message'},
		{ type : 'odt' , name : 'OpenDocument Text Document'},
		{ type : 'pages' , name : 'Pages Document'},
		{ type : 'rtf' , name : 'Rich Text Format File'},
		{ type : 'tex' , name : 'LaTeX Source Document'},
		{ type : 'txt' , name : 'Plain Text File'},
		{ type : 'wpd' , name : 'WordPerfect Document'},
		{ type : 'wps' , name : 'Microsoft Works Word Processor Document'},
		{ type : 'csv' , name : 'Comma Separated Values File'},
		{ type : 'dat' , name : 'Data File'},
		{ type : 'gbr' , name : 'Gerber File'},
		{ type : 'key' , name : 'Keynote Presentation'},
		{ type : 'keychain' , name : 'Mac OS X Keychain File'},
		{ type : 'pps' , name : 'PowerPoint Slide Show'},
		{ type : 'ppt' , name : 'PowerPoint Presentation'},
		{ type : 'pptx' , name : 'PowerPoint Open XML Presentation'},
		{ type : 'sdf' , name : 'Standard Data File'},
		{ type : 'tar' , name : 'Consolidated Unix File Archive'},
		{ type : 'vcf' , name : 'vCard File'},
		{ type : 'xml' , name : 'XML File'},
		{ type : 'aif' , name : 'Audio Interchange File Format'},
		{ type : 'iff' , name : 'Interchange File Format'},
		{ type : 'm3u' , name : 'Media Playlist File'},
		{ type : 'm4a' , name : 'MPEG-4 Audio File'},
		{ type : 'mid' , name : 'MIDI File'},
		{ type : 'mp3' , name : 'MP3 Audio File'},
		{ type : 'mpa' , name : 'MPEG-2 Audio File'},
		{ type : 'ra' , name : 'Real Audio File'},
		{ type : 'wav' , name : 'WAVE Audio File'},
		{ type : 'wma' , name : 'Windows Media Audio File'},
		{ type : 'bmp' , name : 'Bitmap Image File'},
		{ type : 'dds' , name : 'DirectDraw Surface'},
		{ type : 'gif' , name : 'Graphical Interchange Format File'},
		{ type : 'jpg' , name : 'JPEG Image'},
		{ type : 'png' , name : 'Portable Network Graphic'},
		{ type : 'psd' , name : 'Adobe Photoshop Document'},
		{ type : 'pspimage' , name : 'PaintShop Pro Image'},
		{ type : 'tga' , name : 'Targa Graphic'},
		{ type : 'thm' , name : 'Thumbnail Image File'},
		{ type : 'tif' , name : 'Tagged Image File'},
		{ type : 'tiff' , name : 'Tagged Image File Format'},
		{ type : 'yuv' , name : 'YUV Encoded Image File'},
		{ type : 'indd' , name : 'Adobe InDesign Document'},
		{ type : 'pct' , name : 'Picture File'},
		{ type : 'pdf' , name : 'Portable Document Format File'},
		{ type : 'xlr' , name : 'Works Spreadsheet'},
		{ type : 'xls' , name : 'Excel Spreadsheet'},
		{ type : 'xlsx' , name : 'Microsoft Excel Open XML Spreadsheet'}
	]
	
	jQuery('body').on( 'click' , 'a' , function( event ){
		
		ca_track_link( jQuery( this ) );
		
	});
	
	window.ca_track_link = function( c_link ){
		
		var href = c_link.attr('href'); 
		
		if ( typeof href !== 'undefined' && href !== false ) { // not an anchor
		
			var is_doc = ca_check_download( href );
		
			if ( is_doc ){ // is document
			
				if ( typeof CAHNRS_Tracker.track.event_hit !== 'undefined' ){
			  
					CAHNRS_Tracker.track.event_hit( 'File Download', is_doc.type , href )
					
				}; // end if
				
			} else { // not document
					
				var label = ca_get_link_name( c_link );
				
				var link_type = ( href.indexOf('wsu.edu') > -1 ) ? 'Inbound Link' : 'Outbound Link';
				
				if ( typeof CAHNRS_Tracker.track.event_hit !== 'undefined' ){
		  
					CAHNRS_Tracker.track.event_hit( link_type, label , href )
					
				}; // end if
			
			} // end if
			
		} // end if
		
	} // end ca_track_link
	
	window.ca_check_download = function( href ){
		
		for ( var i = 0; i < docType.length; i++ ){
			
			if ( href.indexOf( '.' + docType[ i ].type ) > -1 ) {
			
				return docType[ i ];
			
			} // end if
			
		} // end for
		
		return false;
		
	} // end ca_check_download
	
	window.ca_get_link_name = function( c_link ){
		
		var title = c_link.attr('title'); 
		
		if ( typeof title !== 'undefined' && title !== false ) { // not an anchor
		
			return title;
		
		} else {
			
			return c_link.text();
			
		}// end if
		
		return 'undefined';
		
	} // end ca_get_link_name
	
} ) ( document, window );