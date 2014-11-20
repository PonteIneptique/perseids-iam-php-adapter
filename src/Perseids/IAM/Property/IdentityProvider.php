<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;
	use Perseids\IAM\Property\SourcedIdKey;

	class IdentityProvider extends PropertyBase {
		/**
		 * The namespace 
		 * @var string
		 */
		protected $namespace = "person";
		/**
		 * The node name 
		 * @var string
		 */
		protected $node = "sourcedId";

		/**
		 * The name of the sourceId
		 * @var string
		 */
		protected $sourcedIdName;
		/**
		 * A SourceIdKey instance
		 * @var SourceIdKey
		 */
		protected $sourcedIdKey;

		function __construct($url, $name, $userId) {
			$this->setSourcedIdName($name);
			$this->setSourcedIdKey(new SourcedIdKey());
			$this->sourcedIdKey
				->setIdPId($url)
				->setUserId($userId);
		}



		/**
		 * Sets the The User Identifier for this Identity Provider.
		 *
		 * @param string $userId the user id
		 *
		 * @return self
		 */
		public function setUserId($userId) {
			$this->sourcedIdKey
				->setUserId($userId);
			return $this;
		}

		/**
		 * Gets the The name of the sourceId.
		 *
		 * @return string
		 */
		public function getSourcedIdName()
		{
		    return $this->sourcedIdName;
		}

		/**
		 * Sets the The name of the sourceId.
		 *
		 * @param string $sourcedIdName the source id name
		 *
		 * @return self
		 */
		public function setSourcedIdName($sourcedIdName)
		{
		    $this->sourcedIdName = $sourcedIdName;

		    return $this;
		}

		/**
		 * Gets the A SourceIdKey instance.
		 *
		 * @return SourceIdKey
		 */
		public function getSourcedIdKey()
		{
		    return $this->sourcedIdKey;
		}

		/**
		 * Sets the A SourcedIdKey instance.
		 *
		 * @param SourcedIdKey $sourcedIdKey the source id key
		 *
		 * @return self
		 */
		public function setSourcedIdKey(SourcedIdKey $sourcedIdKey)
		{
		    $this->sourcedIdKey = $sourcedIdKey;

		    return $this;
		}
}
?>