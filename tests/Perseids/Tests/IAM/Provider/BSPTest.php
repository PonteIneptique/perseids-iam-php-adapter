<?php
	namespace Perseids\Tests\IAM\Provider;

	use Perseids\IAM\Provider\BSP;

	class BSPTest extends \PHPUnit_Framework_TestCase {
		protected $BSP;

		protected function setUp() {
			$this->BSP = new BSP();
		}

		public function testOverrideOptions() {
			$testURL1 = "http://localhost";

			$this->assertEquals("http://services-rep.perseids.org/bsp", $this->BSP->getUrl());
			//Should be default url
			
			$this->BSP->setUrl($testURL1);
			
			//Should have changed
			$this->assertEquals($testURL1, $this->BSP->getUrl());

		}
	}
?>