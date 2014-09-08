<?php
	include('lmwd-defines.php');
?>
	<ul class="qlist">
<?php		
			
//get post types
if(isset($_POST['cpt']) && $_POST['cpt'] !=''){
if($_POST['cpt']=='all'){
			$posts = $cpts;
		}else{
			$posts = array($_POST['cpt']);
		}
		
		sort($posts);

		foreach ($posts as $cpt ) {
			$count = wp_count_posts($cpt);
			echo '<li id="'.$cpt.'-list">
					<span class="cpt">
						<span class="icon list" alt="cpt">+</span>
						'.$cpt.' ('.$count->publish.')
						<span class="icon mkdir" alt="cpt">F</span>
						<span class="icon zipfiles" alt="cpt">Z</span>
						<span class="icon dwld" alt="cpt">d</span>
					<input class="value" type="hidden" value="'.$cpt.'"/>
					</span><ul></ul></li>';	
		}	
}
//get posts within post types
if(isset($_POST['posttype']) && $_POST['posttype'] !=''){
	$posttype = $_POST['posttype'];
	$args = array(
			'post_type' => $posttype,
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => -1
			);

	global $wpdb;
	$loop = new WP_Query( $args );	
	
	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ){ 
			$loop->the_post();
		
			$post = get_post(get_the_ID());
			echo '<li id="post-'.get_the_ID().'">
					<span class="post">
						<span class="icon list" alt="post">+</span>
						'.$post->post_name.'
						<span class="icon mkdir" alt="post">F</span>
						<span class="icon zipfiles" alt="post">Z</span>
						<span class="icon dwld" alt="post">d</span>
					<input class="value" type="hidden" value="'.get_the_ID().'"/>
					</span><ul></ul></li>';
			wp_reset_postdata();		
		}
	}else{
		echo '<li id="post-'.get_the_ID().'"><span>empty :[</span></li>';
	}	
}
//get attached files withing posts
if(isset($_POST['post']) && $_POST['post'] !=''){
	
	$id = $_POST['post'];
	$q = "SELECT `ID` FROM wp_posts WHERE post_parent=".$id." AND post_type = 'attachment'";	
	$r = $wpdb->get_results($q, OBJECT );
	$post_type = get_post_type($id);
	
	$post = get_post($id);
	
	foreach($r as $k=>$v){
		$obj = get_post_meta($v->ID);
		if($obj['_wp_attached_file'][0]){
			$bp = pathinfo($obj['_wp_attached_file'][0]);
			$curr = realpath($path.DS.$obj['_wp_attached_file'][0]);
			$mvto = $path. DS .$ztd. DS .$post_type. DS .$post->post_name. DS .$bp['basename'];
			if(file_exists($curr)){
				echo '<li><span class="files">'.$obj['_wp_attached_file'][0].'</span></li>';
			}else{
				echo '<li><span class="files na">'.$obj['_wp_attached_file'][0].'--NA</span></li>';
			}
			
		}
	}

}
?>
</ul>
	