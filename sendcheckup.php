<?php 
require_once('../../../wp-load.php');
require_once( ABSPATH . WPINC . '/template-loader.php' );
$url = 'http://thewandering.net/activities/wpplugin/checkup-users.php';
$rep = do_post_data($url,$_POST['email']);
echo $rep;//Returns the reply from server if user exists or not;
function do_post_data($url, $data) {
$post_data = "email=".$data; 
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