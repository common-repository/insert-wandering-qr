<?php 
require_once('../../../wp-load.php');
require_once( ABSPATH . WPINC . '/template-loader.php' );
//$current_user = wp_get_current_user();
//if(0 == $current_user->ID)return;

$current_user = get_option('qr_settings');

global $wpdb;
$postID = $_REQUEST['postID']; 
$apost = get_post($postID); 
$post_tag = wp_get_post_terms($postID,'post_tag',array("fields" => "names")) ;
$category = wp_get_post_terms($postID,'category',array("fields" => "names")) ;
$terms = array_merge($post_tag,$category);

$xml = '';
//$xml .= '<name>'.cdataspecial($current_user->display_name).'</name>';
$xml .= '<name>'.cdataspecial($current_user['qr_name']).'</name>';
//$xml .= '<email>'.cdataspecial($current_user->user_email).'</email>';
$xml .= '<email>'.cdataspecial($current_user['qr_email']).'</email>';
$xml .= '<postlink>'.cdataspecial($apost->guid).'</postlink>';
$xml .= '<StationName>'.cdataspecial($apost->post_title).'</StationName>';

$ta = array(
'People1'=>$terms[0],
'People2'=>$terms[8],
'People3'=>$terms[16],
'People4'=>$terms[24],
'People5'=>$terms[32],
'People6'=>$terms[40],
'People7'=>$terms[48],
'Area1'=>$terms[1],
'Area2'=>$terms[9],
'Area3'=>$terms[17],
'Area4'=>$terms[25],
'Area5'=>$terms[33],
'Area6'=>$terms[41],
'Area7'=>$terms[49],
'Perception1'=>$terms[2],
'Perception2'=>$terms[10],
'Perception3'=>$terms[18],
'Perception4'=>$terms[26],
'Perception5'=>$terms[34],
'Perception6'=>$terms[42],
'Perception7'=>$terms[50],
'Time1'=>$terms[3],
'Time2'=>$terms[11],
'Time3'=>$terms[19],
'Time4'=>$terms[27],
'Time5'=>$terms[35],
'Time6'=>$terms[43],
'Time7'=>$terms[51],
'Space1'=>$terms[4],
'Space2'=>$terms[12],
'Space3'=>$terms[20],
'Space4'=>$terms[28],
'Space5'=>$terms[36],
'Space6'=>$terms[44],
'Space7'=>$terms[52],
'Verb1'=>$terms[5],
'Verb2'=>$terms[13],
'Verb3'=>$terms[21],
'Verb4'=>$terms[29],
'Verb5'=>$terms[37],
'Verb6'=>$terms[45],
'Verb7'=>$terms[53],
'Adjective1'=>$terms[6],
'Adjective2'=>$terms[14],
'Adjective3'=>$terms[22],
'Adjective4'=>$terms[30],
'Adjective5'=>$terms[38],
'Adjective6'=>$terms[46],
'Adjective7'=>$terms[54],
'Misc1'=>$terms[7],
'Misc2'=>$terms[15],
'Misc3'=>$terms[23],
'Misc4'=>$terms[31],
'Misc5'=>$terms[39],
'Misc6'=>$terms[47],
'Misc7'=>$terms[55]
);
foreach($ta as $key=>$val){
	$xml .= '<'.$key.'>'.cdataspecial($val).'</'.$key.'>';
} 
echo $xml;

function cdataspecial($spc){
		return '<![CDATA['.$spc.']]>';
	}