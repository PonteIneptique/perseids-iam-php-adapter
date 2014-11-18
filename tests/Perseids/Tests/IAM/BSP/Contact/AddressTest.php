<?php
	namespace Perseids\Tests\IAM\BSP\Contact;

	use Perseids\IAM\BSP\Contact\Address;

	class AddressTest extends \PHPUnit_Framework_TestCase {
		public function testXML() {
			$address = new Address();
			$address->setCountry("France");
			$expected = "<contacts:addresses>\n<contacts:country>France</contacts:country>\n\n</contacts:addresses>";
			$this->assertEquals($expected, $address->getXML());
		}
		public function testSerialized() {
			$address = new Address();
			$address->setCountry("France");
			$expected = array("country" => "France");
			$this->assertEquals($expected, $address->getSerialized());
		}
	}