<?php

use SilverStripe\Forms;
use SilverStripe\ORM;

class IqSeoSiteConfigExtension extends ORM\DataExtension 
{
	private static $db = array(
		'AdditionalHeaderCode' => 'Text',
		'AdditionalFooterCode' => 'Text',
		'GoogleTrackingUniversal' => 'Varchar(32)',
	);

	public function updateCMSFields(Forms\FieldList $fields) 
	{
		$fields->addFieldToTab("Root.GoogleAnalytics", Forms\TextField::create("GoogleTrackingUniversal", "Google Analytics ID (Universal Code)"));
		
		$tab = $fields->findOrMakeTab('Root.Developer.AdditionalCode');
		$tab->push( Forms\TextareaField::create('AdditionalHeaderCode','Additional Header JS/CSS Code',50)
			->addExtraClass('stacked')
			->setRows(30)
//			->setMode('html')
		);
		$tab->push( Forms\TextareaField::create('AdditionalFooterCode','Additional Footer JS/CSS Code',50)
			->addExtraClass('stacked')
			->setRows(30)
//			->setMode('html')
		);
	}
	
	public function GoogleAnalyticsScript()
	{
		if ($this->owner->GoogleTrackingUniversal)
		{
			return $this->owner->renderWith('GoogleAnalytics');
		}
	}
}