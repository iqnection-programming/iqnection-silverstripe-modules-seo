<?php

namespace IQnection\SEO\SiteConfig;

use SilverStripe\Forms;
use SilverStripe\ORM;

class SiteConfigExtension extends ORM\DataExtension 
{
	private static $db = array(
		'AdditionalHeaderCode' => 'Text',
		'AdditionalFooterCode' => 'Text',
		'GoogleTrackingUniversal' => 'Varchar(32)',
		'GoogleTagManagerHeadCode' => 'Text',
		'GoogleTagManagerBodyCode' => 'Text',
	);

	public function updateCMSFields(Forms\FieldList $fields) 
	{
		$fields->addFieldToTab("Root.GoogleAnalytics", Forms\TextField::create("GoogleTrackingUniversal", "Google Analytics ID (Universal Code)"));
		$fields->addFieldToTab("Root.GoogleAnalytics", Forms\LiteralField::create('gtm-note','<p>If Google Analytics is setup in your Google Tag Manager account, do NOT enter your analytics account number</p>') );
		$fields->addFieldToTab("Root.GoogleAnalytics", Forms\TextareaField::create('GoogleTagManagerHeadCode','Tag Manager head Code')
			->addExtraClass('stacked monotype')
			->setRows(5));
		$fields->addFieldToTab("Root.GoogleAnalytics", Forms\TextareaField::create('GoogleTagManagerBodyCode','Tag Manager body Code')
			->addExtraClass('stacked monotype')
			->setRows(5));
			
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
	
	public function updateGeneratedTemplateCache($cache)
	{
		$cache['AdditionalHeaderCode'] = $this->owner->AdditionalHeaderCode;
		$cache['AdditionalFooterCode'] = $this->owner->AdditionalFooterCode;
		return $cache;
	}
}