(function($){
	$("#Form_ItemEditForm_MetaTitle,#Form_ItemEditForm_MetaDescription,#Form_ItemEditForm_MetaKeywords,#Form_EditForm_MetaTitle,#Form_EditForm_MetaDescription,#Form_EditForm_MetaKeywords").live('load click keyup',function(){
		var input=$(this);
		if (!$(this).parents('div').first().find('span.field_count').length){
			$(this).parents('div').first().append('<p><span class="field_count"></span></p>');
		}
		$(this).parents('div').first().find('span.field_count').text(input.val().length);
	});
}(jQuery));
