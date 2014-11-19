<?php
	namespace Perseids\Tests\IAM\BSP\BambooClass;

	use Perseids\IAM\BSP\BambooClass\RequiredFieldException;
	use Perseids\IAM\BSP\BambooClass\PartName;

	class RequiredFieldExceptionTest extends \PHPUnit_Framework_TestCase {
		function testMessage() {
			$object = new PartName();
			$requiredField = "PartNameType";

			$error = new RequiredFieldException($requiredField, $object);
			$this->assertEquals("Field PartNameType is required for object of type Perseids\IAM\BSP\BambooClass\PartName", $error->getMessage());
		}
	}