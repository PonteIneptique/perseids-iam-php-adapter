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

		/**
		 * [setBSPUuid description]
		 * @param string $BSPUuid [description]
		 */
		public function setBSPUuid($BSPUuid) {
			$this->BSPUuid = $BSPUuid;
			return $this;
		} 

		/**
		 * [getBSPUuid description]
		 * @return string The BSP UUID of our person
		 */
		public function getBSPUuid() {
			return $this->BSPUuid;
		}

		/**
		 * Turns a url to a readable uuid
		 * @param string $url A url given by the BSP
		 * @param string $path The path used to post data
		 * 
		 * @return string $uuid A UUID
		 */
		private function URLtoUUID($url, $path) {
			$regexp = "/" . str_replace("/", "\\/", $path) . "\/urn\:uuid\:(?P<uuid>.*)/";
			preg_match($regexp, $url, $matches);
			$uuid = $matches["uuid"];

			return $uuid;
		}

		function create(Instance $BSP) {
			$xml = $this->XML->PersonsCreate($this->getIdentityProvider(), $this);
			$response = $BSP->post("/persons", "text/xml; charset=UTF-8", $xml);
			if($response->getStatusCode() === 201) {
				$uuid = $this->URLtoUUID($response->getHeader("location"), "/persons");
				$this->setBSPUuid($uuid);
			}
			return false;
		}
	}
?>