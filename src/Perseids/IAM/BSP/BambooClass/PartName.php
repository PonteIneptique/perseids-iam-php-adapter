<?php
	namespace Perseids\IAM\BSP\BambooClass;

	use Perseids\IAM\BSP\BambooClass\Mockup;

	class PartName extends Mockup {
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
		    $this->partNameType = $partNameType;

		    return $this;
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
}