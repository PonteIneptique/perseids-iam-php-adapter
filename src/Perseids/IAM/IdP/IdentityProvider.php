<?php
	namespace Perseids\IAM\IdP;

	class IdentityProvider {

		function __construct($url) {
			$this->setUrl($url);
			return $this;
		}

		function setUrl($url) {
			$this->url = $url;
			return $this;
		}

		function getUrl() {
			return $this->url;
		}
	}
?>