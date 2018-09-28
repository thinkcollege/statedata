/*jQuery.noConflict();
 jQuery(document).ready(function() {
   jQuery("input[name='compareProv[]'").each(function(i) {
    jQuery(this).on("click", function() {
 
    if(jQuery(this).is(':checked'))
    { // alert(jQuery(this).val());
      putInSession(jQuery(this).val());
  }
     });
       });
       });
       function putInSession(idval) {  jQuery.ajax({url:'../../../sites/statedata.info/modules/sd_providersearch/sd_providersearch_compare.php',type:'POST',data:{compareid:idval },dataType:'json', success:compareHandler,error:errorHandler});
        }
        function compareHandler (data, textStatus, jqXHR) {
          alert(data );
        }
        function errorHandler(jqXHR, textStatus, errorThrown) {
			             alert(errorThrown);
        } */
