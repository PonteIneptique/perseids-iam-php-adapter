<?php

	namespace Perseids\Tests\IAM\Entity;

	use Perseids\IAM\Entity\Contact;
	use Perseids\IAM\Entity\Person;


	use Perseids\IAM\BSP\Instance;


	use Perseids\IAM\Property\Name;
	use Perseids\IAM\Property\PartName;
	use Perseids\IAM\Property\IM;
	use Perseids\IAM\Property\Address;
	use Perseids\IAM\Property\Telephone;

	class ContactTest extends \PHPUnit_Framework_TestCase {
		protected function setUp() {

			$this->AppPerson = new Person();
			$this->AppPerson
				->setId("urn:uuid:b86d2c75-940c-4575-9475-8c31dc25609e");

			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");

			$partname = array();
				$partname[0] = new PartName();
				$partname[0]->setPartName("Louie");
				$partname[0]->setPartNameLang("English");
			$name->setPartName($partname);

			$address = new Address();
			$address->setCountry("France");

			$IM = new IM();
			$IM->setInstantMessagingType("SKYPE")
				 ->setAccount("johndoe")
				 ->setLocationType("WORK");

			$tel = new Telephone();
			$tel
				->setTelephoneNumber("123")
				->setTelephoneType("FAX");

			$this->contact = new Contact();
			$this->contact
				->setName($name)
				->setDisplayName("JohnDoe123")
				->setEmail(array("johndoe@aoldied.com"))
				->setIMs(array($IM))
				->setTelephone(array($tel));
		}
		public function testXML() {
			$expected = "<contacts:bambooContact>\n<contacts:name>\n<contacts:familyName>Doe</contacts:familyName>\n<contacts:givenName>John</contacts:givenName>\n<contacts:partName>\n<contacts:partName>Louie</contacts:partName>\n<contacts:partNameLang>English</contacts:partNameLang>\n</contacts:partName>\n</contacts:name>\n<contacts:displayName>JohnDoe123</contacts:displayName>\n<contacts:email>johndoe@aoldied.com</contacts:email>\n<contacts:iMs>\n<contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>\n<contacts:account>johndoe</contacts:account>\n<contacts:locationType>WORK</contacts:locationType>\n</contacts:iMs>\n<contacts:telephone>\n<contacts:telephoneNumber>123</contacts:telephoneNumber>\n<contacts:telephoneType>FAX</contacts:telephoneType>\n</contacts:telephone>\n</contacts:bambooContact>";
			$xml = $this->contact->getXML();
			$this->assertEquals($expected, $xml);
		}

		public function testSerialize() {
			$expected = array(
				"name" => array(
					"familyName" => "Doe",
					"givenName" => "John",
					"partName" => array(
						0 => array(
							"partName" => "Louie",
							"partNameLang" => "English"
						)
					)
				),
				"displayName" => "JohnDoe123",
				"email" => array(
					0 => "johndoe@aoldied.com"
				),
				"IMs" => array(
					0 => array(
						"instantMessagingType" => "SKYPE",
						"account" => "johndoe",
						"locationType" => "WORK"
					)
				),
				"telephone" => array(
					0 => array(
						"telephoneNumber" => "123",
						"telephoneType" => "FAX",
					)
				)
				);
			$array = $this->contact->getSerialized();
			$this->assertEquals($expected, $array);
		}

		public function testCreate() {
			$this->BSP = new Instance("https://services-rep.perseids.org/bsp");

			$this->BSP
				->setBambooPerson($this->AppPerson)
				->setBambooAppId("urn:uuid:ae4d52d2-d926-48a2-b01f-3e632e3d456d")
				->setVerify(false)
				->setCertificate(__DIR__ . "/../../../../../certificate/file.pem");

			//$this->contact->create($this->BSP);
			//print_r($this->contact->getUUID());
		}
	}