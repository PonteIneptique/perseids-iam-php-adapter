<?php
	namespace Perseids\IAM\Provider;
	
	class BSP {
		/*
		 * @url
		 *
		 * @var string The url for the BSP
		 */
		protected $url = "http://services-rep.perseids.org/bsp";

		/*
		 * @certificates
		 *
		 * @var string The pass to the ssl certificates
		 */
		protected $certificates = null;

		/*
		 *
		 * @options array A list of options to override default
		 */
		function __construct($url = null, $certificates = null) {
			if($url !== null) {
				$this->setUrl($url);
			}
			if($certificates !== null) {
				$this->setCertificates($certificates);
			}
		}

		function setUrl($url) {
			$this->url = $url;
		}

		function getUrl() {
			return $this->url;
		}

		function setCertificates($certificates) {
			$this->certificates = $certificates;
		}

		function getCertificates($certificates) {
			return $this->certificates;
		}
	}
?>