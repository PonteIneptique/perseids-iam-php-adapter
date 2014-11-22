<?php
	namespace Perseids\Tests\IAM\Property;

	use Perseids\IAM\Property\Name;
	use Perseids\IAM\Property\PartName;

	class NameTest extends \PHPUnit_Framework_TestCase {
		
		public function testXML() {
			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");
			$expected = "<contacts:name>\n<contacts:familyName>Doe</contacts:familyName>\n<contacts:givenName>John</contacts:givenName>\n</contacts:name>";
			$this->assertEquals($expected, $name->getXML());
		}

		public function testSerialized() {
			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");
			$expected = array("familyName" => "Doe", "givenName" => "John");
			$this->assertEquals($expected, $name->getSerialized());
		}

		public function testDeepSerialzing() {
			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");
			$partname = array();

			$partname[0] = new PartName();
			$partname[0]->setPartNameContent("Test");
			$partname[0]->setPartNameType("HONORIFIC_PREFIX");

			$partname[1] = new PartName();
			$partname[1]->setPartNameContent("Louie");
			$partname[1]->setPartNameType("NAME_GIVEN");

			$name->setPartNames($partname);
			$expected = array(
				"familyName" => "Doe", 
				"givenName" => "John", 
				"partNames" => array(
					0 => array(
						"partNameContent" => "Test", 
						"partNameType" => "HONORIFIC_PREFIX"
					),
					1 => array(
						"partNameContent" => "Louie", 
						"partNameType" => "NAME_GIVEN"
					)
				)
			);
			$this->assertEquals($expected, $name->getSerialized());
		}

		public function testDeepXML() {
			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");
			$partname = array();

			$partname[0] = new PartName();
			$partname[0]->setPartNameContent("Test");
			$partname[0]->setPartNameType("HONORIFIC_PREFIX");

			$partname[1] = new PartName();
			$partname[1]->setPartNameContent("Louie");
			$partname[1]->setPartNameType("NAME_GIVEN");

			$name->setPartNames($partname);
			$expected = "<contacts:name>\n<contacts:familyName>Doe</contacts:familyName>\n<contacts:givenName>John</contacts:givenName>\n<contacts:partNames>\n<contacts:partNameContent>Test</contacts:partNameContent>\n<contacts:partNameType>HONORIFIC_PREFIX</contacts:partNameType>\n</contacts:partNames>\n<contacts:partNames>\n<contacts:partNameContent>Louie</contacts:partNameContent>\n<contacts:partNameType>NAME_GIVEN</contacts:partNameType>\n</contacts:partNames>\n</contacts:name>";
			$this->assertEquals($expected, $name->getXML());
		}
	}