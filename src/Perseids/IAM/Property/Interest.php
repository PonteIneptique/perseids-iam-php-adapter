<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class Interest extends PropertyBase {
		/**
		 * The namespace 
		 * @var string
		 */
		protected $namespace = "person";
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "interests";

		/**
		 * The interest ID (a URI)
		 * @var string
		 */
		protected $interestID;

		/**
		 * The interest 
		 * @var string
		 */
		protected $interest;

		/**
		 * Gets the The interest ID (a URI).
		 *
		 * @return string
		 */
		public function getInterestID()
		{
		    return $this->interestID;
		}

		/**
		 * Sets the The interest ID (a URI).
		 *
		 * @param string $interestID the interest
		 *
		 * @return self
		 */
		public function setInterestID($interestID)
		{
		    $this->interestID = $interestID;

		    return $this;
		}

		/**
		 * Gets the The interest.
		 *
		 * @return string
		 */
		public function getInterest()
		{
		    return $this->interest;
		}

		/**
		 * Sets the The interest.
		 *
		 * @param string $interest the interest
		 *
		 * @return self
		 */
		public function setInterest($interest)
		{
		    $this->interest = $interest;

		    return $this;
		}
}