<?php

	class SiteConfig_GoogleAnalytics extends DataExtension {
	
		private static $db = array(
			'GoogleTrackingUniversal' => 'Varchar(32)',
			'GoogleTrackingOld' => 'Varchar(32)',
		);
	
		public function updateCMSFields(FieldList $fields) {
			$fields->addFieldToTab("Root.GoogleAnalytics", new TextField("GoogleTrackingUniversal", "Google Analytics ID (Universal Code)"));
			$fields->addFieldToTab("Root.GoogleAnalytics", new TextField("GoogleTrackingOld", "Google Analytics ID (Old Code)"));
		}
	}