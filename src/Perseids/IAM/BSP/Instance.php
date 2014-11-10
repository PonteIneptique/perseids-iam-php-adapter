<?php
	namespace Perseids\IAM\BSP;
	
	class Instance {
		/**
		 * The url for the BSP
		 * @var string 
		 */
		protected $url = "http://services-rep.perseids.org/bsp";

		/**
		 * The pass to the ssl certificates
		 * @var string 
		 */
		protected $certificates = null;

		/** 
		 * A guzzle client to make http request
		 * @var \GuzzleHttp\Client
		 */
		protected $client;

		/**
		 * [$XBambooRoles description]
		 * @var string
		 */
		protected $XBambooRoles = "";

		/**
		 * [$XBambooAppId description]
		 * @var string
		 */
		protected $XBambooAppId = "";

		/**
		 * Bamboo Person representing the Application
		 * @var \Perseids\IAM\BSP\Identity
		 */
		protected $XBambooBPiD = new Identity();



		/**
		 * Create and feed the instance with given parameters
		 *
		 * @param string $url The URL for the BSP Instance
		 * @param string $certificates The path to the certificate for the ssl relationship
		 * 
		 * @return \Perseids\IAM\BSP\Instance
		 */
		function __construct($url = null, $certificates = null) {
			$this->client = new \GuzzleHttp\Client();
			if($url !== null) {
				$this->setUrl($url);
			}
			if($certificates !== null) {
				$this->setCertificates($certificates);
			}
			return $this;
		}

		/**
		 * Get the headers for HTTP Requests
		 *
		 * @param Identity An IAM BSP Identity on behalf of whom we are doing the requests
		 * @return array Required BSP headers
		 */
		private function getHeader(Identity $BambooPerson = null) {
			if($BambooPerson === null) { $BambooPerson = $this->XBambooBPiD; }
			$headers = array(
				"X-Bamboo-BPID" => $BambooPerson->getId(),
				"X-Bamboo-APPID" => $this->XBambooAppId,
				"X-Bamboo-ROLES" => $this->XBambooRoles;
			);
			return $headers;
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