<?php

	namespace Perseids\IAM\Entity;

	use Perseids\IAM\Entity\Abstractions\EntityBase;
	use Perseids\IAM\Entity\Abstractions\EntityInterface;

	use Perseids\IAM\Property\Name;
	use Perseids\IAM\Property\PartName;
	use Perseids\IAM\Property\IM;
	use Perseids\IAM\Property\Address;
	use Perseids\IAM\Property\Telephone;
	use Perseids\IAM\Property\Email;

	class Contact extends EntityBase implements EntityInterface {
		/**
		 * The URL path endpoint for this object
		 * @var string 
		 */
		protected $path = "contacts";

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
		protected $emails;

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
		protected $contactNote;

		/**
		 * List of PartNames object
		 * @var array(\Perseids\IAM\Entity\PartNames);
		 */
		protected $partNames = array();

		/**
		 * The contact's telephone
		 * @var array
		 */
		protected $telephones;

		function __construct() {
			parent::__construct();
			$this->addExclusion("contactId");
			$this->addRequired("emails");
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
		public function getEmails()
		{
		    return $this->emails;
		}

		/**
		 * Sets the The Contact's email
		 * Should be an array of strings.
		 *
		 * @param array $email the email
		 *
		 * @return self
		 */
		public function setEmails(array $emails)
		{
			return $this->setListOfObject("emails", $emails, "Perseids\IAM\Property\Email");
		}

		/**
		 * Add an email to contact
		 *
		 * @param string $emails An email
		 * @return self
		 */
		public function addEmails(Email $emails)
		{
			return $this->addObjectToList("emails", $emails, "Perseids\IAM\Property\Email");
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
			return $this->setListOfObject("IMs", $IMs, "Perseids\IAM\Property\IM");
		}


		/**
		 * Add this IM to our IMs list
		 *
		 * @param array $IMs the ims
		 *
		 * @return self
		 */
		public function addIMs(IM $IM)
		{
			return $this->addObjectToList("IMs", $IM, "Perseids\IAM\Property\IM");
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
			return $this->setListOfObject("address", $address, "Perseids\IAM\Property\Address");
		}

		/**
		 * Add an address to the object.
		 *
		 * @param \Perseids\IAM\Entity\Address $address the part name
		 *
		 * @return self
		 */
		public function addAddress(Address $address)
		{
			return $this->addObjectToList("address", $address, "Perseids\IAM\Property\Address");
		}


		/**
		 * Gets the The contact's note.
		 *
		 * @return string
		 */
		public function getContactNote()
		{
		    return $this->contactNote;
		}

		/**
		 * Sets the The contact's note.
		 *
		 * @param string $contactNote the contact node
		 *
		 * @return self
		 */
		public function setContactNote($contactNote)
		{
		    $this->contactNote = $contactNote;

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
		 * @param array $telephone the telephone
		 *
		 * @return self
		 */
		public function setTelephones(array $telephones)
		{
			return $this->setListOfObject("telephones", $telephones, "Perseids\IAM\Property\Telephone");
		}

		/**
		 * Add a telephone to he List of PartNames object.
		 *
		 * @param \Perseids\IAM\Entity\Telephone $telephones the part name
		 *
		 * @return self
		 */
		public function addTelephones(Telephone $telephones)
		{
			return $this->addObjectToList("telephones", $telephones, "Perseids\IAM\Property\Telephone");
		}


		/**
		 * Gets the List of PartNames object.
		 *
		 * @return array(\Perseids\IAM\Entity\PartNames);
		 */
		public function getPartNames()
		{
		    return $this->partNames;
		}

		/**
		 * Sets the List of PartNames object.
		 *
		 * @param array(\Perseids\IAM\Entity\PartName); $partNames the part name
		 *
		 * @return self
		 */
		public function setPartNames($partNames)
		{
			return $this->setListOfObject("partNames", $partNames, "Perseids\IAM\Property\PartName");
		}

		/**
		 * Add a PartNames to he List of PartNames object.
		 *
		 * @param \Perseids\IAM\Entity\PartName $partNames the part name
		 *
		 * @return self
		 */
		public function addPartNames(PartName $partNames)
		{
			return $this->addObjectToList("partNames", $partNames, "Perseids\IAM\Property\PartName");
		}

		/**
		 * Set the UUID of the object
		 * @param $UUID string The UUID
		 * @return self
		 */
		public function setUUID($UUID) {
			$this->contactId = $UUID;
			return $this;
		}

		/**
		 * Get the UUID of the object
		 * @return string
		 */
		public function getUUID() {
			return $this->contactId;
		}
		
		/**
		 * Get the name of the UUID node
		 * @return string
		 */
		public function getUUIDNode() {
			return "contactId";
		}
}