<?php

	namespace Perseids\IAM\BSP;

	use Perseids\IAM\BSP\BambooClass\Mockup;
	use Perseids\IAM\BSP\BambooClass\Name;
	use Perseids\IAM\BSP\BambooClass\IM;
	use Perseids\IAM\BSP\BambooClass\Address;
	use Perseids\IAM\BSP\BambooClass\Telephone;

	class Contact extends Mockup {
		/**
		 * The main node name
		 * @var string
		 */
		protected $node = "bambooContact";

		/**
		 * The main node attributes
		 * @var string
		 */
		protected $nodeAttributes = 'xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact"';

		/**
		 * The contact's Identifier
		 * @var string
		 */
		protected $contactId;

		/**
		 * The contact's Name
		 * @var Name
		 */
		protected $name;

		/**
		 * The contact's display Name
		 * @var string
		 */
		protected $displayName;

		/**
		 * The Contact's email
		 * Should be an array of strings
		 * @var array
		 */
		protected $email;

		/**
		 * The Contact's IMs
		 * Should be a list of IMType
		 * @var array
		 */
		protected $IMs;

		/**
		 * The contact's address
		 * @var array
		 */
		protected $address;

		/**
		 * The contact's note
		 * @var string
		 */
		protected $contactNode;

		/**
		 * The contact's telephone
		 * @var array
		 */
		protected $telephone;

		function __construct() {
			$this->addExclusion("contactId");
		}

		/**
		 * Gets the The contact's Identifier.
		 *
		 * @return string
		 */
		public function getContactIdentifier()
		{
		    return $this->contactIdentifier;
		}

		/**
		 * Sets the The contact's Identifier.
		 *
		 * @param string $contactIdentifier the contact identifier
		 *
		 * @return self
		 */
		public function setContactIdentifier($contactIdentifier)
		{
		    $this->contactIdentifier = $contactIdentifier;

		    return $this;
		}

		/**
		 * Gets the The contact's Name.
		 *
		 * @return Name
		 */
		public function getName()
		{
		    return $this->name;
		}

		/**
		 * Sets the The contact's Name.
		 *
		 * @param Name $name the name
		 *
		 * @return self
		 */
		public function setName(Name $name)
		{
		    $this->name = $name;

		    return $this;
		}

		/**
		 * Gets the The contact's display Name.
		 *
		 * @return string
		 */
		public function getDisplayName()
		{
		    return $this->displayName;
		}

		/**
		 * Sets the The contact's display Name.
		 *
		 * @param string $displayName the display name
		 *
		 * @return self
		 */
		public function setDisplayName($displayName)
		{
		    $this->displayName = $displayName;

		    return $this;
		}

		/**
		 * Gets the The Contact's email
		 * Should be an array of strings.
		 *
		 * @return array
		 */
		public function getEmail()
		{
		    return $this->email;
		}

		/**
		 * Sets the The Contact's email
		 * Should be an array of strings.
		 *
		 * @param array $email the email
		 *
		 * @return self
		 */
		public function setEmail(array $email)
		{
		    $this->email = $email;

		    return $this;
		}

		/**
		 * Gets the The Contact's IMs
		 * Should be a list of IMType.
		 *
		 * @return array
		 */
		public function getIMs()
		{
		    return $this->IMs;
		}

		/**
		 * Sets the The Contact's IMs
		 * Should be a list of IMType.
		 *
		 * @param array $IMs the ims
		 *
		 * @return self
		 */
		public function setIMs(array $IMs)
		{
		    $this->IMs = $IMs;

		    return $this;
		}

		/**
		 * Gets the The contact's address.
		 *
		 * @return array
		 */
		public function getAddress()
		{
		    return $this->address;
		}

		/**
		 * Sets the The contact's address.
		 *
		 * @param array $address the address
		 *
		 * @return self
		 */
		public function setAddress(array $address)
		{
		    $this->address = $address;

		    return $this;
		}

		/**
		 * Gets the The contact's note.
		 *
		 * @return string
		 */
		public function getContactNode()
		{
		    return $this->contactNode;
		}

		/**
		 * Sets the The contact's note.
		 *
		 * @param string $contactNode the contact node
		 *
		 * @return self
		 */
		public function setContactNode($contactNode)
		{
		    $this->contactNode = $contactNode;

		    return $this;
		}

		/**
		 * Gets the The contact's telephone.
		 *
		 * @return array
		 */
		public function getTelephone()
		{
		    return $this->telephone;
		}

		/**
		 * Sets the The contact's telephone.
		 *
		 * @param array $telephone the telephone
		 *
		 * @return self
		 */
		public function setTelephone(array $telephone)
		{
		    $this->telephone = $telephone;

		    return $this;
		}
}