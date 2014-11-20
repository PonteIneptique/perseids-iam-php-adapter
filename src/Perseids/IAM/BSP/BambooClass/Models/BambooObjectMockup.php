<?php
	namespace Perseids\IAM\BSP\BambooClass\Models;

	use Perseids\IAM\BSP\BambooClass\Models\Mockup;
	use \Perseids\IAM\BSP\Instance;

	class BambooObjectMockup extends Mockup {
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

		/**
		 * Post the current object to the BSP
		 * @param Instance $BSP An instance of a BSP
		 * @return self,boolean 
		 */
		public function create(Instance $BSP) {
			if(method_exists($this, method_name) === false) { 
				$e = new BadMethodCallException("The current object has no UUID and thus can't be created");
				throw $e;
				return false; 
			}
			$xml = $this->getXML();
			$response = $BSP->post("/contacts", "text/xml; charset=UTF-8", $xml);
			if($response->getStatusCode() === 201) {
				$uuid = $this->URLtoUUID($response->getHeader("location"), $this->location);
				$this->setUUID($uuid);
				return $self;
			}
			return false;
		}
	}