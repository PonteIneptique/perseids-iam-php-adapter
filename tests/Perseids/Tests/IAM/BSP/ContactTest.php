<?php

	namespace Perseids\IAM\BSP;

	use Perseids\IAM\BSP\Contact;
	use Perseids\IAM\BSP\BambooClass\Name;
	use Perseids\IAM\BSP\BambooClass\PartName;
	use Perseids\IAM\BSP\BambooClass\IM;
	use Perseids\IAM\BSP\BambooClass\Address;
	use Perseids\IAM\BSP\BambooClass\Telephone;

	class ContactTest extends \PHPUnit_Framework_TestCase {
		public function testXML() {
			$name = new Name();
			$name->setFamilyName("Doe")
				 ->setGivenName("John");

			$partname = array();
				$partname[1] = new PartName();
				$partname[1]->setPartName("Louie");
				$partname[1]->setPartNameLang("English");
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

			$contact = new Contact();
			$contact
				->setName($name)
				->setDisplayName("JohnDoe123")
				->setEmail(array("johndoe@aoldied.com"))
				->setIMs(array($IM))
				->setTelephone(array($tel));

			print_r($contact->getXML());

		}
	}