
        jQuery('#take_location_add').click(function(){ 	   
          var addr = jQuery('#name_add').val();
          if ( !addr || !addr.length ) return;
          jQuery("#g-map").gmap3({
            action:   'getlatlng',
            address:  addr,
            callback: function(results){
              if ( !results ) return;
			  var lag = results[0].geometry.location;
			  jQuery('#location-x').val(lag.$a);
			  jQuery('#location-y').val(lag.ab);
			   
              jQuery(this).gmap3({
                 action: 'addMarker',
            latLng: lag,
            map:{
              center: true,
              zoom: 16
            },
            marker:{
              options:{
                draggable:true
              },
              events:{
                dragend: function(marker){
                  jQuery(this).gmap3({
                    action:'getAddress',
                    latLng:marker.getPosition(),
                    callback:function(results){
                      var map = jQuery(this).gmap3('get'),
                          infowindow = jQuery(this).gmap3({action:'get', name:'infowindow'}),
                          content = results && results[1] ? results && results[1].formatted_address : 'no address';						 						
						  var mpk = marker.getPosition();
						   jQuery('#location-x').val(mpk.$a);
			  				jQuery('#location-y').val(mpk.ab);
			  
						 
                      if (infowindow){
                        infowindow.open(map, marker);
                        infowindow.setContent(content);
                      } else {
                        jQuery(this).gmap3({action:'addinfowindow', anchor:marker, options:{content: content}});
                      }
                    }
                  });
                }
              }
            }
        
              });
            }
          });
        });
		
		
		
        
   
		  
      
        jQuery('#take_location').click(function(){
		var lx = jQuery('#location-x').val();
			var ly = jQuery('#location-y').val();
			 if ( !lx || !lx.length || !ly || !ly.length ) return;
			 
        jQuery('#g-map').gmap3(
          { action: 'addMarker',
            latLng: [lx,ly],
            map:{
              center: true,
              zoom: 16
            },
            marker:{
              options:{
                draggable:true
              },
              events:{
                dragend: function(marker){
                  jQuery(this).gmap3({
                    action:'getAddress',
                    latLng:marker.getPosition(),
                    callback:function(results){
                      var map = jQuery(this).gmap3('get'),
                          infowindow = jQuery(this).gmap3({action:'get', name:'infowindow'}),
                          content = results && results[1] ? results && results[1].formatted_address : 'no address';						 						
						  var mpk = marker.getPosition();
						   jQuery('#location-x').val(mpk.$a);
			  				jQuery('#location-y').val(mpk.ab);
			  
						 
                      if (infowindow){
                        infowindow.open(map, marker);
                        infowindow.setContent(content);
                      } else {
                        jQuery(this).gmap3({action:'addinfowindow', anchor:marker, options:{content: content}});
                      }
                    }
                  });
                }
              }
            }
          }
          );
      });
		
		function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}
   