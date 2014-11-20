<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class PartName extends PropertyBase {
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "partName";

		/**
		 * Part of the name
		 * @var string
		 */
		protected $partName;

		/**
		 * Part of the name's type
		 * @required
		 * @var string
		 */
		protected $partNameType;

		/**
		 * Part of name Lang
		 * @var string
		 */
		protected $partNameLang;

		/**
		 * Part Name type enumeration
		 * @var array
		 */
		private $partNameTypeEnum = array("HONORIFIC_PREFIX", "NAME_GIVEN", "NAME_MIDDLE", "NAME_FAMILY_PATERNAL", "NAME_FAMILY_MATERNAL", "HONORIFIC_SUFFIX");
	
		/**
		 * 
		 *
		 */
		public function __construct() {
			$this->addExclusion("partNameTypeEnum");
		}

		/**
		 * Gets the Part of the name.
		 *
		 * @return string
		 */
		public function getPartName()
		{
		    return $this->partName;
		}

		/**
		 * Sets the Part of the name.
		 *
		 * @param string $partName the part name
		 *
		 * @return self
		 */
		public function setPartName($partName)
		{
		    $this->partName = $partName;

		    return $this;
		}

		/**
		 * Gets the Part of the name's type.
		 *
		 * @return string
		 */
		public function getPartNameType()
		{
		    return $this->partNameType;
		}

		/**
		 * Sets the Part of the name's type.
		 *
		 * @param string $partNameType the part name type
		 *
		 * @return self
		 */
		public function setPartNameType($partNameType)
		{
			if(array_search($partNameType, $this->partNameTypeEnum, $strict = TRUE)) {
				$this->partNameType = $partNameType;
			} else {
				$this->partNameType = $this->partNameTypeEnum[0];
			}
		}

		/**
		 * Gets the Part of name Lang.
		 *
		 * @return string
		 */
		public function getPartNameLang()
		{
		    return $this->partNameLang;
		}

		/**
		 * Sets the Part of name Lang.
		 *
		 * @param string $partNameLang the part name lang
		 *
		 * @return self
		 */
		public function setPartNameLang($partNameLang)
		{
		    $this->partNameLang = $partNameLang;

		    return $this;
		}

		/**
		 * Get the list of available partNameType
		 * @return array
		 */
		public function getPartNameTypeEnum() {
			return $this->partNameTypeEnum;
		}

}