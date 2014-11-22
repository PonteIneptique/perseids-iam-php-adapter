<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class Telephone extends PropertyBase {
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "telephones";

		/**
		 * Telephone Number
		 * @var string
		 */
		protected $telephoneNumber;
		/**
		 * Telephone Type
		 * @var string
		 */
		protected $telephoneType;
	
		/**
		 * Telephone type Enum
		 * @var array
		 */
		protected $telephoneTypeEnum = ["VOICE", "FAX", "PAGER", "SMS"];

		/**
		 * Telephone Type default
		 * @var string
		 */
		protected $defaultTelephoneType = "VOICE";

		/**
		 * Name of the location type
		 * @var string
		 */
		protected $locationType;

		/**
		 * Location type Enumeration
		 * @var array
		 */
		protected $locationTypeEnum = ["HOME", "WORK", "OTHER", "SABBATICAL", "MOBILE"];

		public function __construct() {
			$this->addExclusion("defaultTelephoneType");
			$this->addExclusion("telephoneTypeEnum");
			$this->addExclusion("locationTypeEnum");
			$this->addRequired(array("telephoneType", "telephoneNumber"));
		}


		/**
		 * Gets the Telephone Number.
		 *
		 * @return string
		 */
		public function getTelephoneNumber()
		{
		    return $this->telephoneNumber;
		}

		/**
		 * Sets the Telephone Number.
		 *
		 * @param string $telephoneNumber the telephone number
		 *
		 * @return self
		 */
		public function setTelephoneNumber($telephoneNumber)
		{
		    $this->telephoneNumber = $telephoneNumber;

		    return $this;
		}

		/**
		 * Gets the Telephone Type.
		 *
		 * @return string
		 */
		public function getTelephoneType()
		{
		    return $this->telephoneType;
		}

		/**
		 * Sets the Telephone Type.
		 *
		 * @param string $telephoneType the telephone type
		 *
		 * @return self
		 */
		public function setTelephoneType($telephoneType)
		{
		    $this->telephoneType = $telephoneType;

			if(array_search($telephoneType, $this->telephoneTypeEnum, $strict = TRUE)) {
				$this->telephoneType = $telephoneType;
			} else {
				$this->telephoneType = $this->defaultTelephoneType;
			}
			return $this;
		}

		/**
		 * Gets the Name of the location type.
		 *
		 * @return string
		 */
		public function getLocationType()
		{
		    return $this->locationType;
		}

		/**
		 * Sets the Name of the location type.
		 *
		 * @param string $locationType the location type
		 *
		 * @return self
		 */
		public function setLocationType($locationType)
		{
			if(array_search($locationType, $this->locationTypeEnum, $strict = TRUE)) {
				$this->locationType = $locationType;
			} else {
				$this->locationType = $this->getLocationTypeEnum()[0];
			}

		    return $this;
		}

		/**
		 * Get the list of available location type
		 * @return array
		 */
		public function getLocationTypeEnum() {
			return $this->locationTypeEnum;
		}
	}