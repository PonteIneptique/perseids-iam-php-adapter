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
				->addExpertises($expertise)
				->setProfileContact($contact);

			$expected = [
				"profileContact" => [
					"emails" => ["johndoe@domain.com"]
				],
				"expertises" => [
					["expertise" => "Anonymous"]
				]
			];
			$this->assertEquals($expected, $profile->getSerialized());
		}
		public function testGetXML() {
			$expertise = new Expertise();
			$expertise
				->setExpertise("An expertise");

			$interest = new Interest();
			$interest
				->setInterest("An interest");

			$otherProfiles = new OtherProfile();
			$otherProfiles
				->setProfileName("Some other profile")
				->setProfileUrl("http://tempuri.org");


			$contact = new Contact();
			$contact
				->setEmails(array("johndoe@domain.com"))
				->setUUID("urn:uuid:28ae4ba0-40f2-4ccc-86f9-8577c29005a8");
			
			$profile = new Profile();
			$profile
				->addInterests($interest)
				->setProfileInformation("A new profile")
				->addExpertises($expertise)
				->setProfileContact($contact)
				->setExternalAffiliations(array("http://berkeley.org"))
				->setPreferredLanguage("spa")
				->setLanguageUsedInScholarships(array("eng"))
				->addOtherProfiles($otherProfiles);

			$expected = "<person:bambooPerson xmlns:person=\"http://projectbamboo.org/bsp/BambooPerson\" xmlns:xs=\"http://www.w3.org/2001/XMLSchema\">
<person:bambooProfile xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\" xmlns:person=\"http://projectbamboo.org/bsp/BambooPerson\">
<contacts:bambooContact>
<contacts:contactId>urn:uuid:28ae4ba0-40f2-4ccc-86f9-8577c29005a8</contacts:contactId>
</contacts:bambooContact>
<person:interests>
<person:interest>An interest</person:interest>
</person:interests>
<person:expertises>
<person:expertise>An expertise</person:expertise>
</person:expertises>
<person:externalAffiliations>http://berkeley.org</person:externalAffiliations>
<person:preferredLanguage>spa</person:preferredLanguage>
<person:languageUsedInScholarships>eng</person:languageUsedInScholarships>
<person:profileInformation>A new profile</person:profileInformation>
<person:otherProfiles>
<person:profileName>Some other profile</person:profileName>
<person:profileUrl>http://tempuri.org</person:profileUrl>
</person:otherProfiles>
</person:bambooProfile>
</person:bambooPerson>";
			$this->assertEquals($expected, $profile->getXML(true));
		}

		public function testRequiredContact() {
			$this->setExpectedException('Perseids\IAM\Exceptions\RequiredFieldException');
			$profile = new Profile();
			$profile->getSerialized();
		}
	}