<?php
	namespace Perseids\IAM\Provider;

	class Service {
		/*
		 * @options
		 *
		 * @var array A list of options to override default
		 */
		protected $options;

		/*
		 *
		 * @options array A list of options to override default
		 */
		function __construct($options) {
			$defaults = array(
				"IAM.bsp.url" => "http://services-rep.perseids.org/bsp"
			);
		}
	}
?>