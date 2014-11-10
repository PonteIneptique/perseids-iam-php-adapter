<?php
	namespace Perseids\Tests\IAM\BSP;

	use Perseids\IAM\BSP\Identity;
	use Perseids\IAM\IdP\IdentityProvider;

	class IdentityTest extends \PHPUnit_Framework_TestCase {
		protected $IdP;

		protected function setUp() {
			$this->IdP = new IdentityProvider("http://localhost/IdP");
		}

		public function testXmlCreateIdentity() {
			$userId = 1;
			$identity = new Identity($this->IdP, $userId);

			print $identity->create();
		}
	}
?>