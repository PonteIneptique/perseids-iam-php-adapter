<?php
	namespace Perseids\Tests\IAM\Exceptions;

	use Perseids\IAM\Exceptions\RequiredFieldException;
	use Perseids\IAM\Property\PartName;

	class RequiredFieldExceptionTest extends \PHPUnit_Framework_TestCase {
		function testMessage() {
			$object = new PartName();
			$requiredField = "PartNameType";

			$error = new RequiredFieldException($requiredField, $object);
			$this->assertEquals("Field PartNameType is required for object of type Perseids\IAM\Property\PartName", $error->getMessage());
		}
	}