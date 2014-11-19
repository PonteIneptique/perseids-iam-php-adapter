<?php
	namespace Perseids\IAM\BSP\BambooClass;

	class Mockup {
		/**
		 * The Namespace used for the xml
		 * @var string
		 */
		protected $namespace = "contacts";

		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "mockup";

		/**
		 * Serialization excluded vars
		 * @var array
		 */
		protected $excludeSerialization = ["namespace", "node", "excludeSerialization"];

		/**
		 * Returns XML for content
		 * @return string The XML representation of the element
		 */
		public function getXML() {
			$object = $this->getSerialized($deepSerialization = FALSE);
			$xml = array();
			while(list($key, $value) = each($object)) {
				$xml[] = $this->createNode($this->namespace, $key, $value, false);
			}
			$xml = $this->createNode($this->namespace, $this->node, implode("\n", $xml), true);

			return $xml;
		}

		/**
		 * Create an XML node
		 * @param  string $namespace The namespace of the node
		 * @param  string $name      The name of the node
		 * @param  string $value     The value of the node
		 * @param  boolean $lb        If adding \n to to encapsulate the value
		 * @return string            An XML node
		 */
		private function createNode($namespace, $name, $value, $lb = false) {
			$xml = array();
			switch (gettype($value)) {
				case "array":
					while(list($key, $subvalue) = each($value)) {
						switch (gettype($key)) {
							case "integer":
								$xml[] = $this->createNode($namespace, $name, $subvalue, $lb = true);
								break;
							case "string":
								$xml[] =  $this->createNode($namespace, $key, $subvalue, $lb = true);
								break;
							default:
								break;
						}
					}
					break;
				case "string":
				case "integer":

					if($lb === true) {
						$xml[] = "<".$namespace.":".$name.">\n".$value."\n</".$namespace.":".$name.">";
					} else {
						$xml[] = "<".$namespace.":".$name.">".$value."</".$namespace.":".$name.">";
					}
					break;
				case "object":
					if(get_parent_class($value) === "Perseids\IAM\BSP\BambooClass\Mockup") {
						$xml[] = $value->getXML();
					}
					break;
				default:
					break;
			}
			$xml = implode("\n", $xml);
			return $xml;
		}

		/**
		 * Get an associative array version of the object without excluded variable set in $excludeSerialization
		 * @return	array	An associative array version of the object
		 */
		public function getSerialized($deepSerialization = TRUE) {
			$serialized = get_object_vars($this);
			$rtn = $this->serialize($serialized, $deepSerialization);
			return $rtn;
		}

		private function serialize($serialized, $deepSerialization = TRUE) {
			$rtn = [];
			while(list($key, $value) = each($serialized)) {
				if(array_search($key, $this->excludeSerialization, $strict = TRUE) === false && $value !== null) {
					switch (gettype($value)) {
						case "string":
						case "integer":
							$rtn[$key] = $value;
							break;
						case "array":
							if(count($value) > 0) {
								if($deepSerialization) {
									$rtn[$key] = $this->serialize($value);
								} else {
									$rtn[$key] = $value;
								}
							}
							break;
						case "object":
							if(get_parent_class($value) === "Perseids\IAM\BSP\BambooClass\Mockup") {
								$rtn[$key] = $value->getSerialized();
							}
							break;
						default:
							break;
					}
				}
			}
			return $rtn;
		}

		/**
		 * Set the namespace of the object
		 * @param string $namespace The namespace to be used
		 * @return this
		 */
		public function setNamespace($namespace) {
			$this->namespace = $namespace;
			return $this;
		}

		/**
		 * Exclude an element from serialization
		 * @param string A key
		 * @return this
		 */
		public function addExclusion($string) {
			$this->excludeSerialization[] = $string;
			return $this;
		}
	}