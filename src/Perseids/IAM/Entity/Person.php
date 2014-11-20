<?php
	namespace Perseids\IAM\Entity;
	
	use Perseids\IAM\Entity\Abstractions\EntityBase;
	use Perseids\IAM\Entity\Abstractions\EntityInterface;

	use Perseids\IAM\BSP\Schema;
	use Perseids\IAM\BSP\Instance;
	use Perseids\IAM\Property\IdentityProvider;

	
	class Person extends EntityBase implements EntityInterface {
		/**
		 * The namespace for this node
		 * @var string 
		 */
		protected $namespace = "person";

		/**
		 * The URL path endpoint for this object
		 * @var string 
		 */
		protected $path = "person";

		/**
		 * The main node name
		 * @var string
		 */
		protected $node = "bambooPerson";

		/**
		 * The main node attributes
		 * @var string
		 */
		protected $nodeAttributes = 'xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema"';

		/**
		 * List of sourceId identifiers 
		 * @var array
		 */
		protected $sourceId;

		/**
		 * The user ID for our own system
		 * @var string
		 */
		protected $id;

		/**
		 * The user personal UUID on the BSP
		 * @var string
		 */
		protected $personIdentifier;

		/**
		 * Generate the object
		 */
		function __construct() {
			parent::__construct();
			$this
				->addExclusion("id")
				->addExclusion("personIdentifier");
		}

		/**
		 * Set the Identity Provider information
		 * @param array $IdP An array with IdentityProvider
		 * @return self
		 */
		function setIdentityProvider($IdP) {
			$this->IdP = $IdP;
			return $this;
		}

		/**
		 * Get the Identity Provider
		 * @return IdentityProvider $IdP An identity provider object
		 */
		function getIdentityProvider() {
			return $this->IdP;
		}

		/**
		 * Set the The ID of our person
		 * @param string $id [description]
		 * @return self
		 */
		public function setId($id) {
			$this->id = $id;
			return $this;
		} 

		/**
		 * Get the The ID of our person
		 * @return string 
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * Se
		 * @param string $UUID [description]
		 * @return self
		 */
		public function setUUID($UUID) {
			$this->personIdentifier = $BSPUuid;
			return $this;
		} 

		/**
		 * Get the BSP UUID of our person
		 * @return string 
		 */
		public function getUUID() {
			return $this->personIdentifier;
		}

		/**
		 * Add an Identity Provider object for identifying our User
		 * @param $idP IdentityProvider The object to be added
		 * @return self
		 */
		public function addSourceId($idP) {
			return $this->addObjectToList("sourceId", $idP, "Perseids\IAM\Property\IdentityProvider");
		}
	}
?>