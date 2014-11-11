<?php
	namespace Perseids\Tests\IAM\BSP;

	use Perseids\IAM\BSP\Instance;
	use Perseids\IAM\BSP\Person;
	use Perseids\IAM\IdP\IdentityProvider;

	class InstanceTest extends \PHPUnit_Framework_TestCase {
		protected $BSP;
		protected $AppPerson;
		protected $IdP;


		protected function setUp() {
			$this->IdP = new IdentityProvider("http://lascivaroma.com");

			$this->AppPerson = new Person();
			$this->AppPerson
				->setId("urn:uuid:ae4d52d2-d926-48a2-b01f-3e632e3d456d")
				->setIdentityProvider($this->IdP);

			$this->BSP = new Instance("https://services-rep.perseids.org/bsp/");

			$this->BSP
				->setBambooPerson($this->AppPerson)
				->setBambooAppId("urn:uuid:ae4d52d2-d926-48a2-b01f-3e632e3d456d");
		}

		public function testOverrideOptions() {
			$testURL1 = "http://localhost";

			$this->assertEquals("https://services-rep.perseids.org/bsp/", $this->BSP->getUrl());
			//Should be default url
			
			$this->BSP->setUrl($testURL1);
			
			//Should have changed
			$this->assertEquals($testURL1, $this->BSP->getUrl());
		}

		public function testPost() {
			$randomHash = hash('sha256', microtime());
			$testPerson = new Person();
			$testPerson->setId($randomHash);
			$testPerson->setIdentityProvider($this->IdP);
			$testPerson->create($this->BSP);

		}
	}
?>