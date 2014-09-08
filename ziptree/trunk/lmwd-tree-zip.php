<?php
/*
Plugin Name: LMWD Tree Zip
Plugin URI: http://www.lmwebdesigns.net
Description: Copie's photos attached to posts and organizes them in post_type>post_name>images fashion.
Version: 1.0
Author: Luis Maritnez
Author URI: http://www.lmwebdesigns.net
License: GPL2
*/
/*
Copyright 2012 Luis Martinez (email : luisjmartinez2005@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if($_GET['page']=='ZipTree'){
	
	add_action('admin_init','lmwd_ziptree_init');
	add_action('admin_init','lmwd_ziptree_handlers');

	
	function lmwd_ziptree_admin() {
		include('lmwd-defines.php');
		include('lmwd_ziptree_admin.php');
		
	}
	
	function lmwd_ziptree_handlers() {
		include('lmwd-ziptree-lists.php');
		include('lmwd-file-handler.php');
		include('lmwd-download.php');
	}
	
	function lmwd_ziptree_init() {	
		// Get lmwd script with WP's jQuery dependency 
		wp_enqueue_script('lmwd_ziptree_js', plugins_url('/js/lmwd_script.js',__FILE__), array( 'jquery' ));
		// Register the style.
		wp_register_style( 'lmwd-ziptree-style', plugins_url( '/css/style.css', __FILE__ ), array(), '20120208', 'all' );
		// Enqueue the style.
		wp_enqueue_style( 'lmwd-ziptree-style');

    }
}	
	add_action('admin_menu','lmwd_ziptree_actions');

	function lmwd_ziptree_actions(){
		//Place under Settings
		add_options_page("ZipTree", "ZipTree", 1, "ZipTree", "lmwd_ziptree_admin");
	}

