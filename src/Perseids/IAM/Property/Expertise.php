<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class Expertise extends PropertyBase {
		/**
		 * The namespace 
		 * @var string
		 */
		protected $namespace = "person";
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "expertises";

		/**
		 * The expertise ID (a URI)
		 * @var string
		 */
		protected $expertiseID;

		/**
		 * The expertise 
		 * @var string
		 */
		protected $expertise;

		/**
		 * Gets the The expertise ID (a URI).
		 *
		 * @return string
		 */
		public function getExpertiseID()
		{
		    return $this->expertiseID;
		}

		/**
		 * Sets the The expertise ID (a URI).
		 *
		 * @param string $expertiseID the expertise
		 *
		 * @return self
		 */
		public function setExpertiseID($expertiseID)
		{
		    $this->expertiseID = $expertiseID;

		    return $this;
		}

		/**
		 * Gets the The expertise.
		 *
		 * @return string
		 */
		public function getExpertise()
		{
		    return $this->expertise;
		}

		/**
		 * Sets the The expertise.
		 *
		 * @param string $expertise the expertise
		 *
		 * @return self
		 */
		public function setExpertise($expertise)
		{
		    $this->expertise = $expertise;

		    return $this;
		}
}