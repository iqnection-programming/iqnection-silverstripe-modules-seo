

jQuery("#Form_EditForm_MetaTitle,#Form_EditForm_MetaDescription,#Form_EditForm_MetaKeywords").live('load click keyup',function(){
	var input=jQuery(this);
	if (!jQuery(this).parents('div.field').first().find('label > span').length){
		jQuery(this).parents('div.field').first().find('label').append('<span class="field_count"></span>');
	}
	jQuery(this).parents('div.field').first().find('label > span').text(input.val().length);
});

