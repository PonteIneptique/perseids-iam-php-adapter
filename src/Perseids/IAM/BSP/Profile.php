<?php
	namespace Perseids\IAM\BSP;

	use Perseids\IAM\BSP\Schema;
	use Perseids\IAM\BSP\Person;
	use Perseids\IAM\BSP\Instance;

	class Profile {
		/**
		 * The Namespace used for the xml
		 * @var string
		 */
		protected $namespace = "person";

		/**
		 * Properties for given profile. 
		 * @var array
		 */
		protected $properties;

		/**
		 * UUID for the profile
		 * @var string
		 */
		protected $uuid = null;

		/**
		 * Get the array of properties for this profile
		 * @return array $properties An array of properties
		 */
		public function getProperties() {
			return $this->properties;
		}

		/**
		 * Set the properties for the profile
		 * @param array $properties An array of properties
		 * @return \Perseids\IAM\BSP\Profile This instance
		 */
		public function setProperties($properties) {
			$this->properties = $properties;
			return $this;
		}

		/**
		 * Set the UUID of the profile
		 * @param string $uuid UUID of the profile
		 * @return \Perseids\IAM\BSP\Profile This instance
		 */
		public function setUUID($uuid) {
			$this->uuid = $uuid;
			return $this;
		}

		/**
		 * Get the UUID of the profile
		 * @return string	UUID of the profile
		 */
		public function getUUID() {
			return $this->uuid;
		}

		/**
		 * Add a property value for this profile.
		 * @param string $field Field name
		 * @param string $value Value for a property
		 * @return \Perseids\IAM\BSP\Profile This instance
		 */
		public function addProperty($field, $value) {
			if(!array_key_exists($field, $this->properties)) {
				$this->properties[$field] = array();
			}
			if(!in_array($value, $this->properties[$field], $strict = TRUE)) {
				$this->properties[$field][] = $value;	
			}
			return $this;
		}


	}
?>