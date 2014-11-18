<?php
	namespace Perseids\Tests\IAM\BSP;

	use Perseids\IAM\BSP\Person;
	use Perseids\IAM\IdP\IdentityProvider;
	use Perseids\IAM\BSP\Schema;

	class SchemaTest extends \PHPUnit_Framework_TestCase {
		protected $IdP;
		protected $Schema;

		protected function setUp() {
			$this->IdP = new IdentityProvider("http://localhost/IdP", "LascivaRoma");
			$this->Schema = new Schema();
		}

		public function testXmlCreateIdentity() {
			$userId = 1;
			$identity = new Person();
			$identity->setId($userId);

			$shouldReturn = '<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<person:sourcedId>
		<person:sourcedIdName>LascivaRoma</person:sourcedIdName>
		<person:sourcedIdKey>
			<person:idPId>http://localhost/IdP</person:idPId>
			<person:userId>1</person:userId>
		</person:sourcedIdKey>
	</person:sourcedId>
</person:bambooPerson>';

			$this->assertEquals($shouldReturn, $this->Schema->PersonsCreate($this->IdP, $identity));
		}
	}
?>