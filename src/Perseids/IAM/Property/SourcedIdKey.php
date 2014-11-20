<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class SourcedIdKey extends PropertyBase {
		/**
		 * The namespace 
		 * @var string
		 */
		protected $namespace = "person";
		/**
		 * The name for the mother node
		 * @var string
		 */
		protected $node = "sourcedIdKey";

		/**
		 * The Identity Provider Identifier
		 * @var string
		 */
		protected $idPId;

		/**
		 * The User Identifier for this Identity Provider
		 * @var string
		 */
		protected $userId;

		/**
		 * Gets the The Identity Provider Identifier.
		 *
		 * @return string
		 */
		public function getIdPId()
		{
		    return $this->idPId;
		}

		/**
		 * Sets the The Identity Provider Identifier.
		 *
		 * @param string $idPId the id pid
		 *
		 * @return self
		 */
		public function setIdPId($idPId)
		{
		    $this->idPId = $idPId;

		    return $this;
		}

		/**
		 * Gets the The User Identifier for this Identity Provider.
		 *
		 * @return string
		 */
		public function getUserId()
		{
		    return $this->userId;
		}

		/**
		 * Sets the The User Identifier for this Identity Provider.
		 *
		 * @param string $userId the user id
		 *
		 * @return self
		 */
		public function setUserId($userId)
		{
		    $this->userId = $userId;

		    return $this;
		}
}
?>