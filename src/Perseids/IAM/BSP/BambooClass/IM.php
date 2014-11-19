<?php
	namespace Perseids\IAM\BSP\BambooClass;

	use Perseids\IAM\BSP\BambooClass\Mockup;

	class IM extends Mockup {
		/**
		 * The name of the mother node
		 * @var string
		*/
		protected $node = "iMs";

		/**
		 * Type of Instant Message Service
		 * @var string
		 */
		protected $instantMessagingType;

		/**
		 * Name of the account for given IM
		 * @var string
		 */
		protected $account;

		/**
		 * Name of the location type
		 * @var string
		 */
		protected $locationType;

		/**
		 * Enumeration of available instantMessagingType
		 * @var array
		 */
		protected $instantMessagingTypeEnum = array("SKYPE", "TWITTER", "FACEBOOK", "AIM", "YAHOO", "SAMTIME", "MSN");

		/**
		 * Location type Enumeration
		 * @var array
		 */
		protected $locationTypeEnum = ["HOME", "WORK", "OTHER", "SABBATICAL", "MOBILE"];


		public function __construct() {
			$this->addExclusion("locationTypeEnum");
			$this->addExclusion("instantMessagingTypeEnum");
		}

		/**
		 * Gets the The name of the mother node.
		 *
		 * @return string
		 */
		public function getNode()
		{
		    return $this->node;
		}

		/**
		 * Sets the The name of the mother node.
		 *
		 * @param string $node the node
		 *
		 * @return self
		 */
		public function setNode($node)
		{
		    $this->node = $node;

		    return $this;
		}

		/**
		 * Gets the Type of Instant Message Service.
		 *
		 * @return string
		 */
		public function getInstantMessagingType()
		{
		    return $this->instantMessagingType;
		}

		/**
		 * Sets the Type of Instant Message Service.
		 *
		 * @param string $instantMessagingType the instant messaging type
		 *
		 * @return self
		 */
		public function setInstantMessagingType($instantMessagingType)
		{
			if(array_search($instantMessagingType, $this->instantMessagingTypeEnum, $strict = TRUE)) {
				$this->instantMessagingType = $instantMessagingType;
			} else {
				$this->instantMessagingType = $this->instantMessagingTypeEnum[0];
			}

		    return $this;
		}

		/**
		 * Gets the Name of the account for given IM.
		 *
		 * @return string
		 */
		public function getAccount()
		{
		    return $this->account;
		}

		/**
		 * Sets the Name of the account for given IM.
		 *
		 * @param string $account the account
		 *
		 * @return self
		 */
		public function setAccount($account)
		{
		    $this->account = $account;

		    return $this;
		}

		/**
		 * Gets the Name of the location type.
		 *
		 * @return string
		 */
		public function getLocationType()
		{
		    return $this->locationType;
		}

		/**
		 * Sets the Name of the location type.
		 *
		 * @param string $locationType the location type
		 *
		 * @return self
		 */
		public function setLocationType($locationType)
		{
			if(array_search($locationType, $this->locationTypeEnum, $strict = TRUE)) {
				$this->locationType = $locationType;
			} else {
				$this->locationType = $this->locationTypeEnum[0];
			}

		    return $this;
		}
}