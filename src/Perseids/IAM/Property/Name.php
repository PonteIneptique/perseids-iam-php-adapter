<?php
	namespace Perseids\IAM\Property;

	use Perseids\IAM\Property\Abstractions\PropertyBase;

	class Name extends PropertyBase {
		/**
		 * Mother node
		 * @var string
		 */
		protected $node = "name";
		/**
		 * Formatted Name
		 * @var string
		 */
		protected $formattedName;

		/**
		 * Family Name
		 * @var string
		 */
		protected $familyName;

		/**
		 * Given Name
		 * @var string
		 */
		protected $givenName;

		/**
		 * Middle Name
		 * @var string
		 */
		protected $middleName;

		/**
		 * Honorifix Prefix
		 * @var string
		 */
		protected $honorificPrefix;

		/**
		 * Honorific Suffix
		 * @var string
		 */
		protected $honorificSuffix;

		/**
		 * List of PartNames object
		 * @var array(\Perseids\IAM\Entity\PartName);
		 */
		protected $partNames = array();


	
	/**
	 * Gets the Formatted Name.
	 *
	 * @return string
	 */
	public function getFormattedName()
	{
	    return $this->formattedName;
	}

	/**
	 * Sets the Formatted Name.
	 *
	 * @param string $formattedName the formatted name
	 *
	 * @return self
	 */
	public function setFormattedName($formattedName)
	{
	    $this->formattedName = $formattedName;

	    return $this;
	}

	/**
	 * Gets the Family Name.
	 *
	 * @return string
	 */
	public function getFamilyName()
	{
	    return $this->familyName;
	}

	/**
	 * Sets the Family Name.
	 *
	 * @param string $familyName the family name
	 *
	 * @return self
	 */
	public function setFamilyName($familyName)
	{
	    $this->familyName = $familyName;

	    return $this;
	}

	/**
	 * Gets the Given Name.
	 *
	 * @return string
	 */
	public function getGivenName()
	{
	    return $this->givenName;
	}

	/**
	 * Sets the Given Name.
	 *
	 * @param string $givenName the given name
	 *
	 * @return self
	 */
	public function setGivenName($givenName)
	{
	    $this->givenName = $givenName;

	    return $this;
	}

	/**
	 * Gets the Middle Name.
	 *
	 * @return string
	 */
	public function getMiddleName()
	{
	    return $this->middleName;
	}

	/**
	 * Sets the Middle Name.
	 *
	 * @param string $middleName the middle name
	 *
	 * @return self
	 */
	public function setMiddleName($middleName)
	{
	    $this->middleName = $middleName;

	    return $this;
	}

	/**
	 * Gets the Honorifix Prefix.
	 *
	 * @return string
	 */
	public function getHonorificPrefix()
	{
	    return $this->honorificPrefix;
	}

	/**
	 * Sets the Honorifix Prefix.
	 *
	 * @param string $honorificPrefix the honorific prefix
	 *
	 * @return self
	 */
	public function setHonorificPrefix($honorificPrefix)
	{
	    $this->honorificPrefix = $honorificPrefix;

	    return $this;
	}

	/**
	 * Gets the Honorifix Suffix.
	 *
	 * @return string
	 */
	public function getHonorificSuffix()
	{
	    return $this->honorificSuffix;
	}

	/**
	 * Sets the Honorifix Suffix.
	 *
	 * @param string $honorificSuffix the honorific suffix
	 *
	 * @return self
	 */
	public function setHonorificSuffix($honorificSuffix)
	{
	    $this->honorificSuffix = $honorificSuffix;

	    return $this;
	}

	/**
	 * Gets the List of PartNames object.
	 *
	 * @return array(\Perseids\IAM\Entity\PartName);
	 */
	public function getPartNames()
	{
	    return $this->partNames;
	}

	/**
	 * Sets the List of PartNames object.
	 *
	 * @param array(\Perseids\IAM\Entity\PartName); $partNames the part name
	 *
	 * @return self
	 */
	public function setPartNames($partNames)
	{
		return $this->setListOfObject("partNames", $partNames, "Perseids\IAM\Property\PartName");
	}

	/**
	 * Add a PartNames to he List of PartNames object.
	 *
	 * @param \Perseids\IAM\Entity\PartName $partNames the part name
	 *
	 * @return self
	 */
	public function addPartNames(PartName $partNames)
	{
		return $this->addObjectToList("partNames", $partNames, "Perseids\IAM\Property\PartName");
	}
}