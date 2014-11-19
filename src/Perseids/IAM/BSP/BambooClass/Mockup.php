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
			$inside = "";
			$object = $this->getSerialized($deepSerialization = FALSE);
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


			$xml = "";
			switch (gettype($value)) {
				case "array":
					while(list($key, $subvalue) = each($value)) {
						switch (gettype($key)) {
							case "int":
								$xml .= $this->createNode($namespace, $name, $subvalue, $lb = true);
								break;
							case "string":
								$xml .=  $this->createNode($namespace, $key, $subvalue, $lb = true);
								break;
							default:
								break;
						}
					}
					break;
				case "string":
				case "int":
					$xml  = "<".$namespace.":".$name.">";
					$xml .= $n1.$value.$n1;
					$xml .= "</".$namespace.":".$name.">".$n2;
					break;
				default:
					print(gettype($value));
					break;
			}

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
						case "int":
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
								print_r("Get Parent Class workds \n");
								$rtn[$key] = $value->getSerialized();
							}
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