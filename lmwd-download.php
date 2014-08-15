<?php 
require('lmwd-defines.php');
set_time_limit(120); 
?>
<span class="dlink">
<?php

//folder path	
$fpath = $path. DS .$ztd;

//if download custom post type
if(isset($_POST['cptdwld']) && $_POST['cptdwld'] !=''){
	$fname = $_POST['cptdwld'].'.zip';
	echo dwldFiles($fname,$fpath,$burl.'/'.$ztd);
}

//if download post 
if(isset($_POST['pdwld']) && $_POST['pdwld'] !=''){
	$post = get_post($_POST['pdwld']);
	$fname = $post->post_name.'.zip';
	echo dwldFiles($fname,$fpath,$burl.'/'.$ztd);
}

//check if .zip file exist and provide uri to file
function dwldFiles($filename,$filepath,$uurl){
	$rpath = $filepath.DS.$filename;
	if(is_file($rpath)){
		$dlink = $uurl.'/'.$filename;
		
		return '<a href="'.$dlink.'" target="_blank">download</a>';
	}
	else{
		return '<span class="bad">X</span>'.$filename.' does not exist.';
	}
}
?>
</span>
