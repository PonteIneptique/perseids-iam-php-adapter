<?php
	namespace Perseids\Tests\IAM\Property;

	use Perseids\IAM\Property\IM;

	class IMTest extends \PHPUnit_Framework_TestCase {
		
		public function testXML() {
			$IM = new IM();
			$IM->setInstantMessagingType("SKYPE")
				 ->setAccount("johndoe")
				 ->setLocationType("WORK");
			$expected = "<contacts:iMs>\n<contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>\n<contacts:account>johndoe</contacts:account>\n<contacts:locationType>WORK</contacts:locationType>\n</contacts:iMs>";
			$this->assertEquals($expected, $IM->getXML());
		}

		public function testDefaultOverrideEnum() {
			$IM = new IM();
			$IM  ->setInstantMessagingType("YABOOK")
				 ->setAccount("johndoe")
				 ->setLocationType("WORK");
			$expected = "<contacts:iMs>\n<contacts:instantMessagingType>YABOOK</contacts:instantMessagingType>\n<contacts:account>johndoe</contacts:account>\n<contacts:locationType>WORK</contacts:locationType>\n</contacts:iMs>";
			$this->assertNotEquals($expected, $IM->getXML());
		}
	}