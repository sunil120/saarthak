jQuery(document).ready(function($){
	
	$(".woocs_allcats").change(function(){
		var catid = $(this).val();
		
		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/catid=\"\d+\"/g, 'catid="'+catid+'"');
		phpval = phpval.replace(/catid=\"\d+\"/g, 'catid="'+catid+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);	
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);	
		
	})
	
	$(".woocs_pager").change(function(){
		var pager = $(this).is(':checked') ? 1 : 0;
		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/pager=\"(0|1)\"/g, 'pager="'+pager+'"');
		phpval = phpval.replace(/pager=\"(0|1)\"/g, 'pager="'+pager+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);	
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);	
	})
	
	$(".woocs_controls").change(function(){
		var controls = $(this).is(':checked') ? 1 : 0;
		
		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
				
		val = val.replace(/controls=\"(0|1)\"/g, 'controls="'+controls+'"');
		phpval = phpval.replace(/controls=\"(0|1)\"/g, 'controls="'+controls+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);	
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);	
	})
	
	$(".woocs_autoslide").change(function(){
		var autoslide = $(this).is(':checked') ? 1 : 0;
		
		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/autoslide=\"(0|1)\"/g, 'autoslide="'+autoslide+'"');
		phpval = phpval.replace(/autoslide=\"(0|1)\"/g, 'autoslide="'+autoslide+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);
	})
	
	
	$(".woocs_speed").change(function(){
		var speed = $(this).val();
		
		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/speed=\"\d+\"/g, 'speed="'+speed+'"');
		phpval = phpval.replace(/speed=\"\d+\"/g, 'speed="'+speed+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);
	})
	
	$(".woocs_numberofrows").change(function(){
		var numberofrows = $(this).val();

		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/numberofrows=\"\d+\"/g, 'numberofrows="'+numberofrows+'"');
		phpval = phpval.replace(/numberofrows=\"\d+\"/g, 'numberofrows="'+numberofrows+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);	
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);	
	})
	
	$(".woocs_length").change(function(){
		var title_length = $(this).val();

		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/title_length=\"\d+\"/g, 'title_length="'+title_length+'"');
		phpval = phpval.replace(/title_length=\"\d+\"/g, 'title_length="'+title_length+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);	
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);	
	})
	
	$(".woocs_description").change(function(){
		var description_length = $(this).val();

		var val = $(this).parent().parent().parent().find('.woocs_shortcode').val();
		var phpval = $(this).parent().parent().parent().find('.woocs_phpshortcode').val();
		
		val = val.replace(/description_length=\"\d+\"/g, 'description_length="'+description_length+'"');
		phpval = phpval.replace(/description_length=\"\d+\"/g, 'description_length="'+description_length+'"');
		
		$(this).parent().parent().parent().find('.woocs_shortcode').val(val);	
		$(this).parent().parent().parent().find('.woocs_phpshortcode').val(phpval);	
	})
	
	$(".woocs_shortcode, .woocs_phpshortcode").click(function(){
		$(this).select();
	})
	
	
})