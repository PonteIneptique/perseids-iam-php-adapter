<?php
	namespace Perseids\IAM\Entity\Abstractions;

	use Perseids\IAM\Property\Abstractions\PropertyBase;
	use Perseids\IAM\BSP\Instance;

	class EntityBase extends PropertyBase {
		/**
		 * The URL path endpoint for this object
		 * @var string 
		 */
		protected $path;

		public function __construct() {
			$this->addExclusion("path");
		}

		/**
		 * Turns a url to a readable uuid
		 * @param string $url A url given by the BSP
		 * @return string
		 */
		private function URLtoUUID($url) {
			$regexp = "/" . str_replace("/", "\\/", $this->path) . "\/urn\:uuid\:(?P<uuid>.*)/";
			preg_match($regexp, $url, $matches);
			$uuid = $matches["uuid"];

			return $uuid;
		}

		/**
		 * Post the current object to the BSP
		 * @param Instance $BSP An instance of a BSP
		 * @return self,boolean 
		 */
		public function create(Instance $BSP) {
			if(method_exists($this, "getUUID") === false) { 
				$e = new BadMethodCallException("The current object has no UUID and thus can't be created");
				throw $e;
				return false; 
			}
			$xml = $this->getXML($attributes = true);
			$response = $BSP->post("/contacts", "text/xml; charset=UTF-8", $xml);
			if($response->getStatusCode() === 201) {
				$uuid = $this->URLtoUUID($response->getHeader("location"));
				$this->setUUID($uuid);
				return $self;
			}
			return false;
		}
	}