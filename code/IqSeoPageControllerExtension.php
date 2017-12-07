<?php

use SilverStripe\ORM;
use SilverStripe\Core;
use SilverStripe\Control;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

class IqSeoPageControllerExtension extends Core\Extension 
{
	public function onAfterInit() 
	{
		/*
		 * Custom handler to redirect invalid url's to the home page, so we never have a 404 error
		 * will first check if there is already a redirect provided for a specific page
		 */
		if ($this->owner->ErrorCode == 404)
		{
			$RedirectPage = $this->Find404RedirectPage();
			$response = new Control\HTTPResponse_Exception();
			$response->getResponse()->redirect($RedirectPage?$RedirectPage->Link():"/", 301);
			throw $response;
		}
		if ($gaScript = SiteConfig::current_site_config()->GoogleAnalyticsScript())
		{
			Requirements::insertHeadtags($gaScript);
		}
	}
	
	public function Find404RedirectPage()
	{
		$URL_Full = $_SERVER['REQUEST_URI'];
		$URL_Parts = explode("?",$URL_Full);
		$URL_Path = $URL_Parts[0];
		// see fi there is a page with this URL as the redirect
		$Filters = "URLRedirects LIKE '%".$URL_Full."%' OR URLRedirects LIKE '%".$URL_Path."%'";
		$Results = ORM\DataList::create('Page')->where($Filters);
		$FoundPage = false;
		if ($Results->Count())
		{
			if ($Results->Count() == 1)
			{
				$FoundPage = $Results->First(); 
			}
			else
			{
				foreach($Results as $Page)
				{
					// since our query used a wild card, check if we have a direct match to any page, return the first found
					$RedirectURLs = explode("\n",$Page->URLRedirects);
					if (in_array($URL_Full,$RedirectURLs) || in_array($URL_Path,$RedirectURLs))
					{
						$FoundPage = $Page;
						break;
					}
				}
			}
		}
		$FoundPage = $this->owner->extend('update404RedirectPage',$FoundPage);
		$FoundPage = end($FoundPage);
		$FoundPage = $this->owner->update404RedirectPage($FoundPage);
		return $FoundPage;
	}
	
	public function update404RedirectPage($FoundPage)
	{
		return $FoundPage;
	}
}












