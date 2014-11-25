<?php
	namespace Perseids\IAM\Entity;

	use Perseids\IAM\Entity\Abstractions\EntityBase;
	use Perseids\IAM\Entity\Abstractions\EntityInterface;
	use Perseids\IAM\Entity\Contact;
	use Perseids\IAM\Entity\Person;

	use Perseids\IAM\Property\OtherProfile;
	use Perseids\IAM\Property\Interest;
	use Perseids\IAM\Property\Expertise;

	class Profile extends EntityBase implements EntityInterface {
		/**
		 * The namespace for this node
		 * @var string 
		 */
		protected $namespace = "person";

		/**
		 * The URL path endpoint for this object
		 * @var string 
		 */
		protected $path = "persons/{{personID}}/profiles";

		/**
		 * The profile UUID on the BSP
		 * @var string
		 */
		protected $profileIdentifier;

		/**
		 * The main node name
		 * @var string
		 */
		protected $node = "bambooProfile";

		/**
		 * The main node attributes
		 * @var string
		 */
		protected $nodeAttributes = "xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\" xmlns:person=\"http://projectbamboo.org/bsp/BambooPerson\"";

		/**
		 * The Contact tied to the profile
		 * @var Contact
		 */
		protected $profileContact;

		/**
		 * Interest of the users
		 * @var array
		 */
		protected $interests;

		/**
		 * Expertise of the users
		 * @var array
		 */
		protected $expertises;

		/**
		 * External affiliations
		 * @var array
		 */
		protected $externalAffiliations;

		/**
		 * Preferred Language
		 * @var string
		 */
		protected $preferredLanguage;

		/**
		 * Language used in Scholarship
		 * @var array
		 */
		protected $languageUsedInScholarships;

		/**
		 * Profile information / note
		 * @var string
		 */
		protected $profileInformation;

		/**
		 * Other profile informations
		 * @var array
		 */
		protected $otherProfile;

		function __construct() {
			parent::__construct();
			$this->addRequired("profileContact");
			$this->addExclusion("profileIdentifier");
			$this->parent = new Person();
		}


		/**
		 * Set the UUID of this profile
		 * @param string $UUID [description]
		 * @return self
		 */
		public function setUUID($UUID) {
			$this->profileIdentifier = $BSPUuid;
			return $this;
		} 

		/**
		 * Get the UUID of this profile
		 * @return string 
		 */
		public function getUUID() {
			return $this->profileIdentifier;
		}

		/**
		 * Gets the The Contact tied to the profile.
		 *
		 * @return Contact
		 */
		public function getProfileContact()
		{
		    return $this->profileContact;
		}

		/**
		 * Sets the The Contact tied to the profile.
		 *
		 * @param Contact $profileContact the profile contact
		 *
		 * @return self
		 */
		public function setProfileContact(Contact $profileContact)
		{
		    $this->profileContact = $profileContact;

		    return $this;
		}

		/**
		 * Add an Interests to the users.
		 *
		 * @param array $interests the expertise
		 *
		 * @return self
		 */
		public function addInterests(Interest $interests)
		{
			return $this->addObjectToList("interests", $interests, "Perseids\IAM\Property\Interest");
		}

		/**
		 * Gets the Interest of the users.
		 *
		 * @return array
		 */
		public function getInterests()
		{
		    return $this->interests;
		}

		/**
		 * Sets the Interest of the users.
		 *
		 * @param array $interests the interest
		 *
		 * @return self
		 */
		public function setInterests(array $interests)
		{
			return $this->setListOfObject("interests", $interests, "Perseids\IAM\Property\Interest");
		}

		/**
		 * Gets the Expertise of the users.
		 *
		 * @return array
		 */
		public function getExpertises()
		{
		    return $this->expertises;
		}

		/**
		 * Sets the Expertise of the users.
		 *
		 * @param array $expertises the expertise
		 *
		 * @return self
		 */
		public function setExpertises(array $expertises)
		{
			return $this->setListOfObject("expertises", $expertises, "Perseids\IAM\Property\Expertise");
		}

		/**
		 * Add an Expertise to the users.
		 *
		 * @param array $expertises the expertise
		 *
		 * @return self
		 */
		public function addExpertises(Expertise $expertises)
		{
			return $this->addObjectToList("expertises", $expertises, "Perseids\IAM\Property\Expertise");
		}

		/**
		 * Gets the External affiliations.
		 *
		 * @return array
		 */
		public function getExternalAffiliations()
		{
		    return $this->externalAffiliations;
		}

		/**
		 * Sets the External affiliations.
		 *
		 * @param array $externalAffiliations the external affiliation
		 *
		 * @return self
		 */
		public function setExternalAffiliations(array $externalAffiliations)
		{
		    $this->externalAffiliations = $externalAffiliations;

		    return $this;
		}

		/**
		 * Gets the Preferred Language.
		 *
		 * @return string
		 */
		public function getPreferredLanguage()
		{
		    return $this->preferredLanguage;
		}

		/**
		 * Sets the Preferred Language.
		 *
		 * @param string $preferredLanguage the preferred language
		 *
		 * @return self
		 */
		public function setPreferredLanguage($preferredLanguage)
		{
		    $this->preferredLanguage = $preferredLanguage;

		    return $this;
		}

		/**
		 * Gets the Language used in Scholarship.
		 *
		 * @return array
		 */
		public function getLanguageUsedInScholarships()
		{
		    return $this->languageUsedInScholarships;
		}

		/**
		 * Sets the Language used in Scholarship.
		 *
		 * @param array $languageUsedInScholarship the language used in scholarship
		 *
		 * @return self
		 */
		public function setLanguageUsedInScholarships(array $languageUsedInScholarships)
		{
		    $this->languageUsedInScholarships = $languageUsedInScholarships;

		    return $this;
		}

		/**
		 * Gets the Profile information / note.
		 *
		 * @return string
		 */
		public function getProfileInformation()
		{
		    return $this->profileInformation;
		}

		/**
		 * Sets the Profile information / note.
		 *
		 * @param string $profileInformation the profile information
		 *
		 * @return self
		 */
		public function setProfileInformation($profileInformation)
		{
		    $this->profileInformation = $profileInformation;

		    return $this;
		}

		/**
		 * Gets the Other profile informations.
		 *
		 * @return array
		 */
		public function getOtherProfiles()
		{
		    return $this->otherProfiles;
		}

		/**
		 * Sets the Other profile informations.
		 *
		 * @param array $otherProfile the other profile
		 *
		 * @return self
		 */
		public function setOtherProfiles(array $otherProfiles)
		{
			return $this->setListOfObject("otherProfiles", $otherProfiles, "Perseids\IAM\Property\OtherProfile");
		}

		/**
		 * Add one Other profile informations.
		 *
		 * @param OtherProfile $otherProfile the other profile
		 *
		 * @return self
		 */
		public function addOtherProfiles(OtherProfile $otherProfiles)
		{
			return $this->addObjectToList("otherProfiles", $otherProfiles, "Perseids\IAM\Property\OtherProfile");
		}

		/**
		 * Get the name of the UUID node
		 * @return string
		 */
		public function getUUIDNode() {
			return "profileIdentifier";
		}
}