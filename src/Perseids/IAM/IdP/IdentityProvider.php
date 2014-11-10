<?php
	namespace Perseids\IAM\IdP;

	class IdentityProvider {

		function __construct($url) {
			$this->setUrl($url);
		}

		function setUrl($url) {
			$this->url = $url;
		}

		function getUrl() {
			return $this->url;
		}
	}
?>