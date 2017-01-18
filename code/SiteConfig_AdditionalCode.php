<?php

class SiteConfig_AdditionalCode extends DataExtension 
{
	private static $db = array(
		'AdditionalHeaderCode' => 'Text',
		'AdditionalFooterCode' => 'Text',
	);

	public function updateCMSFields(FieldList $fields) 
	{
		if( permission::check('ADMIN') )
		{
			$fields->addFieldToTab('Root.AdditionalCode', CodeEditorField::create('AdditionalHeaderCode','Additional Header JS/CSS Code',50)
				->addExtraClass('stacked')
				->setRows(30)
				->setMode('html')
			);
			$fields->addFieldToTab('Root.AdditionalCode', CodeEditorField::create('AdditionalFooterCode','Additional Footer JS/CSS Code',50)
				->addExtraClass('stacked')
				->setRows(30)
				->setMode('html')
			);
		}
	}
}