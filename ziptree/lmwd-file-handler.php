<?php
include('lmwd-defines.php');
set_time_limit(120); 
?>
<ul class="qlist">
<?php	
/**
Code snippet for FlzZipArchive class sauce:
http://ninad.pundaliks.in/blog/2011/05/recursively-zip-a-directory-with-php/
**/
class FlxZipArchive extends ZipArchive {

    public function addDir($location, $name) {
        $this->addEmptyDir($name);

        $this->addDirDo($location, $name);
     } // EO addDir;

    private function addDirDo($location, $name) {
        $name .= '/';
        $location .= '/';

        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;

            // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } // EO addDirDo();
}
function zipFiles($the_folder,$zip_file_name,$ndir){
	chdir($ndir);
	$za = new FlxZipArchive;
	$res = $za->open($zip_file_name, ZipArchive::CREATE);
	if($res === TRUE){
		$za->addDir($the_folder, basename($the_folder));
		$za->close();
		return '<span class="good">O</span>';
	}
	else{
		return 'Could not create a zip archive';
	}	
}

//zip cpt 
if(isset($_POST['cptzip']) && $_POST['cptzip'] !=''){
	$dir = $_POST['cptzip'];
	$rpath = $path. DS .$ztd. DS .$dir;
	$fname = $dir.'.zip';
	$chdir = $path. DS .$ztd;
	
	if(is_dir($rpath)){
		echo zipFiles($rpath,$fname,$chdir);
	}else{
		echo '<span class="bad">X</span>'.$dir.' must be created first.';
	}
}
//zip posts
if(isset($_POST['pzip']) && $_POST['pzip'] !=''){
	$post_type = get_post_type($_POST['pzip']);
	$post = get_post($_POST['pzip']);
	
	$rpath = $path. DS .$ztd. DS .$post_type. DS . $post->post_name;
	
	$fname = $post->post_name.'.zip';
	$chdir = $path. DS .$ztd;
	
	if(is_dir($rpath)){
		echo zipFiles($rpath,$fname,$chdir);
	}else{
		echo '<span class="bad">X</span>'.$post_type.' > '.$post->post_name.' must be created first.';
	}	
}

//mkdirs
if(isset($_POST['cptmkdir']) && $_POST['cptmkdir'] !=''){
	global $wpdb;
	$posttype = $_POST['cptmkdir'];
	$args = array(
			'post_type' => $posttype,
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => -1
			);

	
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
		$q = "SELECT `ID` FROM wp_posts WHERE post_parent=".get_the_ID()." AND post_type = 'attachment'";	
		$r = $wpdb->get_results($q, OBJECT );
		$post_type = get_post_type($id);
		
		$post = get_post(get_the_ID());
			
		shell_exec('mkdir '.$path. DS .$ztd. DS .$post_type);
		if(is_dir($path. DS .$ztd. DS .$post_type)){
			shell_exec('mkdir '.$path. DS .$ztd. DS .$post_type. DS. $post->post_name);
			if(is_dir($path. DS .$ztd. DS .$post_type. DS. $post->post_name)){
				foreach($r as $k=>$v){
					$obj = get_post_meta($v->ID);
					if($obj['_wp_attached_file'][0]){
						$bp = pathinfo($obj['_wp_attached_file'][0]);
						
						$curr = realpath($path.DS.$obj['_wp_attached_file'][0]);
						$mvto = $path. DS .$ztd. DS .$post_type. DS .$post->post_name. DS .$bp['basename'];
						if(file_exists($curr)){
							copy($curr,$mvto);
						}
					}
				}
			}
		}
	wp_reset_postdata();
	endwhile;
	echo '<span class="good">O</span>';
}
//get attached files withing posts
if(isset($_POST['pmkdir']) && $_POST['pmkdir'] !=''){	
	$id = $_POST['pmkdir'];
	$q = "SELECT `ID` FROM wp_posts WHERE post_parent=".$id." AND post_type = 'attachment'";	
	$r = $wpdb->get_results($q, OBJECT );
	$post_type = get_post_type($id);	
	$post = get_post($id);

	shell_exec('mkdir '.$path. DS .$ztd. DS .$post_type);
	if(is_dir($path. DS .$ztd. DS .$post_type)){
		shell_exec('mkdir '.$path. DS .$ztd. DS .$post_type. DS. $post->post_name);
		if(is_dir($path. DS .$ztd. DS .$post_type. DS. $post->post_name)){
			foreach($r as $k=>$v){
				$obj = get_post_meta($v->ID);
				if($obj['_wp_attached_file'][0]){
					$bp = pathinfo($obj['_wp_attached_file'][0]);
					
					$curr = realpath($path.DS.$obj['_wp_attached_file'][0]);
					$mvto = $path. DS .$ztd. DS .$post_type. DS .$post->post_name. DS .$bp['basename'];
				
					copy($curr,$mvto);
				}
			}
		}
	}
	echo '<span class="good">O</span>';
}
?>
</ul>