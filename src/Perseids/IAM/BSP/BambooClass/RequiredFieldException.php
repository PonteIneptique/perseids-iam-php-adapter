<?php

	namespace Perseids\IAM\BSP\BambooClass;

	class RequiredFieldException extends \Exception {
		public $requiredField;
		public $className;

		public function __construct($requiredField, $object, $code = 0, Exception $previous = null) {
		    
			if(gettype($object) == "object") {
				$className = get_class($object);
			} else {
				$className = "UnknownClassName";
			}

 			$message = "Field " . $requiredField . " is required for object of type " . $className;
		    // make sure everything is assigned properly
		    parent::__construct($message, $code, $previous);
		}
	}