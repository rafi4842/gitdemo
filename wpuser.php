<?php
// ADD NEW ADMIN USER TO WORDPRESS
// ----------------------------------
// Put this file in your Wordpress root directory and run it from your browser.
header('Content-type: text/html; charset=utf-8');
define( 'WP_USE_THEMES', false );
//pw generator 
			function mk_pw($length = 12) {

			$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-+=_,!@$#*%[]{}";

			$pw = '';

			for ($i = 0; $i < $length; $i++) {

			$pw .= $characters[mt_rand(0, strlen($characters) - 1)];

			}

			return $pw;

			}

require_once('wp-blog-header.php');
require_once('wp-includes/link-template.php');

//Only blog header required.
//require_once('wp-includes/registration.php');
//require_once('wp-config.php');

// ----------------------------------------------------
// CONFIG VARIABLES
// Make sure that you set these before running the file.
$newusername = 'gdsupport_user';
$newpassword = mk_pw();
$newemail = 'gaosupport@secureserver.net';
// ----------------------------------------------------
	// Check that user doesn't already exist
	if ( username_exists($newusername) && email_exists($newemail) )
	{
		//echo '<p class="notice">This user or email already exists. Removing old user from data base.</br>';
		require_once(ABSPATH.'wp-admin/includes/user.php');	
		$user_rmv = get_user_by( 'email', $newemail );
		wp_delete_user( $user_rmv->ID);
		
	}
		// Create user and set role to administrator
		$user_id = wp_create_user( $newusername, $newpassword, $newemail);
		if ( is_int($user_id) )
		{
			$path = $_SERVER['SCRIPT_FILENAME'];
			$wp_user_object = new WP_User($user_id);
			$wp_user_object->set_role('administrator');


			//This part of code auto logins users to backend with newly created user.
			
				$user_login = 'wpps-support';   
				$user = get_user_by( 'email', 'wppssupport@secureserver.net' );
				$user_id = $user->ID;   
				wp_set_current_user($user_id, $user_login);  
				wp_set_auth_cookie($user_id);   
				do_action('wp_login', $user_login); 

				//wp_safe_redirect(site_url('wp-admin'));
				//This line will instantly load loged in dashboard upon wpuser.php loading

			echo '<p class="notice">Successfully created new admin user. This file will self destruct.</h3></br><h3><br>Details</p> <h4 style= "font-weight:100;" >User:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><span onclick="copy(this)" id="user"><button title="Click to copy">'.$newusername.'</button></span></strong>
			 </br>Password: &nbsp;&nbsp;<strong><span onclick="copy(this)" id="pass"><button class="pass" title="Click to copy">'.$newpassword.'</button></span></strong><br>
			 WP-admin: &nbsp;<a href="'. admin_url() .'" target="_blank"><button class="login" style="margin-left:7px;" title="Open in new tab" ><span>Open</span></button></a>
			 </h4>';
			 echo "<br>Current PHP version: " . phpversion();
			 echo "<br>Current WP version: " . $wp_version;
			 
			?>
			<script>
//JavaScript function that copies content of span input to clipboard
function copy(that){
var inp =document.createElement('input');
document.body.appendChild(inp)
inp.value =that.textContent
inp.select();
document.execCommand('copy',false);
inp.remove();
}
</script>
<style>
body {
	font-family: Arial;
	color: white;
	background: linear-gradient(to bottom, #323232 0%, #3F3F3F 40%, #1C1C1C 150%), linear-gradient(to top, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.25) 200%);
 	background-blend-mode: multiply;
 	margin: 0;
 	padding: 10px;
}

button {
	font-size: 18px;
	margin: 7px;
	width: 180px;
	outline: none;
	padding: 7px;
	border-radius: 3px;
	background-color: #4AA24C;
	font-weight: bold;
	color: white;
	border: none;

}
button:active {
	color: rgba(255,255,255,0.8);	
}
button:hover {
	cursor: pointer;
}
button:hover:after {
	content:'📋';
	position: absolute;
	left: 290px;
	line-height: 23px;
	font-size: 23px;
	opacity: 1;
	transition-duration: 0.3s;
}

button:after {
	content:'📋';
	position: absolute;
	left: 290px;
	line-height: 23px;
	font-size: 23px;
	opacity: 0;
	transition-duration: 0.3s;
}
button.pass {
text-security:circle;
-webkit-text-security:circle;
-mox-text-security:circle;
}
button.pass:after {
	text-security:none;
-webkit-text-security:none;
-mox-text-security:none;
}
button.login:hover:after {
	content:'👤';
	position: absolute;
	left: 290px;
	line-height: 23px;
	font-size: 23px;
	opacity: 1;
	transition-duration: 0.3s;
}

button.login:after {
	content:'👤';
	position: absolute;
	left: 290px;
	line-height: 23px;
	font-size: 23px;
	opacity: 0;
	transition-duration: 0.3s;
}

p.notice {
	margin: -10px;
	padding: 10px;
	background: rgba(255,255,255,0.2);
}
</style><?php
		shell_exec('rm -f '.$path); }
		else {
			echo '<p class="notice" tyle="color:red;">Error with wp_insert_user. No users were created. Check user and usermeta tables.<p>';
		}
?>