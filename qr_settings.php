<div class="wrap">
	<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2>Wandering QR Settings</h2>
    
    <?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings updated.') ?></strong></p>
    </div>
	<?php } ?>
    
    <form action="" method="post">
    	<?php $qrsettings = get_option('qr_settings'); ?>
        <table id="createuser" class="form-table">
            <tr class="form-field form-required">
                <th scope="row">
                    <label for="qr_name">Default Name:</label>
                </th>
                <td><input type="text" id="qr_name" value="<?php if(!empty($qrsettings['qr_name'])) echo $qrsettings['qr_name']; else echo $current_user->display_name; ?>" name="qr_name" /></td>
                <td><span class="description">Default Name to be used</span></td>
            </tr>

            <tr class="form-field form-required">
                <th scope="row">
                    <label for="qr_email">Default Email</label>
                </th>
                <td><input type="text" id="qr_email" value="<?php if(!empty($qrsettings['qr_email'])) echo $qrsettings['qr_email']; else echo $current_user->user_email; ?>" name="qr_email" /><button id="qr_check_username">Check Username</button></td>
                <td><span class="description">Default Email to be used</span></td>
            </tr>

        </table>
         <p class="submit">
         	<input type="hidden" value="1" name="qr_settings_updated">
         	<input type="submit" value="Update Settings" class="button-primary" name="update_settings">         		
         </p>
    </form>
    <p id="register_thewandering" style="display:none;">It seems that your email <strong id="used_email"><?php if(!empty($qrsettings['qr_email'])) echo $qrsettings['qr_email']; else echo $current_user->user_email; ?></strong> is not registered to <a href="http://www.thewandering.net" target="blank">www.thewandering.net</a>. You can click on the following link to <a href="http://www.thewandering.net/index.php?register" target="blank">Sign Up</a>.</p>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery('#qr_check_username').live('click',function(){ 
		var qr_email = jQuery('#qr_email').val();
		data1 = { email: qr_email };
		jQuery.ajax({
			type: "POST",
	  		url: '<?php echo plugins_url('sendcheckup.php', __FILE__);?>',
			data: data1,
			dataType: 'json'
		}).done(function(data) { 
			if (data.reply == 'true') {
				jQuery("#register_thewandering").hide();
				alert ('Email already registered to Thewandering.net website');
			}
			else {
				jQuery("#used_email").html(qr_email);
				jQuery("#register_thewandering").show();
			}
		});
		return false;
	});
});
</script>