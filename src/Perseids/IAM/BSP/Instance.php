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
		 * The role for the headers
		 * @var string
		 */
		protected $BambooRoles = "";

		/**
		 * The Bamboo APP ID
		 * @var string
		 */
		protected $BambooAppId = "";

		/**
		 * Bamboo Person representing the Application
		 * @var \Perseids\IAM\BSP\Identity
		 */
		protected $BambooBPiD = new Identity();



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
			if($BambooPerson === null) { $BambooPerson = $this->BambooBPiD; }
			$headers = array(
				"X-Bamboo-BPID" => $BambooPerson->getId(),
				"X-Bamboo-APPID" => $this->BambooAppId,
				"X-Bamboo-ROLES" => $this->XambooRoles;
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

		/**
		 * Set the Bamboo Person agent for the headers
		 * 
		 * @param Identity $BambooPerson The identity on behalf of which we do request
		 * @return \Perseids\IAM\BSP\Instance
		 */
		public function setBambooPerson(Identity $BambooPerson){
			$this->BambooBPiD = $BambooPerson;
			return $this;
		}

		/**
		 * Get the Bamboo person
		 * 
		 * @return \Perseids\IAM\BSP\Identity The identity on behalf of which we do request
		 */
		public function getBambooPerson() {
			return $this->BambooBPiD;
		}

		/**
		 * Set the ID of the App doing request to the BSP
		 * 
		 * @param string $appId  The ID of the App doing request to the BSP
		 * @return \Perseids\IAM\BSP\Instance
		 */
		public function setBambooAppId(string $appId) {
			return $this;
		}

		/**
		 * Get the ID of the App doing request to the BSP
		 * 
		 * @return string The ID of the App doing request to the BSP
		 */
		public function getBambooAppId() {
			return $this->BambooAppId;
		}

		/**
		 * Set the Bamboo Roles
		 * 
		 * @param string $roles The roles for the headers
		 * @return \Perseids\IAM\BSP\Instance
		 */
		public function setBambooRoles(string $roles) {
			$this->BambooRoles = $roles;
			return $this;
		}

		/**
		 * Get the Bamboo roles
		 * @return string The roles for the Headers
		 */
		public function getBambooRoles() {
			return $this->BambooRoles;
		}

		/**
		 * Post to a given path of the BSP
		 * 
		 * @param  string $url     An URL to post to
		 * @param  string $mime    The content type of the document
		 * @param  string $content The content to pose
		 * @return GuzzleHttp\Message\ResponseInterface           The Guzzle Response
		 */
		public function post(string $url, string $mime, string $content) {
			try {

				$request = $this->client->createRequest("POST", $url, [
					"headers" => $this->getHeader();
				]);
				$request->setBody($content);
				$request->setHeader("content-type", $mime);

				$response = $this->client->send($request);

				return $reponse;	

			} catch (RequestException $e) {

				if($e->hasResponse()) { $msg = $e->getRequest() . "\n" . $e->getResponse(); } else { $msg = $e->getRequest(); }

				throw Exception($msg);
			}

		}
	}
?>