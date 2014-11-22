<?php
	namespace Perseids\IAM\Entity\Abstractions;

	use \Perseids\IAM\BSP\Instance;
	/*
		Bamboo object represents items that can be posted. 
	*/
	interface EntityInterface {
		/**
		 * Set the UUID of the object
		 * @param $UUID string The UUID
		 * @return self
		 */
		public function setUUID($UUID);
		/**
		 * Get the UUID of the object
		 * @return string
		 */
		public function getUUID();

		/**
		 * Get the name of the UUID node
		 * @return string
		 */
		public function getUUIDNode();

		/**
		 * Post the current object to the BSP
		 * @param Instance $BSP An instance of a BSP
		 * @return self,boolean 
		 */
		public function create(Instance $BSP);
	}
?>