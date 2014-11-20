<?php
	namespace Perseids\Tests\IAM\Property;

	use Perseids\IAM\Property\IdentityProvider;

	class IdentityProviderTest extends \PHPUnit_Framework_TestCase {
		public function testOverrideOptions() {
			$testURL1 = "http://localhost";
			$testURL2 = "http://127.0.0.1";
			$IdP = new IdentityProvider($testURL1, "Localhost", "User-ID");

			$this->assertEquals($testURL1, $IdP->getSourcedIdKey()->getIdPId());
			//Should be default url
			
			$IdP->getSourcedIdKey()->setIdPId($testURL2);
			
			//Should have changed
			$this->assertEquals($testURL2, $IdP->getSourcedIdKey()->getIdPId());

		}
	}
?>