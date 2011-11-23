<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class PremiumGoogleMapPackage extends Package {

	protected $pkgHandle = 'premium_google_map';
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '2.0.1';
	
	public function getPackageDescription() {
		return t("The premium Google Map lets you add a KML data file and specify additional parameters unavailable in the regular Google Map block.");
	}
	
	public function getPackageName() {
		return t("Google Map (Premium)");
	}
	
	public function install() {
		$pkg = parent::install();
		// install block		
		BlockType::installBlockTypeFromPackage('premium_google_map', $pkg);		
	}

}