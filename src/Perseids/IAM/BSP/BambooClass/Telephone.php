<?php
	namespace Perseids\IAM\BSP\BambooClass;

	use Perseids\IAM\BSP\BambooClass\Mockup;

	class Telephone extends Mockup {
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "telephone";

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


		public function __construct() {
			$this->addExclusion("defaultTelephoneType");
			$this->addExclusion("telephoneTypeEnum");
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
	}