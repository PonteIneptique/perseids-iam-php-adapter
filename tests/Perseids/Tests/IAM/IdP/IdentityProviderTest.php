<?php
	namespace Perseids\Tests\IAM\IdP;

	use Perseids\IAM\IdP\IdentityProvider;

	class IdentityProviderTest extends \PHPUnit_Framework_TestCase {
		public function testOverrideOptions() {
			$testURL1 = "http://localhost";
			$testURL2 = "http://127.0.0.1";
			$IdP = new IdentityProvider($testURL1, "Localhost");

			$this->assertEquals($testURL1, $IdP->getUrl());
			//Should be default url
			
			$IdP->setUrl($testURL2);
			
			//Should have changed
			$this->assertEquals($testURL2, $IdP->getUrl());

		}
	}
?>