<?php
	namespace Perseids\IAM\Entity;

	use Perseids\IAM\Entity\Abstraction\EntityBase;
	use Perseids\IAM\Entity\Abstraction\EntityInterface;
	use Perseids\IAM\Entity\Contact;

	use Perseids\IAM\Property\OtherProfile;
	use Perseids\IAM\Property\InterestExpertise;

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
		protected $path = "person/{{personID}}/profile";

		/**
		 * The main node name
		 * @var string
		 */
		protected $node = "bambooProfile";

		/**
		 * The main node attributes
		 * @var string
		 */
		protected $nodeAttributes = "person:confidential=\"false\" person:primary=\"true\" xmlns:contacts=\"http://projectbamboo.org/bsp/services/core/contact\" xmlns:person=\"http://projectbamboo.org/bsp/BambooPerson\"";

		/**
		 * The Contact tied to the profile
		 * @var Contact
		 */
		protected $profileContact;

		/**
		 * Interest of the users
		 * @var array
		 */
		protected $interest;

		/**
		 * Expertise of the users
		 * @var array
		 */
		protected $expertise;

		/**
		 * External affiliations
		 * @var array
		 */
		protected $externalAffiliation;

		/**
		 * Preferred Language
		 * @var string
		 */
		protected $preferredLanguage;

		/**
		 * Language used in Scholarship
		 * @var array
		 */
		protected $languageUsedInScholarship;

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
		}
	
		/**
		 * Gets the The namespace for this node.
		 *
		 * @return string
		 */
		public function getNamespace()
		{
		    return $this->namespace;
		}

		/**
		 * Sets the The namespace for this node.
		 *
		 * @param string $namespace the namespace
		 *
		 * @return self
		 */
		protected function setNamespace($namespace)
		{
		    $this->namespace = $namespace;

		    return $this;
		}

		/**
		 * Gets the The URL path endpoint for this object.
		 *
		 * @return string
		 */
		public function getPath()
		{
		    return $this->path;
		}

		/**
		 * Sets the The URL path endpoint for this object.
		 *
		 * @param string $path the path
		 *
		 * @return self
		 */
		protected function setPath($path)
		{
		    $this->path = $path;

		    return $this;
		}

		/**
		 * Gets the The main node name.
		 *
		 * @return string
		 */
		public function getNode()
		{
		    return $this->node;
		}

		/**
		 * Sets the The main node name.
		 *
		 * @param string $node the node
		 *
		 * @return self
		 */
		protected function setNode($node)
		{
		    $this->node = $node;

		    return $this;
		}

		/**
		 * Gets the The main node attributes.
		 *
		 * @return string
		 */
		public function getNodeAttributes()
		{
		    return $this->nodeAttributes;
		}

		/**
		 * Sets the The main node attributes.
		 *
		 * @param string $nodeAttributes the node attributes
		 *
		 * @return self
		 */
		protected function setNodeAttributes($nodeAttributes)
		{
		    $this->nodeAttributes = $nodeAttributes;

		    return $this;
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
		protected function setProfileContact(Contact $profileContact)
		{
		    $this->profileContact = $profileContact;

		    return $this;
		}

		/**
		 * Gets the Interest of the users.
		 *
		 * @return array
		 */
		public function getInterest()
		{
		    return $this->interest;
		}

		/**
		 * Sets the Interest of the users.
		 *
		 * @param array $interest the interest
		 *
		 * @return self
		 */
		protected function setInterest(array $interest)
		{
			return $this->setListOfObject("interest", $interest, "Perseids/IAM/Property/InterestExpertise");
		}

		/**
		 * Gets the Expertise of the users.
		 *
		 * @return array
		 */
		public function getExpertise()
		{
		    return $this->expertise;
		}

		/**
		 * Sets the Expertise of the users.
		 *
		 * @param array $expertise the expertise
		 *
		 * @return self
		 */
		protected function setExpertise(array $expertise)
		{
			return $this->setListOfObject("expertise", $expertise, "Perseids/IAM/Property/InterestExpertise");
		}

		/**
		 * Gets the External affiliations.
		 *
		 * @return array
		 */
		public function getExternalAffiliation()
		{
		    return $this->externalAffiliation;
		}

		/**
		 * Sets the External affiliations.
		 *
		 * @param array $externalAffiliation the external affiliation
		 *
		 * @return self
		 */
		protected function setExternalAffiliation(array $externalAffiliation)
		{
		    $this->externalAffiliation = $externalAffiliation;

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
		protected function setPreferredLanguage($preferredLanguage)
		{
		    $this->preferredLanguage = $preferredLanguage;

		    return $this;
		}

		/**
		 * Gets the Language used in Scholarship.
		 *
		 * @return array
		 */
		public function getLanguageUsedInScholarship()
		{
		    return $this->languageUsedInScholarship;
		}

		/**
		 * Sets the Language used in Scholarship.
		 *
		 * @param array $languageUsedInScholarship the language used in scholarship
		 *
		 * @return self
		 */
		protected function setLanguageUsedInScholarship(array $languageUsedInScholarship)
		{
		    $this->languageUsedInScholarship = $languageUsedInScholarship;

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
		protected function setProfileInformation($profileInformation)
		{
		    $this->profileInformation = $profileInformation;

		    return $this;
		}

		/**
		 * Gets the Other profile informations.
		 *
		 * @return array
		 */
		public function getOtherProfile()
		{
		    return $this->otherProfile;
		}

		/**
		 * Sets the Other profile informations.
		 *
		 * @param array $otherProfile the other profile
		 *
		 * @return self
		 */
		protected function setOtherProfile(array $otherProfile)
		{
			return $this->setListOfObject("otherProfile", $otherProfile, "Perseids/IAM/Property/OtherProfile");
		}
}