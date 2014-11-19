<?php
	namespace Perseids\Tests\IAM\BSP\BambooClass;

	use Perseids\IAM\BSP\BambooClass\Telephone;

	class TelephoneTest extends \PHPUnit_Framework_TestCase {
		public function testXML() {
			$tel = new Telephone();
			$tel
				->setTelephoneNumber("123")
				->setTelephoneType("FAX");
			$expected = "<contacts:telephone>\n<contacts:telephoneNumber>123</contacts:telephoneNumber>\n<contacts:telephoneType>FAX</contacts:telephoneType>\n</contacts:telephone>";
			$this->assertEquals($expected, $tel->getXML());
		}
		public function testSerialized() {
			$tel = new Telephone();
			$tel->setTelephoneNumber("123")
				->setTelephoneType("FAX");
			$expected = array("telephoneNumber" => "123", "telephoneType" => "FAX");
			$this->assertEquals($expected, $tel->getSerialized());
		}
	}