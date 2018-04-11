(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

var CAHNRS_Tracker = {
	
	trackers : false,
	
	init: function(){
		
		if ( typeof ca_trackers !== 'undefined' ){
			
			CAHNRS_Tracker.trackers = ca_trackers;
			
			CAHNRS_Tracker.track.pageview();
			
			console.log( CAHNRS_Tracker.trackers );
			
			if ( typeof cahnrs_analytics_callback === "function" ) {
    		// Call it, since we have confirmed it is callable​
        		cahnrs_analytics_callback();
				
    		} // End if
			
		} // end if
		
	},
	
	track : {
		
		event_hit: function( category, action, label, value, interact ){
			
			if ( CAHNRS_Tracker.trackers ){
				
				value = ( typeof value !== 'undefined' ) ? value : 0;
	
				interact = ( typeof interact !== 'undefined' ) ? interact : 0;
				
				for ( var key in CAHNRS_Tracker.trackers ) {
					
					if ( CAHNRS_Tracker.trackers.hasOwnProperty( key ) && CAHNRS_Tracker.trackers[ key ] ){
						
						if ( 'wsu' != key ){
							
							var name = ( 'default' == key )? 'send' : key + '.send';
							
							ga( name, 'event', category, action, label, value , {'nonInteraction': interact } );
					
							console.log( name + ', event, ' + category + ', '+ action + ', '+ label + ', '+ value + ', {nonInteraction: ' + interact + ' }' );
							
						} // end if
						
					} // end if
					
				} // end for
				
			} // end if 
			
		},
		
		pageview: function(){
			
			if ( CAHNRS_Tracker.trackers ){
				
				for ( var key in CAHNRS_Tracker.trackers ) {
					
					if ( CAHNRS_Tracker.trackers.hasOwnProperty( key ) && CAHNRS_Tracker.trackers[ key ] ){
						
						CAHNRS_Tracker.track.create( key , CAHNRS_Tracker.trackers[ key ] ); // create the tracker
			
						if ( 'wsu' == key ){
							
							CAHNRS_Tracker.track.wsu_dimensions( key );
							
						} else {
							
							CAHNRS_Tracker.track.cahnrs_dimensions( key );
							
						} // end if
						
						CAHNRS_Tracker.track.set_display( key ); // set display features
						
						CAHNRS_Tracker.track.send_pageview( key );
						
					} // end if
					
				} // end for
				
			} // end if
			
		}, // end pageview
		
		create: function( name , ua ){
			
			if ( 'default' == name ){
				
				ga('create', ua , 'auto'); // Site specific tracker
				
			} else {
				
				ga('create', ua , 'auto' , { 'name' : name }); // custom tracker
				
			}// end if
			
		}, // end create
		
		set_display: function( name ){
			
			name = ( 'default' == name )? 'require' : name + '.require';
			
			ga( name , 'displayfeatures');
			
		}, /// end set_display
		
		send_pageview: function( name ){
			
			name = ( 'default' == name )? 'send' : name + '.send';
			
			ga( name, 'pageview');
			
			console.log( name + ',pageview' );
			
		}, // end send_pageview
		
		set_dimension: function( name , index , value ){
			
			name = ( 'default' == name )? 'set' : name + '.set';
			
			ga( name , 'dimension' + index , value );
			
			console.log( name + ',' + 'dimension' + index + ',' + value );
			
		}, // end dimensions
		
		cahnrs_dimensions: function( name ){
			
			if ( typeof ca_page_data !== 'undefined' ){
				
				for ( var key in ca_page_data ) {
					
					if ( ca_page_data.hasOwnProperty( key ) ){
						
						var index = false;
						
						switch( key ){
						
							case 'post_type':
								index = 1;
								break;
							case 'author':
								index = 2;
								break;
							case 'published_date':
								index = 3;
								break;
							case 'modified_date':
								index = 4;
								break;
							case 'categories':
								index = 5;
								break;
							case 'tags':
								index = 6;
								break;
							case 'hits':
								index = 7;
								break;
							
						} // end switch
						
						if ( index ){
							
							CAHNRS_Tracker.track.set_dimension( name , index , ca_page_data[ key ] );
							
						} // end if
						
					} // end if
					
				} // end for
				
			} // end if
			
		},//end cahnrs_dimensions
		
		wsu_dimensions: function( name ){
			
			if ( typeof wsu_page_data !== 'undefined' ){
				
				for ( var key in wsu_page_data ) {
					
					if ( wsu_page_data.hasOwnProperty( key ) ){
						
						var index = false;
						
						switch( key ){
						
							case 'protocol':
								index = 1;
								break;
							case 'campus':
								index = 2;
								break;
							case 'college':
								index = 3;
								break;
							case 'unit':
								index = 4;
								break;
							case 'subunit':
								index = 5;
								break;
							case 'editor':
								index = 6;
								break;
							case 'site_url':
								index = 7;
								break;
							case 'unit_type':
								index = 8;
								break;
							
						} // end switch
						
						if ( index ){
							
							CAHNRS_Tracker.track.set_dimension( name , index , wsu_page_data[ key ] );
							
						} // end if
						
					} // end if
					
				} // end for
				
			} // end if
			
		}//end cahnrs_dimensions	
		
	}
	
} // end CAHNRS_Tracker

CAHNRS_Tracker.init();