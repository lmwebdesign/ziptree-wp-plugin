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


	add_action('admin_init','lmwd_ziptree_init');
	add_action('admin_menu','lmwd_ziptree_actions');
	
	function lmwd_ziptree_admin() {
		include('lmwd_ziptree_admin.php');
	}
	function lmwd_ziptree_init() {
		if($_GET['page']=='ZipTree'){
        /* Register our script. */ 
        wp_register_script( 'lmwd_ziptree_js', plugins_url( '/js/jquery.js', __FILE__ ) );

		// Link our already registered script to a page 
        wp_enqueue_script( 'lmwd_ziptree_js' );
		}
    }
	
	function lmwd_ziptree_actions(){
		add_options_page("ZipTree", "ZipTree", 1, "ZipTree", "lmwd_ziptree_admin");
		
		add_action( 'admin_enqueue_scripts', 'lmwd_ziptree_styles' );
	}
	
	function lmwd_ziptree_styles(){
		// Register the style like this for a plugin:
		wp_register_style( 'lmwd-ziptree-style', plugins_url( '/css/style.css', __FILE__ ), array(), '20120208', 'all' );
	 
		// For either a plugin or a theme, you can then enqueue the style:
		wp_enqueue_style( 'lmwd-ziptree-style' );
	}
	

