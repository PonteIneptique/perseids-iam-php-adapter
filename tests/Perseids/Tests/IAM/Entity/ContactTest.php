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
				$partname[0]->setPartName("Louie")
							->setPartNameLang("English")
							->setPartNameType("HONORIFIC_PREFIX");
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
			$expected = "
<contacts:bambooContact xmlns:xs=\"http://www.w3.org/2001/XMLSchema\" xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\">
	<contacts:name>
		<contacts:familyName>Doe</contacts:familyName>
		<contacts:givenName>John</contacts:givenName>
		<contacts:partName>
			<contacts:partName>Louie</contacts:partName>
			<contacts:partNameType>HONORIFIC_PREFIX</contacts:partNameType>
			<contacts:partNameLang>English</contacts:partNameLang>
		</contacts:partName>
	</contacts:name>
	<contacts:displayName>JohnDoe123</contacts:displayName>
	<contacts:email>johndoe@aoldied.com</contacts:email>
	<contacts:iMs>
		<contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>
		<contacts:account>johndoe</contacts:account>
		<contacts:locationType>WORK</contacts:locationType>
	</contacts:iMs>
	<contacts:telephone>
		<contacts:telephoneNumber>123</contacts:telephoneNumber>
		<contacts:telephoneType>FAX</contacts:telephoneType>
	</contacts:telephone>
</contacts:bambooContact>
";
			$xml = $this->contact->getXML($attributes = true);
			$this->assertXmlStringEqualsXmlString($expected, $xml);
		}

		public function testSerialize() {
			$expected = array(
				"name" => array(
					"familyName" => "Doe",
					"givenName" => "John",
					"partName" => array(
						0 => array(
							"partName" => "Louie",
							"partNameLang" => "English",
							"partNameType" => "HONORIFIC_PREFIX"
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