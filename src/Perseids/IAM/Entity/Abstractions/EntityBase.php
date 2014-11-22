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

		/**
		 * An object representing the parent
		 * @var object
		 */
		protected $parent = NULL;

		public function __construct() {
			$this->addExclusion("path");
			$this->addExclusion("parent");
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
		 * Get the namespace
		 * @return string
		 */
		private function getNamespace() {
			return $this->namespace;
		}

		/**
		 * Get the node name
		 * @return string
		 */
		private function getNode() {
			return $this->node;
		}

		/**
		 * Get the node attributes
		 * @return string
		 */
		private function getNodeAttributes() {
			return $this->nodeAttributes;
		}


		/**
		 * Returns if needed 
		 * @param string $xml An xml string to be encapsulated inside a parent node
		 * @return string
		 */
		protected function withParents($xml) {
			if(gettype($this->parent) === "object") {

				$namespace = $this->parent->getNamespace();
				$nodeName = $this->parent->getNode();
				$nodeAttr = $this->parent->getNodeAttributes();

				$node  = "<".$namespace.":".$nodeName." ".$nodeAttr.">\n";
				$node .= $xml;
				$node .= "\n</".$namespace.":".$nodeName.">";

				return $node;
			}
			return $xml;
		}

		/**
		 * Generate XML representing the recorded entity
		 * @return string
		 */
		protected function getUUIDXML () {
			$namespace = $this->getNamespace();
			$nodeName = $this->getNode();
			$uuidNode = $this->getUUIDNode();

			$node  = "<".$namespace.":".$nodeName.">\n";
			$node .= "<".$namespace.":".$uuidNode.">";
			$node .= $this->getUUID();
			$node .= "</".$namespace.":".$uuidNode.">\n";
			$node .= "</".$namespace.":".$nodeName.">";

			return $node;
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