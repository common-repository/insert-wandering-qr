<?php 
require_once('../../../wp-load.php');
require_once( ABSPATH . WPINC . '/template-loader.php' );
$url = 'http://thewandering.net/activities/wpplugin/form.php';
$rep = do_post_data($url,$_POST['xml']);
add_post_meta($_POST['postID'], 'wandering_link', $rep);
echo 'Add wandering activity to post successful';;
function do_post_data($url, $data) {
$post_data = "xmldata=".$data; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
$output = curl_exec($ch); 
curl_close($ch);
return $output;
}