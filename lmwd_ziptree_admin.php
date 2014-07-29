<script type="text/javascript">
	$(document).ready(function(){
		
		
		//LIST CPTS, POSTS, ATTACHED FILES
		$('#cpt_sel').change(function(){
			$('#loading').css({'opacity':'1'});
			
			var posttype = $(this).val();
			var get = {'cpt':posttype}
			
			getList('#result',get,'cpts');
		});
		
		$(document).on("click",".hide",function(){
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();
			
			switch(type){
				case 'cpt':
					$('#'+val+'-list > ul').html('');
				break;
				case 'post':
					$('#post-'+val+'> ul').html('');
				break;
			}
			$(this).text('+').removeClass('hide').addClass('list');
		});

		$(document).on("click",".list",function(){
			$(this).parent().append('<span class="tmp">...</span>');
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();
			console.log('clicked list: '+val);
			//if cpt or post call
			switch(type){
				case 'cpt':
					var get = {'posttype':val}
					var el = '#'+val+'-list';
				break;
				case 'post':
					var get = {'post':val}
					var el = '#post-'+val;
				break;
			}
			//send to function	
			getList(el,get,'replace');
			$(this).text('-').removeClass('list').addClass('hide');
		});
		
		function getList(e,vals,display){
			//send appropriate value based on variables
			$.ajax({
				type:'POST',
				url:'<?php echo plugins_url('lmwd-ziptree-lists.php', __FILE__); ?>',
				data: vals
			}).done(function(msg){
				$('#loading').css({'opacity':'0'});
				$('.tmp').remove();
				switch(display){
					case 'cpts':
						$(e).html(msg);
					break;
					case 'replace':
						$(e+'> ul').html(msg);
					break;
				}
			});
		}
		

		//MKDIR STUFF
		$(document).on("click",".mkdir",function(){
			
			$(this).parent().append('<span class="tmp">...creating directories</span>');
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();
			
			switch(type){
				case 'cpt':
					var vals = {'cptmkdir':val}
				break;
				case 'post':
					var vals = {'pmkdir':val}
				break;
			}
			mkDir(vals);	
		});
		
		function mkDir(data){
			$.ajax({
				type:'POST',
				url:'<?php echo plugins_url('lmwd-file-handler.php', __FILE__); ?>',
				data: data
			}).done(function(msg){
				$('.tmp').html(msg).fadeOut(5000,function(){
					$(this).remove()
				});
				//console.log(msg);
			});
		}
		
		//ZIPDIR STUFF
		$(document).on("click",".zipfiles",function(){
			$(this).parent().append('<span class="tmp">...zipping files</span>');
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();
			
			switch(type){
				case 'cpt':
					var vals = {'cptzip':val}
				break;
				case 'post':
					var vals = {'pzip':val}
				break;
			}
			zipFiles(vals);
		});
		
		function zipFiles(data){
			$.ajax({
				type:'POST',
				url:'<?php echo plugins_url('lmwd-file-handler.php', __FILE__); ?>',
				data: data
			}).done(function(msg){
				$('.tmp').html(msg).fadeOut(5000,function(){
					$(this).remove()
				});
				console.log(msg)
				//$('.response').html(msg);
			});
		}
		
		//Download .zip files
		$(document).on("click",".dwld",function(){
			$(this).parent().append('<span class="tmp">...</span>');
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();
			//console.log('clicked list: '+val);
			//if cpt or post call
			switch(type){
				case 'cpt':
					var get = {'cptdwld':val}
					var el = '#'+val+'-list';
				break;
				case 'post':
					var get = {'pdwld':val}
					var el = '#post-'+val;
				break;
			}
			//send to function	
			dwldFiles(get);
		});
		
		function dwldFiles(data){
			$.ajax({
				type:'POST',
				dataType:'JSON',
				url:'<?php echo plugins_url('lmwd-download.php', __FILE__); ?>',
				data: data
			}).done(function(msg){
				if(msg['msg']){
					$('.tmp').html(msg['msg']).fadeOut(5000,function(){
						$(this).remove()
					});
					console.log(msg['msg']);
				}else
				if(msg['dlink']){
					location.href = msg['dlink'];
					console.log(msg['dlink']);
					$('.tmp').remove()
				}
			});
		}
	});
</script>
<div class="wrap ziptree">
<?php
	require('lmwd-defines.php');
	
	if(realpath($uploads['basedir'].DS.$ztd)){
		if(is_writeable($path)){
			echo '<p>ZipTree directory exists and has writeable permissions.</p>';
		}else{
			echo '<p>ZipTree directory is not writeable =[</p>';
		}
	}else{
		if(shell_exec('mkdir '.$path. DS .$ztd)){
			echo '<p>ZipTree is in '.$path.'</p>';
		}else{
			echo '<p>Cannot created ZipTree directory.</p>';
		}
	}
	
?>
	<!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=ZipTree" method="POST" id="cpt-sel">-->
		<span>Post Type: </span>
		<select name="cpt" id="cpt_sel">
			<option value="all">All</option>
<?php
	sort($cpts);
	foreach ($cpts as $cpt ){ echo '<option value="'.$cpt.'">'.$cpt.'</option>';}
?>
		</select>
		<span id="loading">loading...</span>
		<span class="response"></span>
	<!--</form>-->
	<ul id="result"></ul>
</div>
	 

