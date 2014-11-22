<?php

	namespace Perseids\Tests\IAM\Entity;

	use Perseids\IAM\Entity\Person;
	use Perseids\IAM\Property\IdentityProvider;

	class PersonTest extends \PHPUnit_Framework_TestCase {
		public function testGetXML() {

			$sourceOne = new IdentityProvider("http://someidp.org", "One SourcedId", "7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677284addd100126d9069");
			$sourceTwo = new IdentityProvider("http://someidp.org", "Two SourcedId", "7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677264addd100126d9069");
			
			$person = new Person();
			$person
				->addSourceId($sourceOne)
				->addSourceId($sourceTwo);

			$shouldReturn = "<person:bambooPerson xmlns:person=\"http://projectbamboo.org/bsp/BambooPerson\" xmlns:xs=\"http://www.w3.org/2001/XMLSchema\">
  <person:sourcedId>
    <person:sourcedIdName>One SourcedId</person:sourcedIdName>
    <person:sourcedIdKey>
      <person:idPId>http://someidp.org</person:idPId>
      <person:userId>7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677284addd100126d9069</person:userId>
    </person:sourcedIdKey>
  </person:sourcedId>
  <person:sourcedId>
    <person:sourcedIdName>Two SourcedId</person:sourcedIdName>
    <person:sourcedIdKey>
      <person:idPId>http://someidp.org</person:idPId>
      <person:userId>7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677264addd100126d9069</person:userId>
    </person:sourcedIdKey>
  </person:sourcedId>
</person:bambooPerson>";

			$this->assertXmlStringEqualsXmlString($shouldReturn, $person->getXML($attributes = true));
		}
	}