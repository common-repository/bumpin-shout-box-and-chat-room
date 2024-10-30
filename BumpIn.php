<?php
/*
	Plugin Name: BumpIn
	Plugin URI: http://www.bumpin.com
	Description: Install BumpIn widgets for your wordpress and give an interaction mechanism to people visiting your website.
	Author: BumpIn Team (team@bumpin.com)  thanks to Yaser Awan (yaser@2scomplement.com) for v1.0
	Version: 5.0
	Author URI: http://www.bumpin.com/
*/

/*  Copyright 2008  BumpIn  (email : info@bumpin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function render_bumpin( $opt, $before_title, $after_title) {
	$bumpin_code = apply_filters( 'widget_text', $opt['bumpin_code'] );
	
	global $current_user;
	get_currentuserinfo();

	if ( is_null($current_user->display_name) || $current_user->display_name =='' || !isset($current_user->display_name) ){ // check signed in if
		//$parameters .= "nick_name: '' ";
	}
	else{
		$bumpin_code = str_replace('nick_name: ""','nick_name: "'.$current_user->display_name.'" ',$bumpin_code);
	}

	echo $bumpin_code;
}

function widget_bumpin_control( $args=null ) {
	$options = $newoptions = get_option('BumpIn');

	if ( $_POST["submit_code"] ) {
		$newoptions['bumpin_code'] = stripslashes($_POST["bumpin_code"]);
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('BumpIn', $options);
	}

	$bumpin_code = format_to_edit($options['bumpin_code']);

	$control_html = '';
	$control_html .= '<p style="text-align:justify;">Enabling the BumpIn widgets on your blog is a two step process:</p>';
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:#FF6600;font-size:16px;font-weight:bold">1) Customize: </span> Customize the colors, size and placement of the selected widget according to the look&feel of your blog/website. At the end of this process you will be given a short snippet of code which you can cut and paste in step 2 below. (Please use a valid email id when registering the widget since it will be used for verification.)</p>';
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:#FF6600;font-size:16px;font-weight:bold">2) Embed: </span>Cut and paste the code you got from BumpIn site in the following text box and click the "Save Changes" button. Please do not modify the code!</p>';
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:black;font-size:16px;font-weight:bold">- BumpIn Chat:</span> To get the code for the shoutbox/chatroom/tagboard <a href = "http://site.bumpin.com/widget/new_checkout?wordpress=true" target = "_blank">Click Here</a><br/><span style="font-family:times;color:black;font-size:16px;font-weight:bold">- BumpIn Socialbar:</span> To get the code for the bar <a href = "http://socialbar.bumpin.com/checkout?wordpress=true" target = "_blank">Click Here</a></p>';
	$control_html .= '<textarea style="width: 590px; height: 150px;" id="bumpin_code" name="bumpin_code">'.$bumpin_code.'</textarea>';
	$control_html .= '<input type="hidden" id="submit_code" name="submit_code" value="1" />';
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:#585858;font-size:16px;font-weight:bold">Verification: </span>Once step 1 & 2 are successfully done, you will receive an email from BumpIn on the same id you used for registering. Please click on the link in the email to set your password for administrative rights to the widget.</p>';
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:#585858;font-size:16px;font-weight:bold">Admin: </span>You can login to moderate and re-customize the widget. Your login name is the email you used for registration.<a href = "http://site.bumpin.com/user_session/new" target = "_blank"> Click Here for Chat Admin</a> : <a href = "http://socialbar.bumpin.com/user_session/new" target = "_blank">Click Here for Socialbar Admin</a>. </p>';	
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:#FF6600;font-size:16px;font-weight:bold">* </span>If you have forgotten your password, you can reset it <a href="http://site.bumpin.com/site/forgot_password/" target="_blank">(Click to reset password)</a>, by verifying your email address.</p>';
	$control_html .= '<p style="text-align:justify;"><span style="font-family:times;color:#FF6600;font-size:16px;font-weight:bold">* </span>If you re-customize the widget please dont forget to update the code in the text box above.</p>';

	echo $control_html;
}

function widget_bumpin($args) {
	extract($args);
	$options = get_option('BumpIn');
	echo $before_widget;
	render_bumpin($options,$before_title,$after_title); 
  	echo $after_widget;
}

function bumpin_init()
{
	register_sidebar_widget(__('BumpIn'), 'widget_bumpin');   
	register_widget_control('BumpIn','widget_bumpin_control',600,600);    /* width, height*/
}
add_action("plugins_loaded", "bumpin_init");
?>
