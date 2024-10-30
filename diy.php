<?php function diy_form($postID){ ?>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<link href="<?php echo plugins_url('css/qr.css', __FILE__);?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo plugins_url('js/gmap3.min.js', __FILE__);?>"></script>
<script type="text/javascript" src="<?php echo plugins_url('ajax_upload/ajaxupload.3.5.js', __FILE__);?>" ></script>
<div id="add_wadering" class="hidden">
  <form name="add_wadering" method="post">
	<table width="700" border="0">
	<tr>
		<td colspan="2">
			<div id="g-map" class="gmap3"></div>
			Get map by coordinates<br/>
			Location X: <input type="text" name="location-x" size="10" id="location-x" class="text-input" /><br/>
			Location Y: <input type="text" name="location-y" size="10" id="location-y" class="text-input" /> <br/>
			<input id="take_location" type="button" value="Take location" /><br/>
			<br/>Get map by address<br/>
			<input type="text" name="name_add" id="name_add" size="30" class="text-input" /> 
			<input id="take_location_add" type="button" value="Take location" />
		</td>
	</tr>
	
  <tr>
    <td>Name of the Place</td>
    <td> <input type="text" name="name_place" id="name_place" size="50" class="text-input" />  </td>
  </tr>
   <tr>
    <td colspan="2" class="des_more">What is the name of the place the activity is going to take place in? </td>
  </tr>
  <tr>
    <td>Describe the place</td>
    <td><input type="text" name="describe" id="describe" size="50" class="text-input" /></td>
  </tr>

  <tr>
    <td>Action</td>
    <td><textarea name="area_action" id="area_action" cols="42" class="text-input" /></textarea></td>
  </tr>
   <tr>
    <td colspan="2" class="des_more">What do you want the reader to do there? </td>
  </tr>
  <tr>
    <td>Interaction </td>
    <td><input id="interaction" name="interaction" type="radio" value="1" checked="checked" />No
		<input id="interaction" name="interaction" type="radio" value="2" />Yes</td>
  </tr>
   <tr>
    <td colspan="2" class="des_more">Does the activity involve interacting with someone? </td>
  </tr>
   <tr>
    <td>Cost</td>
    <td>
		<input id="cost" name="cost" type="radio" value="1" checked="checked" />No
		<input id="cost" name="cost" type="radio" value="2" />Small payment
		<input id="cost" name="cost" type="radio" value="3" />Yes
	</td>
  </tr>
   <tr>
    <td colspan="2" class="des_more">Is the user required to pay money during the activity?  </td>
  </tr>
  
  <tr>
    <td>Upload an Image </td>
    <td>
	<textarea name="upload_image" id="upload_image" cols="35"></textarea>
	<input id="upload_image_button" type="button" value="Upload Image" />
	</td>
  </tr>
  
   <tr>
    <td colspan="2" class="des_more">Upload what you want to have as the station's image </td>
  </tr>
  <tr>
    <td colspan="2" ><input type="submit" name="submit" class="button" id="save_wandering" value="Submit" /></td>
  </tr>
</table>
  </form>
</div>
<script type="text/javascript" src="<?php echo plugins_url('js/qr.js', __FILE__);?>"></script>
<script type="text/javascript">
var cli = false;
var xmldata = '<data>';
jQuery('#save_wandering').click(function(){ 
	if(cli){return false;}
	var name_place = jQuery('#name_place').val();	  
	var location_placex = jQuery('#location-x').val();	
	var location_placey = jQuery('#location-y').val();	
	var describe = jQuery('#describe').val();	
	var area_action = jQuery('#area_action').val();	
	var interac = jQuery('input[name=interaction]');
	var interaction = interac.filter(':checked').val();
	var co = jQuery('input[name=cost]');
	var cost = co.filter(':checked').val();
	var upload_image = jQuery('#upload_image').val();	
	jQuery.ajax({
		type: "POST",
  		url: "<?php echo plugins_url('getinfo.php', __FILE__);?>",
		data: {postID : <?php echo $postID;?>}
	}).done(function(data) { 
		cli = true;
  		xmldata += data;
		xmldata += '<name_place>'+cdataspecial(name_place)+'</name_place>';
		xmldata += '<location_placex>'+location_placex+'</location_placex>';
		xmldata += '<location_placey>'+location_placey+'</location_placey>';
		xmldata += '<describe>'+cdataspecial(describe)+'</describe>';
		xmldata += '<area_action>'+cdataspecial(area_action)+'</area_action>';
		xmldata += '<interaction>'+interaction+'</interaction>';
		xmldata += '<cost>'+cost+'</cost>';
		xmldata += '<upload_image>'+cdataspecial(upload_image)+'</upload_image>';
		xmldata += '</data>';
		ajax_send_data(xmldata);
	});
});

function ajax_send_data(dt){ 
	jQuery.ajax({
		type: "POST",
  		url: '<?php echo plugins_url('senddata.php', __FILE__);?>',
		data: {xml :dt,postID:<?php echo $postID;?>}
	}).done(function(data) { 
		alert(data);
		window.location.reload();
	});
}

jQuery(function(){
		var btnUpload=jQuery('#upload_image_button');
		new AjaxUpload(btnUpload, {
			action: 'http://thewandering.net/activities/wpplugin/uploadPhoto.php',
			
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) || valid_acci(file)){ 
					alert('Only JPG, PNG or GIF files are allowed or rename file to english');
					return false;
				}else{
					
					jQuery.ajax({
					type: "POST",
  					url: '<?php echo plugins_url('get_img_name.php', __FILE__);?>',
					data: {image_name :file}
					}).done(function(data) { 
						var upload_image = jQuery('#upload_image').val();
					upload_image += '<item>'+'http://thewandering.net/activities/wpplugin/uploads/'+data +'</item>';
					jQuery('#upload_image').val(upload_image);
					});
	
				}
			},
			
		});
	});
	function cdataspecial(spc){
		return '<![CDATA['+spc+']]>';
	}
	function valid_acci(str){
		var re = /[^A-Za-z0-9_, .-]/;
		return str.match(re);
	}
</script>
<?php } ?>