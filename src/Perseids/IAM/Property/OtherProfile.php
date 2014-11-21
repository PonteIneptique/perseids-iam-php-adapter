<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class OtherProfile extends PropertyBase {
		/**
		 * The namespace 
		 * @var string
		 */
		protected $namespace = "person";
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "otherProfiles";

		/**
		 * The profile name
		 * @var string
		 */
		protected $profileName;
		
		/**
		 * The profile url
		 * @var string
		 */
		protected $profileURL;

		public function __construct() {
			parent::__construct();
			$this->addRequired(["profileURL", "profileName"]);
		}
	
		/**
		 * Gets the The profile name.
		 *
		 * @return string
		 */
		public function getProfileName()
		{
		    return $this->profileName;
		}

		/**
		 * Sets the The profile name.
		 *
		 * @param string $profileName the profile name
		 *
		 * @return self
		 */
		public function setProfileName($profileName)
		{
		    $this->profileName = $profileName;

		    return $this;
		}

		/**
		 * Gets the The profile url.
		 *
		 * @return string
		 */
		public function getProfileURL()
		{
		    return $this->profileURL;
		}

		/**
		 * Sets the The profile url.
		 *
		 * @param string $profileURL the profile
		 *
		 * @return self
		 */
		public function setProfileURL($profileURL)
		{
		    $this->profileURL = $profileURL;

		    return $this;
		}
}