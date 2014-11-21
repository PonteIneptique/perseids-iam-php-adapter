<?php

	namespace Perseids\Tests\IAM\Entity;

	use Perseids\IAM\Entity\Contact;
	use Perseids\IAM\Entity\Profile;


	use Perseids\IAM\BSP\Instance;


	use Perseids\IAM\Property\Interest;
	use Perseids\IAM\Property\Expertise;
	use Perseids\IAM\Property\OtherProfile;

	class ProfileTest extends \PHPUnit_Framework_TestCase {
		public function testGetSerialized() {
			$expertise = new Expertise();
			$expertise
				->setExpertise("Anonymous");

			$contact = new Contact();
			$contact
				->setEmails(array("johndoe@domain.com"));
			
			$profile = new Profile();
			$profile
				->addExpertise($expertise)
				->setProfileContact($contact);

			$expected = [
				"profileContact" => [
					"emails" => ["johndoe@domain.com"]
				],
				"expertise" => [
					["expertise" => "Anonymous"]
				]
			];
			$this->assertEquals($expected, $profile->getSerialized());
		}
		public function testGetXML() {
			$expertise = new Expertise();
			$expertise
				->setExpertise("Anonymous");

			$contact = new Contact();
			$contact
				->setEmails(array("johndoe@domain.com"))
				->setUUID("urn:uuid:68464-156-1451-156");
			
			$profile = new Profile();
			$profile
				->addExpertise($expertise)
				->setProfileContact($contact);

			$expected = "<person:bambooProfile person:confidential=\"false\" person:primary=\"true\" xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\" xmlns:person=\"http://projectbamboo.org/bsp/BambooPerson\">
<person:profileContact>urn:uuid:68464-156-1451-156</person:profileContact>
<person:expertises>
<person:expertise>Anonymous</person:expertise>
</person:expertises>
</person:bambooProfile>";
			$this->assertEquals($expected, $profile->getXML(true));
		}

		public function testRequiredContact() {
			$this->setExpectedException('Perseids\IAM\Exceptions\RequiredFieldException');
			$profile = new Profile();
			$profile->getSerialized();
		}
	}