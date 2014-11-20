<?php
	namespace Perseids\IAM\Property;

	class IdentityProvider {

		function __construct($url, $name) {
			$this->setUrl($url);
			$this->setName($name);
			return $this;
		}

		function setUrl($url) {
			$this->url = $url;
			return $this;
		}

		function getUrl() {
			return $this->url;
		}

		function setName($name) {
			$this->name = $name;
			return $this;
		}

		function getName() {
			return $this->name;
		}
	}
?>