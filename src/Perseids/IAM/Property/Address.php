<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class Address extends PropertyBase {
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "addresses";

		/**
		 * Formatted version of the Address
		 * @var string
		 */
		protected $formattedAddress;

		/**
		 * Street Address of the Address
		 * @var string
		 */
		protected $streetAddress;

		/**
		 * Locality of the address [City]
		 * @var string
		 */
		protected $locality;

		/**
		 * Region of the address
		 * @var string
		 */
		protected $region;

		/**
		 * Postal Code of the Address
		 * @var string
		 */
		protected $postalCode;

		/**
		 * Country of the address
		 * @var string
		 */
		protected $country;

		/**
		 * Address type
		 * @var string
		 */
		protected $locationType;

		/**
		 * Address type Enum
		 * @var array
		 */
		protected $locationTypeEnum = ["HOME", "WORK", "OTHER", "SABBATICAL"];

		/**
		 * Address Type default
		 * @var string
		 */
		protected $defaultLocationType = "OTHER";

		public function __construct() {
			$this->addExclusion("locationTypeEnum");
			$this->addExclusion("defaultLocationType");
			$this->addRequired("locationType");
		}

		/**
		 * Get the formatted address
		 * @return string The formatted address
		 */
		public function getFormattedAddress(){
			return $this->formattedAddress;
		}

		/**
		 * Set the formatted address
		 * @param string The formatted address
		 * @return \Perseids\IAM\BSP\Contact\Address This object
		 */
		public function setFormattedAddress($formattedAddress){
			$this->formattedAddress = $formattedAddress;
			return $this;
		}

		/**
		 * Get the street address
		 * @return string The street address
		 */
		public function getStreetAddress(){
			return $this->streetAddress;
		}

		/**
		 * Set the street address
		 * @param string The street address
		 * @return \Perseids\IAM\BSP\Contact\Address This object
		 */
		public function setStreetAddress($streetAddress){
			$this->streetAddress = $streetAddress;
			return $this;
		}

		/**
		 * Get the locality
		 * @return string The locality
		 */
		public function getLocality(){
			return $this->locality;
		}

		/**
		 * Set the locality
		 * @param string The locality
		 * @return \Perseids\IAM\BSP\Contact\Address This object
		 */
		public function setLocality($locality){
			$this->locality = $locality;
			return $this;
		}

		/**
		 * Get the region
		 * @return string The region
		 */
		public function getRegion(){
			return $this->region;
		}

		/**
		 * Set the region
		 * @param string The region
		 * @return \Perseids\IAM\BSP\Contact\Address This object
		 */
		public function setRegion($region){
			$this->region = $region;
			return $this;
		}

		/**
		 * Get the postal code
		 * @return string The postal code
		 */
		public function getPostalCode(){
			return $this->postalCode;
		}

		/**
		 * Set the postal code
		 * @param string The postal code
		 * @return \Perseids\IAM\BSP\Contact\Address This object
		 */
		public function setPostalCode($postalCode){
			$this->postalCode = $postalCode;
			return $this;
		}

		/**
		 * Get the country
		 * @return string The country
		 */
		public function getCountry(){
			return $this->country;
		}

		/**
		 * Set the country
		 * @param string The country
		 * @return \Perseids\IAM\BSP\Contact\Address This object
		 */
		public function setCountry($country){
			$this->country = $country;
			return $this;
		}

		/**
		 * Get the address type
		 * @return string The address type
		 */
		public function getLocationType(){
			return $this->locationType;
		}

		/**
		 * Set the address type
		 * @param string The address type. Can only be part of (HOME, WORK, OTHER, SABBATICAL)
		 * @return self
		 */
		public function setLocationType($locationType){
			if(array_search($locationType, $this->locationTypeEnum, $strict = TRUE) !== false) {
				$this->locationType = $locationType;
			} else {
				$this->locationType = $this->defaultLocationType;
			}
			return $this;
		}

		/**
		 * Get the list of available address type
		 * @return array
		 */
		public function getLocationTypeEnum() {
			return $this->locationTypeEnum;
		}
	}