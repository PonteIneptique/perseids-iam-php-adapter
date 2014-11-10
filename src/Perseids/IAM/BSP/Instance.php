<?php
	namespace Perseids\IAM\BSP;
	
	class Instance {
		/**
		 * @var string The url for the BSP
		 */
		protected $url = "http://services-rep.perseids.org/bsp";

		/**
		 * @var string The pass to the ssl certificates
		 */
		protected $certificates = null;

		/**
		 * @var \GuzzleHttp\Client A guzzle client to make http request
		 */
		protected $client;

		/**
		 * Create and feed the instance with given parameters
		 *
		 * @param string $url The URL for the BSP Instance
		 * @param string $certificates The path to the certificate for the ssl relationship
		 */
		function __construct($url = null, $certificates = null) {
			$this->client = nez \GuzzleHttp\Client();
			if($url !== null) {
				$this->setUrl($url);
			}
			if($certificates !== null) {
				$this->setCertificates($certificates);
			}
		}

		/**
		 * Set the URL of the Instance
		 *
		 * @param string $url The URL for the BSP Instance
		 * @return \Perseids\IAM\BSP\Instance
		 */
		function setUrl($url) {
			$this->url = $url;
			return $this;
		}

		/**
		 * Get the URL of the Instance
		 *
		 * @return string
		 */
		function getUrl() {
			return $this->url;
		}

		/**
		 * Set the Certificate Path of the Instance
		 *
		 * @param string $certificates The path to the certificate for the ssl relationship
		 * @return \Perseids\IAM\BSP\Instance
		 */
		function setCertificates($certificates) {
			$this->certificates = $certificates;
			return $this;
		}

		/**
		 * Get the Certificate Path of the Instance
		 *
		 * @return string The path to the certificate for the ssl relationship
		 */
		function getCertificates($certificates) {
			return $this->certificates;
		}
	}
?>