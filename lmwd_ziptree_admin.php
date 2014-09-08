<div class="wrap ziptree">
	<div class="legend">
		<span><span class="icon">F</span>- make folder</span>
		<span><span class="icon">Z</span>- zip folders</span>
		<span><span class="icon">d</span>- download zip file</span>
	</div>
	<div class="clear"></div>
<?php	
	if(realpath($uploads['basedir'].DS.$ztd)){
		if(is_writeable($path)){
			echo '<p><span class="good">O</span>ZipTree directory exists and has writeable permissions.</p>';
		}else{
			echo '<p><span class="bad">X</span>ZipTree directory is not writeable =[</p>';
		}
	}else{
		if(shell_exec('mkdir '.$path. DS .$ztd)){
			echo '<p>ZipTree is in '.$path.'</p>';
		}else{
			echo '<p>Cannot created ZipTree directory.</p>';
		}
	}
?>
		<span>Post Type: </span>
		<select name="cpt" id="cpt_sel">
			<option value="">Select</option>
			<option value="all">All</option>
<?php
	sort($cpts);
	foreach ($cpts as $cpt ){ echo '<option value="'.$cpt.'">'.$cpt.'</option>';}
?>
		</select>
		<span id="loading">loading...</span>
		<span class="response"></span>
	<div id="result"></div>	
</div>
	 

