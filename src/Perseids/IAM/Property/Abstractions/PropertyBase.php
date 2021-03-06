<?php
	namespace Perseids\IAM\Property\Abstractions;

	use Perseids\IAM\Exceptions\RequiredFieldException;

	class PropertyBase {
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
		 * The main node attributes
		 * @var string
		 */
		protected $nodeAttributes = '';

		/**
		 * A list of property that are required for serialization and thus xml
		 * @var array
		 */
		protected $required = array();

		/**
		 * Serialization excluded vars
		 * @var array
		 */
		protected $excludeSerialization = ["namespace", "node", "excludeSerialization", "nodeAttributes", "required"];

		/**
		 * Returns XML for content
		 * @param  boolean $attributes If set to true, will put the node's attributes in its declaration 
		 * @return string The XML representation of the element
		 */
		public function getXML($attributes = False) {
			$object = $this->getSerialized($deepSerialization = false);
			$xml = array();
			while(list($key, $value) = each($object)) {
				$xml[] = $this->createNode($this->namespace, $key, $value, false);
			}
			$xml = $this->createNode($this->namespace, $this->node, implode("\n", $xml), true, $attributes = $attributes);

			if(method_exists($this, "withParents") === true) {
				return $this->withParents($xml);
			}
			return $xml;
		}

		/**
		 * Create an XML node
		 * @param  string $namespace The namespace of the node
		 * @param  string $name      The name of the node
		 * @param  string $value     The value of the node
		 * @param  boolean $lb        If adding \n to to encapsulate the value
		 * @param  boolean $attributes If set to true, will put the node's attributes in its declaration 
		 * @return string            An XML node
		 */
		private function createNode($namespace, $name, $value, $lb = false, $attributes = False) {
			$xml = array();
			switch (gettype($value)) {
				case "array":
					while(list($key, $subvalue) = each($value)) {
						switch (gettype($key)) {
							case "integer":
								$xml[] = $this->createNode($namespace, $name, $subvalue);
								break;
							case "string":
								$xml[] =  $this->createNode($namespace, $key, $subvalue);
								break;
							default:
								break;
						}
					}
					break;
				case "string":
				case "integer":
					$node = $namespace.":".$name;
					if($attributes === true) { $attributes = " ".$this->nodeAttributes; }
					else { $attributes = ""; }
					if($lb === true) {
						$xml[] = "<".$node.$attributes.">\n".$value."\n</".$node.">";
					} else {
						$xml[] = "<".$node.$attributes.">".$value."</".$node.">";
					}
					break;
				case "object":
					if(get_parent_class($value) === "Perseids\IAM\Property\Abstractions\PropertyBase" || get_parent_class($value) === "Perseids\IAM\Entity\Abstractions\EntityBase") {
						if(method_exists($value, "getUUID") === true && $value->getUUID() !== null) {
							$xml[] = $value->getUUIDXML();
						} else {
							$xml[] = $value->getXML();
						}
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
		public function getSerialized($deepSerialization = true) {
			$serialized = get_object_vars($this);
			$rtn = $this->serialize($serialized, $deepSerialization);
			return $rtn;
		}

		private function serialize($serialized, $deepSerialization = true) {
			$rtn = [];
			while(list($key, $value) = each($serialized)) {
				if(array_search($key, $this->excludeSerialization, $strict = true) === false) {
					if($this->checkRequired($key, $value) === true && $value !== null) {
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
								if(method_exists($value, "getSerialized") === true && $deepSerialization === true) {
									$rtn[$key] = $value->getSerialized();
								} else {
									$rtn[$key] = $value;
								}
								break;
							default:
								break;
						}
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
		 * @param string,array $key A key
		 * @return this
		 */
		public function addExclusion($key) {
			switch (gettype($key)) {
				case "string":
					$this->excludeSerialization[] = $key;
					break;
				case "array":
					$this->excludeSerialization = array_merge($this->excludeSerialization, $key);
					break;
			}
			return $this;
		}

		/**
		 * Set a list of object
		 * Helper function for setter with array with specific object
		 * @param string $varname The property of the class to be modified
		 * @param object $values A list of object to set for the property
		 * @param string $expectedType The name of the class expected
		 * @return self
		 */
		protected function setListOfObject($varname, $values, $expectedType) {
			$this->{$varname} = array();	#We reset the property
			while(list($key, $value) = each($values)) {
				$this->addObjectToList($varname, $value, $expectedType);
			}
			return $this;
		}

		/**
		 * Add an object and check it's validity to a list
		 * Helper function for setter with array with specific object
		 * @param string $varname The property of the class to be modified
		 * @param object $value The object to add in the list
		 * @param string $expectedType The name of the class expected
		 * @return self
		 */
		protected function addObjectToList($varname, $value, $expectedType) {
			if(gettype($value) !== "object") {
				throw(new \InvalidArgumentException($expectedType." expected. ". gettype($value) . " given."));
			}
			if(get_class($value) === $expectedType) {
				$this->{$varname}[] = $value;
			} else {
				throw(new \InvalidArgumentException($expectedType." expected. ".get_class($value) . " given."));
			}
			return $this;
		}

		/**
		 * Add an element to required elements for a given object
		 * @param string,array $key A property name to be required
		 * @return self
		 */
		protected function addRequired($key) {
			switch (gettype($key)) {
				case "string":
					$this->required[] = $key;
					break;
				case "array":
					$this->required = array_merge($this->required, $key);
					break;
			}
			return $this;
		}

		/**
		 * Add an element to required elements for a given object
		 * @param string $key A property name to be required
		 * @param any $value The value for this property in self
		 * @return boolean
		 */
		protected function checkRequired($key, $value) {
			if(array_search($key, $this->required, $strict = True) !== False) {
				switch (gettype($value)) {
					case 'array':
						if(count($value) > 0) {
							return true;
						}
						throw new RequiredFieldException($key, $this);
						return false;
						break;
					case 'null':
					case 'NULL':
						throw new RequiredFieldException($key, $this);
							return false;
						break;
					case 'string':
						if(trim($value) === '') {
							throw new RequiredFieldException($key, $this);
							return false;
						}
						return true;
						break;
					default:
						return true;
						break;
				}
			}
			return true;
		}
	}