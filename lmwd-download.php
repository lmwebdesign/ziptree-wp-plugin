<?php 
define('WP_USE_THEMES', false);
require('../../../wp-blog-header.php');
require('lmwd-defines.php');
set_time_limit(120); 

$fpath = $path. DS .$ztd;

if(isset($_POST['cptdwld']) && $_POST['cptdwld'] !=''){
	$fname = $_POST['cptdwld'].'.zip';
	echo dwldFiles($fname,$fpath);
}
if(isset($_POST['pdwld']) && $_POST['pdwld'] !=''){
	$post = get_post($_POST['pdwld']);
	$fname = $post->post_name.'.zip';
	
	echo dwldFiles($fname,$fpath);
	
}
function dwldFiles($filename,$filepath){
	
	$rpath = $filepath.DS.$filename;
	if(is_file($rpath)){
		$dlink = home_url().'/wp-content/uploads/ziptree/'.$filename;
		return json_encode(array('dlink'=>$dlink));
	}
	else{
		return json_encode(array('msg'=>'<span class="bad">X</span>'.$filename.' does not exist.'));
	}
	//return json_encode(array('msg'=>$rpath));
	
}
?>
