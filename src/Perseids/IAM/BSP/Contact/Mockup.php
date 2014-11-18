<?php
	namespace Perseids\IAM\BSP\Contact;

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
			$inside = "";
			$object = $this->getSerialized();
			while(list($key, $value) = each($object)) {
				$inside .= $this->createNode($this->namespace, $key, $value, $lb = false);
			}
			$xml = $this->createNode($this->namespace, $this->node, $inside);

			return $xml;
		}

		/**
		 * Create an XML node
		 * @param  string $namespace The namespace of the node
		 * @param  string $name      The name of the node
		 * @param  string $value     The value of the node
		 * @param  boolean $lb        If adding \n to value
		 * @return string            An XML node
		 */
		private function createNode($namespace, $name, $value, $lb = true) {
			if($lb === true) { $n1 = "\n"; $n2 = "";}
			else { $n1 = ""; $n2 = "\n";}
			$xml  = "<".$namespace.":".$name.">";
			$xml .= $n1.$value.$n1;
			$xml .= "</".$namespace.":".$name.">".$n2;
			return $xml;
		}

		/**
		 * Get an associative array version of the object without excluded variable set in $excludeSerialization
		 * @return	array	An associative array version of the object
		 */
		public function getSerialized() {
			$rtn = [];
			$serialized = get_object_vars($this);
			while(list($key, $value) = each($serialized)) {
				if(array_search($key, $this->excludeSerialization, $strict = TRUE) === false && is_string($value)) {
					$rtn[$key] = $value;
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