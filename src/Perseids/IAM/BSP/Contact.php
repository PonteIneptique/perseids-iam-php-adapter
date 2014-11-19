<?php

	namespace Perseids\IAM\BSP;

	use Perseids\IAM\BSP\BambooClass\Mockup;
	use Perseids\IAM\BSP\BambooClass\Name;

	class Contact extends Mockup {
		/**
		 * The contact's Identifier
		 * @var string
		 */
		protected $contactIdentifier;

		/**
		 * The contact's Name
		 * @var Name
		 */
		protected $name;

		/**
		 * The contact's display Name
		 * @var string
		 */
		protected $displayName;

		/**
		 * The Contact's email
		 * Should be an array of strings
		 * @var array
		 */
		protected $email;

		/**
		 * The Contact's IMs
		 * Should be a list of IMType
		 */
	}