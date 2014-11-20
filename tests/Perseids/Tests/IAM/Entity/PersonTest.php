<?php

	namespace Perseids\Tests\IAM\Entity;

	use Perseids\IAM\Entity\Person;
	use Perseids\IAM\Property\IdentityProvider;

	class PersonTest extends \PHPUnit_Framework_TestCase {
		public function testGetXML() {

			$twitter = new IdentityProvider("http://twitter.com", "Twitter", "Twitter-UserUID");
			$person = new Person();
			$person
				->setId(1)
				->addSourceId($twitter);

			$shouldReturn = '<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">
<person:sourcedId>
<person:sourcedIdName>Twitter</person:sourcedIdName>
<person:sourcedIdKey>
<person:idPId>http://twitter.com</person:idPId>
<person:userId>Twitter-UserUID</person:userId>
</person:sourcedIdKey>
</person:sourcedId>
</person:bambooPerson>';

			$this->assertXmlStringEqualsXmlString($shouldReturn, $person->getXML($attributes = true));
		}
	}