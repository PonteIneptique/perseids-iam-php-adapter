<?php
	namespace Perseids\IAM\BSP;

	use Perseids\IAM\IdP\IdentityProvider;
	use Perseids\IAM\BSP\Person;
	
	class Schema {

		private $xmlDeclaration = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\n";

		private function simplexml_error($sx_object) {
			$msg = NULL;
			foreach(libxml_get_errors() as $error) {
				$msg .= "\t" . $error->message;
			}
			if (strlen($msg) !== 0) { throw Exception($msg); };
		}

		/**
		 * Generate the xml required for /persons POST
		 * 
		 * @param IdentityProvider $IdP  An Identity Provider
		 * @param Person           $User A User
		 * @return string The xml for the 
		 */
		public function PersonsCreate(IdentityProvider $IdP, Person $User) {
			$xml = $this->xmlDeclaration;
			$xml .=<<<XML
<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<person:sourcedId>
		<person:sourcedIdName></person:sourcedIdName>
		<person:sourcedIdKey>
			<person:idPId></person:idPId>
			<person:userId></person:userId>
		</person:sourcedIdKey>
	</person:sourcedId>
</person:bambooPerson>
XML;
			$sx_sourcedId = simplexml_load_string($xml);
			$this->simplexml_error($sx_sourcedId);
			$ns = $sx_sourcedId->getDocNamespaces(TRUE);

			$sx_sourcedId->children($ns['person'])->sourcedId[0]->sourcedIdName = $IdP->getName();
			$sx_sourcedId->children($ns['person'])->sourcedId[0]->sourcedIdKey->idPId = $IdP->getUrl();
			$sx_sourcedId->children($ns['person'])->sourcedId[0]->sourcedIdKey->userId = $User->getId();

			$xml_prepared = trim(preg_replace('/<\?xml[^>]+>/', '', $sx_sourcedId->asXML()));
			return $xml_prepared;
		}
	}
?>