<?php 
$fname = as_fix_name($_POST['image_name']);
$url = 'http://thewandering.net/activities/wpplugin/check_name_image.php';
//$url = 'http://ascoder.net/wplugin/check_name_image_api.php';
$rep = check_name_image($url, $fname);
if(is_numeric($rep)&&$rep>0){
	echo re_name_image($fname,$rep);
}else{
	echo $fname;
}
function check_name_image($url, $data) {
$post_data = "fname=".$data; 
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
function re_name_image($name,$ad) {
	$namear = explode('.',$name);
	return $namear[0].'-'.$ad.'.'.$namear[1];
}
function as_fix_name($name){
	return str_replace("-", "_", $name);
}
?>