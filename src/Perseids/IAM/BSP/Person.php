<?php
	namespace Perseids\IAM\BSP;
	
	use Perseids\IAM\BSP\Schema;
	use Perseids\IAM\BSP\Instance;
	use Perseids\IAM\IdP\IdentityProvider;

	class Person {

		protected $XML;
		protected $IdP;
		protected $id;

		/**
		 * Generate the object
		 * 
		 * @return \Perseids\IAM\BSP\Person The actual instance
		 */
		function __construct() {
			$this->XML = new Schema();
			return $this;
		}

		/**
		 * Set the Identity Provider information
		 * @param IdentityProvider $IdP An identity provider object
		 * @return \Perseids\IAM\BSP\Person The actual instance
		 */
		function setIdentityProvider(IdentityProvider $IdP) {
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
		 * [setId description]
		 * @param string $id [description]
		 */
		public function setId($id) {
			$this->id = $id;
			return $this;
		}

		/**
		 * [getId description]
		 * @return string The ID of our person
		 */
		public function getId() {
			return $this->id;
		}

		function create(Instance $BSP) {
			$xml = $this->XML->PersonsCreate($this->getIdentityProvider(), $this);
			$response = $BSP->post("/persons", "text/xml; charset=UTF-8", $xml);
			print_r($response);
		}
	}
?>