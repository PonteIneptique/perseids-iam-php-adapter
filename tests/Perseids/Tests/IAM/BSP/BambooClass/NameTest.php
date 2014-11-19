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

		public function testDeepXml() {
			$name = new Name();
			$partname = array();

			$partname[0] = new PartName();
			$partname[0]->setPartName("Test");
			$partname[0]->setPartNameLang("French");

			$name->setPartName($partname);

			$expected = array("familyName" => "Doe", "givenName" => "John");
			$this->assertEquals($expected, $name->getSerialized());
		}
	}