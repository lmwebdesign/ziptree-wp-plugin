(function ($) {
$(document).ready(function(){
		var ztPage = document.URL;
	
		//LIST CPTS, POSTS, ATTACHED FILES
		$('#cpt_sel').change(function(){
			$('#loading').css({'opacity':'1'});
			
			var posttype = $(this).val();
			var get = {'cpt':posttype}
			
			getList('#result',get,'cpts');
			
		});
		
		//hide sub-lists
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

		//show sub-lists	
		$(document).on("click",".list",function(){
			$(this).parent().append('<span class="tmp">...</span>');
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();

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
		
		//ajax lists
		function getList(e,vals,display){
			//send appropriate value based on variables
			$.ajax({
				type:'POST',
				url: ztPage,
				data: vals
			}).done(function(msg){
				$('#loading').css({'opacity':'0'});
				$('.tmp').remove();
				
				var content = $(msg).find(".qlist");
				
				switch(display){
					case 'cpts':
						$(e).html(content.prevObject[0]);
					break;
					case 'replace':
						$(e+'> ul').html(content.prevObject[0]);
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
				url: ztPage,
				data: data
			}).done(function(msg){
				var content = $(msg).find(".qlist");
			
				$('.tmp').html(content.prevObject[0]).fadeOut(5000,function(){
					$(this).remove()
				});
			
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
				url: ztPage,
				data: data
			}).done(function(msg){
				var content = $(msg).find(".qlist");
				
				$('.tmp').html(content.prevObject[0]).fadeOut(5000,function(){
					$(this).remove()
				});

			});
		}
		
		//Download .zip files
		$(document).on("click",".dwld",function(){
			$(this).parent().append('<span class="tmp">...</span>');
			var type = $(this).attr('alt');
			var val = $(this).parent().children('.value').val();

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

		//ajax download link if available
		function dwldFiles(data){
			$.ajax({
				type:'POST',
				url: ztPage,
				data: data
			}).done(function(msg){
				var content = $(msg).find(".dlink");
				
				$('.tmp').html(content.prevObject[3]).fadeOut(5000,function(){
					$(this).remove();
				});
			});
		}
});
}(jQuery));