<?php
	//Checks that ZipTree directory exists
	define('DS', DIRECTORY_SEPARATOR);
	$uploads = wp_upload_dir();

	$ztd = 'ziptree';
	$path = realpath($uploads['basedir']);
	$burl = $uploads['baseurl'];
		
	//QUERY ALL CPT
	$args=array(
	  'public'   => true,
	  '_builtin' => false
	); 
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$cpts = get_post_types($args,$output,$operator); 
	global $wpdb;
?>