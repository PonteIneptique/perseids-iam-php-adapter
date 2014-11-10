<?php
	namespace Perseids\IAM\BSP;
	
	use Perseids\IAM\BSP\Schema;
	use Perseids\IAM\BSP\Instance;
	use Perseids\IAM\IdP\IdentityProvider;

	class Identity {

		protected $XML;
		protected $IdP;
		protected $id;

		function __construct(IdentityProvider $IdP) {
			$this->XML = new Schema();
			$this->IdP = $IdP;
		}

		public function setId($id) {
			$this->id = $id;
			return $this;
		}

		public function getId() {
			return $this->id;
		}

		function create(Instance $BSP) {
			$xml = $this->XML->PersonsCreate($this->IdP, $this);
			$BSP->request();
		}
	}
?>