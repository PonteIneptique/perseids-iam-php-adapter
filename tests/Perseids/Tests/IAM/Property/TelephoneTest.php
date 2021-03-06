<?php
	namespace Perseids\Tests\IAM\Property;

	use Perseids\IAM\Property\Telephone;
	use Perseids\IAM\Exceptions\RequiredFieldException;

	class TelephoneTest extends \PHPUnit_Framework_TestCase {
		public function testXML() {
			$tel = new Telephone();
			$tel
				->setTelephoneNumber("123")
				->setTelephoneType("FAX");
			$expected = "<contacts:telephones>\n<contacts:telephoneNumber>123</contacts:telephoneNumber>\n<contacts:telephoneType>FAX</contacts:telephoneType>\n</contacts:telephones>";
			$this->assertEquals($expected, $tel->getXML());
		}
		public function testSerialized() {
			$tel = new Telephone();
			$tel->setTelephoneNumber("123")
				->setTelephoneType("FAX");
			$expected = array("telephoneNumber" => "123", "telephoneType" => "FAX");
			$this->assertEquals($expected, $tel->getSerialized());
		}

		public function testRequiredTelephoneType() {

        	$this->setExpectedException('Perseids\IAM\Exceptions\RequiredFieldException');
			$tel = new Telephone();
			$tel
				->setTelephoneNumber("123");
			$tel->getSerialized();
			$expected = "<contacts:telephones>\n<contacts:telephoneNumber>123</contacts:telephoneNumber>\n<contacts:telephoneType>FAX</contacts:telephoneType>\n</contacts:telephones>";
		}

		public function testRequiredWorksWithXML() {

        	$this->setExpectedException('Perseids\IAM\Exceptions\RequiredFieldException');
			$tel = new Telephone();
			$tel
				->setTelephoneNumber("123");
			$tel->getXML();
			$expected = "<contacts:telephones>\n<contacts:telephoneNumber>123</contacts:telephoneNumber>\n<contacts:telephoneType>FAX</contacts:telephoneType>\n</contacts:telephones>";
		}
	}