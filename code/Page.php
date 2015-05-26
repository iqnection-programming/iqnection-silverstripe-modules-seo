<?php
	
	class IQSEO_Page extends Extension{				
		
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
		
		public function updateCMSFields(FieldList $fields)
		{
			$fields->addFieldToTab('Root.Main.Metadata', $keywordsField = new TextareaField('MetaKeywords','Meta Keywords'),"ExtraMeta" );
			$fields->addFieldToTab('Root.Main.Metadata', new TextField('MetaTitle','Meta Title'),'MetaDescription' );
			foreach(array('MetaTitle','MetaDescription','MetaKeywords') as $MetaFieldName)
			{
				$oldField = $fields->dataFieldByName($MetaFieldName);
				$oldField->setTitle($oldField->Title().'<span class="field_count">'.strlen($this->owner->$MetaFieldName).'</span>');
			}
			
			$keywordsField->setRows(1);
				
			if( permission::check('ADMIN') )
			{				
				$fields->addFieldToTab("Root.Main", new CheckboxField("NoFollow", "Set nav link to no-follow?"),"MetaDescription");
				$fields->addFieldToTab('Root.Main.Metadata', new TextareaField('URLRedirects','301 Redirects') );
			}
			
			return $fields;
		}
		
		public function NavNoFollow()
		{
			return $this->owner->NoFollow ? "rel='nofollow'" : "";	
		}
		
		public function hook_onBeforeWrite($owner)
		{
			if ($URLRedirects = $owner->URLRedirects)
			{
				$RedirectURLs = explode("\n",$URLRedirects);
				$NewRedirectURLs = array();
				foreach($RedirectURLs as $RedirectURL)
				{
					$NewRedirectURL = preg_replace("#".addslashes(Director::absoluteBaseURL())."#","",$RedirectURL);
					// make sure there's a slash at the begining
					if (substr($NewRedirectURL,0,1) != "/") $NewRedirectURL = "/".$NewRedirectURL;
					str_replace("//","/",$NewRedirectURL);
					$NewRedirectURLs[] = $NewRedirectURL;
				}
				$owner->URLRedirects = implode("\n",$NewRedirectURLs);
			}
		}
	}
	
	class IQSEO_Page_Controller extends Extension {
		
		public function onAfterInit() 
		{
			/*
			 * Custom handler to redirect invalid url's to the home page, so we never have a 404 error
			 * will first check if there is already a redirect provided for a specific page
			 */
			if ($this->owner->ErrorCode == 404)
			{
				$RedirectPage = $this->FindRedirectPage();
				$response = new SS_HTTPResponse_Exception();
				$response->getResponse()->redirect($RedirectPage?$RedirectPage->Link():"/", 301);
				throw $response;
			}
		}
		
		function FindRedirectPage()
		{
			$URL_Full = $_SERVER['REQUEST_URI'];
			$URL_Parts = explode("?",$URL_Full);
			$URL_Path = $URL_Parts[0];
			// see fi there is a page with this URL as the redirect
			$Filters = "URLRedirects LIKE '%".$URL_Full."%' OR URLRedirects LIKE '%".$URL_Path."%'";
			$Results = DataList::create('Page')->where($Filters);
			if ($Results->Count())
			{
				if ($Results->Count() == 1) return $Results->First();
				foreach($Results as $Page)
				{
					// since our query used a wild card, check if we have a direct match to any page, return the first found
					$RedirectURLs = explode("\n",$Page->URLRedirects);
					if (in_array($URL_Full,$RedirectURLs) || in_array($URL_Path,$RedirectURLs)) return $Page;
				}
			}
		}		
	}