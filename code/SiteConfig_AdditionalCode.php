<?php

class SiteConfig_AdditionalCode extends DataExtension 
{
	private static $db = array(
		'AdditionalHeaderCode' => 'Text',
		'AdditionalFooterCode' => 'Text',
	);

	public function updateCMSFields(FieldList $fields) 
	{
		$tab = $fields->findOrMakeTab('Root.Developer.AdditionalCode');
		$tab->push(CodeEditorField::create('AdditionalHeaderCode','Additional Header JS/CSS Code',50)
			->addExtraClass('stacked')
			->setRows(30)
			->setMode('html')
		);
		$tab->push(CodeEditorField::create('AdditionalFooterCode','Additional Footer JS/CSS Code',50)
			->addExtraClass('stacked')
			->setRows(30)
			->setMode('html')
		);
	}
}