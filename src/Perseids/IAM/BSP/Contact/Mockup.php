<?php
	namespace Perseids\IAM\BSP\Contact;

	class Mockup {
		/**
		 * The Namespace used for the xml
		 * @var string
		 */
		protected $namespace = "person";
		
		/**
		 * Set the namespace of thje object
		 * @param string $namespace The namespace to be used
		 * @return this
		 */
		public function setNamespace($namespace) {
			$this->namespace = $namespace;
			return $this;
		}

		/**
		 * Returns XML for content
		 * @return [type] [description]
		 */
		public function getXML() {
			return $xml;
		}
	}