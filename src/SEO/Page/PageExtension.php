<?php

namespace IQnection\SEO\Page;

use SilverStripe\Forms;
use SilverStripe\ORM;
use SilverStripe\Control;

class PageExtension extends ORM\DataExtension
{				
	private static $db = array(
		'MetaTitle' => 'Varchar(255)',
		"NoFollow" => "Boolean",
		'URLRedirects' => 'Text',
		'MetaKeywords' => 'Text'
	);	
	
	private static $has_one = array(
	);
	
	private static $defaults = array(
	);
	
	public function updateCMSFields(Forms\FieldList $fields)
	{
		$fields->addFieldToTab('Root.Main.Metadata', $keywordsField = Forms\TextareaField::create('MetaKeywords','Meta Keywords'),"ExtraMeta" );
		$fields->addFieldToTab('Root.Main.Metadata', Forms\TextField::create('MetaTitle','Meta Title'),'MetaDescription' );
		foreach(array('MetaTitle','MetaDescription','MetaKeywords') as $MetaFieldName)
		{
			$oldField = $fields->dataFieldByName($MetaFieldName);
			$oldField->setTitle($oldField->Title())->setDescription('<span class="field_count">'.strlen($this->owner->$MetaFieldName).'</span>');
		}
		
		$keywordsField->setRows(1);
			
		$fields->addFieldToTab("Root.Main", Forms\CheckboxField::create("NoFollow", "Set nav link to no-follow?"),"MetaDescription");
		$fields->addFieldToTab('Root.Main.Metadata', Forms\TextareaField::create('URLRedirects','301 Redirects')->setRightTitle('Enter only the old URL path that should be redirected to this page. For example /test-page.html') );
		
		return $fields;
	}
	
	public function NavNoFollow()
	{
		return $this->owner->NoFollow ? "rel='nofollow'" : "";	
	}
	
	public function onBeforeWrite()
	{
		if ($URLRedirects = $owner->URLRedirects)
		{
			$RedirectURLs = explode("\n",$URLRedirects);
			$NewRedirectURLs = array();
			foreach($RedirectURLs as $RedirectURL)
			{
				$NewRedirectURL = preg_replace("#".addslashes(Control\Director::absoluteBaseURL())."#","",$RedirectURL);
				// make sure there's a slash at the begining
				if (substr($NewRedirectURL,0,1) != "/") $NewRedirectURL = "/".$NewRedirectURL;
				str_replace("//","/",$NewRedirectURL);
				$NewRedirectURLs[] = $NewRedirectURL;
			}
			$owner->URLRedirects = implode("\n",$NewRedirectURLs);
		}
	}
}












