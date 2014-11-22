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
	use Perseids\IAM\Property\Email;

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
				$partname[0]->setPartNameContent("Louie")
							->setPartNameLang("English")
							->setPartNameType("HONORIFIC_PREFIX");
			$name->setPartNames($partname);

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

			$email = new Email();
			$email->setEmail("johndoe@aoldied.com");

			$this->contact = new Contact();
			$this->contact
				->setName($name)
				->setDisplayName("JohnDoe123")
				->setEmails(array($email))
				->setIMs(array($IM))
				->setTelephones(array($tel));
		}
		public function testXML() {
			$expected = "
<contacts:bambooContact xmlns:xs=\"http://www.w3.org/2001/XMLSchema\" xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\">
	<contacts:name>
		<contacts:familyName>Doe</contacts:familyName>
		<contacts:givenName>John</contacts:givenName>
		<contacts:partNames>
			<contacts:partNameContent>Louie</contacts:partNameContent>
			<contacts:partNameType>HONORIFIC_PREFIX</contacts:partNameType>
			<contacts:partNameLang>English</contacts:partNameLang>
		</contacts:partNames>
	</contacts:name>
	<contacts:displayName>JohnDoe123</contacts:displayName>
	<contacts:emails>
		<contacts:email>johndoe@aoldied.com</contacts:email>
	</contacts:emails>
	<contacts:iMs>
		<contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>
		<contacts:account>johndoe</contacts:account>
		<contacts:locationType>WORK</contacts:locationType>
	</contacts:iMs>
	<contacts:telephones>
		<contacts:telephoneNumber>123</contacts:telephoneNumber>
		<contacts:telephoneType>FAX</contacts:telephoneType>
	</contacts:telephones>
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
					"partNames" => array(
						0 => array(
							"partNameContent" => "Louie",
							"partNameLang" => "English",
							"partNameType" => "HONORIFIC_PREFIX"
						)
					)
				),
				"displayName" => "JohnDoe123",
				"emails" => array(
					["email" => "johndoe@aoldied.com"]
				),
				"IMs" => array(
					0 => array(
						"instantMessagingType" => "SKYPE",
						"account" => "johndoe",
						"locationType" => "WORK"
					)
				),
				"telephones" => array(
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

		public function testExampleXML() {
			$honorific = new PartName();
			$honorific
				->setPartNameType("HONORIFIC_PREFIX")
				->setPartNameContent("Mr.")
				->setPartNameLang("eng");

			$nameGiven = new PartName();
			$nameGiven
				->setPartNameType("NAME_GIVEN")
				->setPartNameContent("Fernando")
				->setPartNameLang("spa");

			$familyPaternal = new PartName();
			$familyPaternal
				->setPartNameType("NAME_FAMILY_PATERNAL")
				->setPartNameContent("Alvarez")
				->setPartNameLang("spa");

			$familyMaternal = new PartName();
			$familyMaternal
				->setPartNameType("NAME_FAMILY_MATERNAL")
				->setPartNameContent("Cadena")
				->setPartNameLang("spa");

			$honorificSuf = new PartName();
			$honorificSuf
				->setPartNameType("HONORIFIC_SUFFIX")
				->setPartNameContent("PMP")
				->setPartNameLang("eng");


			$tel = new Telephone();
			$tel
				->setTelephoneNumber("650-555-1212")
				->setTelephoneType("SMS")
				->setLocationType("SABBATICAL");

			$tel2 = new Telephone();
			$tel2
				->setTelephoneNumber("415-555-1212")
				->setTelephoneType("VOICE")
				->setLocationType("HOME");

			$IM = new IM();
			$IM
				->setInstantMessagingType("SKYPE")
				->setAccount("falvarez@berkeley.edu")
				->setLocationType("WORK");

			$address = new Address();
			$address
				->setStreetAddress("123 Main St.\n2nd fl\nBy the south window")
				->setLocality("Berkeley")
				->setRegion("CA")
				->setPostalCode("94105")
				->setCountry("USA")
				->setLocationType("WORK");

			$email = new Email();
			$email->setEmail("falvarez@berkeley.edu");

			$contact = new Contact();
			$contact
				->setContactNote("A new Poster tested contact")
				->addEmails($email)
				->addPartNames($honorific)
				->addPartNames($nameGiven)
				->addPartNames($familyPaternal)
				->addPartNames($familyMaternal)
				->addPartNames($honorificSuf)
				->addTelephones($tel)
				->addTelephones($tel2)
				->addIMs($IM)
				->addAddress($address);

			$expected = "<contacts:bambooContact xmlns:xs=\"http://www.w3.org/2001/XMLSchema\" xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\">
<contacts:emails>
<contacts:email>falvarez@berkeley.edu</contacts:email>
</contacts:emails>
<contacts:iMs>
<contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>
<contacts:account>falvarez@berkeley.edu</contacts:account>
<contacts:locationType>WORK</contacts:locationType>
</contacts:iMs>
<contacts:addresses>
<contacts:streetAddress>123 Main St.
2nd fl
By the south window</contacts:streetAddress>
<contacts:locality>Berkeley</contacts:locality>
<contacts:region>CA</contacts:region>
<contacts:postalCode>94105</contacts:postalCode>
<contacts:country>USA</contacts:country>
<contacts:locationType>WORK</contacts:locationType>
</contacts:addresses>
<contacts:contactNote>A new Poster tested contact</contacts:contactNote>
<contacts:partNames>
<contacts:partNameContent>Mr.</contacts:partNameContent>
<contacts:partNameType>HONORIFIC_PREFIX</contacts:partNameType>
<contacts:partNameLang>eng</contacts:partNameLang>
</contacts:partNames>
<contacts:partNames>
<contacts:partNameContent>Fernando</contacts:partNameContent>
<contacts:partNameType>NAME_GIVEN</contacts:partNameType>
<contacts:partNameLang>spa</contacts:partNameLang>
</contacts:partNames>
<contacts:partNames>
<contacts:partNameContent>Alvarez</contacts:partNameContent>
<contacts:partNameType>NAME_FAMILY_PATERNAL</contacts:partNameType>
<contacts:partNameLang>spa</contacts:partNameLang>
</contacts:partNames>
<contacts:partNames>
<contacts:partNameContent>Cadena</contacts:partNameContent>
<contacts:partNameType>NAME_FAMILY_MATERNAL</contacts:partNameType>
<contacts:partNameLang>spa</contacts:partNameLang>
</contacts:partNames>
<contacts:partNames>
<contacts:partNameContent>PMP</contacts:partNameContent>
<contacts:partNameType>HONORIFIC_SUFFIX</contacts:partNameType>
<contacts:partNameLang>eng</contacts:partNameLang>
</contacts:partNames>
<contacts:telephones>
<contacts:telephoneNumber>650-555-1212</contacts:telephoneNumber>
<contacts:telephoneType>SMS</contacts:telephoneType>
<contacts:locationType>SABBATICAL</contacts:locationType>
</contacts:telephones>
<contacts:telephones>
<contacts:telephoneNumber>415-555-1212</contacts:telephoneNumber>
<contacts:telephoneType>VOICE</contacts:telephoneType>
<contacts:locationType>HOME</contacts:locationType>
</contacts:telephones>
</contacts:bambooContact>";
			$this->assertEquals($expected, $contact->getXML(true));
		}
	}