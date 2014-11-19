<?php
	namespace Perseids\Tests\IAM\BSP\BambooClass;

	use Perseids\IAM\BSP\BambooClass\Name;
	use Perseids\IAM\BSP\BambooClass\PartName;

	class NameTest extends \PHPUnit_Framework_TestCase {
		
		public function testXML() {
			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");
			$expected = "<contacts:name>\n<contacts:familyName>Doe</contacts:familyName>\n<contacts:givenName>John</contacts:givenName>\n\n</contacts:name>";
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
			$partname[0]->setPartName("Test");
			$partname[0]->setPartNameLang("French");

			$partname[1] = new PartName();
			$partname[1]->setPartName("Louie");
			$partname[1]->setPartNameLang("English");

			$name->setPartName($partname);
			$expected = array(
				"familyName" => "Doe", 
				"givenName" => "John", 
				"partName" => array(
					0 => array(
						"partName" => "Test", 
						"partNameLang" => "French"
					),
					1 => array(
						"partName" => "Louie", 
						"partNameLang" => "English"
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
			$partname[0]->setPartName("Test");
			$partname[0]->setPartNameLang("French");

			$partname[1] = new PartName();
			$partname[1]->setPartName("Louie");
			$partname[1]->setPartNameLang("English");

			$name->setPartName($partname);
			print_r($name->getXML());
			//$this->assertEquals($expected, $name->getXML());
		}
	}