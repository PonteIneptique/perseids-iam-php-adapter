<?php
	namespace Perseids\Tests\IAM\BSP\Contact;

	use Perseids\IAM\BSP\Contact\Address;

	class AddressTest extends \PHPUnit_Framework_TestCase {
		public function testXML() {
			$address = new Address();
			$address->setCountry("France");
			print($address->getXML());
		}
	}