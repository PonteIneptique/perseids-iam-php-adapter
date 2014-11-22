<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class Email extends PropertyBase {
		/**
		 * The namespace 
		 * @var string
		 */
		protected $namespace = "contacts";
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "emails";

		/**
		 * An email
		 * @var string
		 */
		protected $email;


		/**
		 * Gets the An email.
		 *
		 * @return string
		 */
		public function getEmail()
		{
		    return $this->email;
		}

		/**
		 * Sets the An email.
		 *
		 * @param string $email the email
		 *
		 * @return self
		 */
		public function setEmail($email)
		{
		    $this->email = $email;
		    return $this;
		}
	}
?>