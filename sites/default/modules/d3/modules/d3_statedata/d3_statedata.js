/*
 * @file
 * JavaScript for d3_statedata.
 *
 * See @link d3_statedata_dependent_dropdown_degrades @endlink for
 * details on what this file does. It is not used in any other example.
 */
jQuery.noConflict();

jQuery(window).load(function() {
  
  jQuery('#slideBloc').click(function () {
   jQuery('#searchBloc').slideToggle('2000', "swing", function () {
          // Animation complete.
      });
      
    
           jQuery(this).toggleClass('open');
    
      
  });
    positionTable();//run when page first loads
});

jQuery(window).bind('resize', function(e){
    window.resizeEvt;
    jQuery(window).resize(function(){
        clearTimeout(window.resizeEvt);
        window.resizeEvt = setTimeout(function(){
         positionTable();
        }, 1000);
    });
});
	 function positionTable() {
		var tablewid;
		var chartwid;
		
		var tablecontainer;
			if( jQuery('.charttable').length )   {
			 tablewid = jQuery('.charttable').width();
		 chartwid = jQuery('#visualization svg').width();
			
			 tablecontainer = jQuery('.col-sm-12').width();
			
			if (tablewid > tablecontainer) {
				
				
	/*		if (tablewid > tablecontainer) { var tablemargin =  (tablewid/2 - tablecontainer/2);
				jQuery('.charttable' ).css({
					            'margin-left' : -tablemargin + 'px'
						        });
			 }
			if (chartwid > tablecontainer) { var chartmargin = (chartwid/2 - tablecontainer/2);
				jQuery('#visualization svg').css({
					            'margin-left' : -chartmargin + 'px'
						        });
			
			 } */
 			jQuery('.page-data-showchart .container.main-container').css({
  			            'width' :  (tablewid + 60)  + 'px',
							'padding' : 0

  		        });
	   			jQuery('.page-data-showchart .col-sm-12').css({
	    			            'width' : (tablewid + 30)  + 'px',
	  							'padding-left' : '30px'

	    		        });
	  		 		
		 } else if (chartwid > tablecontainer) {
  			jQuery('.page-data-showchart .container.main-container').css({
   			            'width' :  (chartwid + 60)  + 'px',
 							'padding' : 0

   		        });
 	   			jQuery('.page-data-showchart .col-sm-12').css({
 	    			            'width' : (chartwid + 30)  + 'px',
 	  							'padding-left' : '30px'

 	    		        });
			 
			 } else { jQuery('.main-container').css({
		  			            'margin' : 'auto'
		  		        }); 
					 
					  }
					
			return;
		}
	}
		
 

		