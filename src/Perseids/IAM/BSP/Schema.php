<?php
	namespace Perseids\IAM\BSP;

	use Perseids\IAM\Property\IdentityProvider;
	use Perseids\IAM\Entity\Person;
	
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

		/**
		 * Return the XML Schema for a Contact
		 *
		 * @return XML The XML Schema for contact in BSP
		 */
		public function Contact() {
			 $xml =<<<XML
<contacts:bambooContact xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact">
    <contacts:telephones>
        <contacts:telephoneType>VOICE</contacts:telephoneType>
        <contacts:locationType>HOME</contacts:locationType>
    </contacts:telephones>
    <contacts:telephones>
        <contacts:telephoneType>SMS</contacts:telephoneType>
        <contacts:telephoneNumber></contacts:telephoneNumber>
        <contacts:locationType>SABBATICAL</contacts:locationType>
    </contacts:telephones>
    <contacts:iMs>
        <contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>
        <contacts:account></contacts:account>
        <contacts:locationType>WORK</contacts:locationType>
    </contacts:iMs>
    <contacts:addresses>
        <contacts:streetAddress1></contacts:streetAddress1>
        <contacts:streetAddress2></contacts:streetAddress2>
        <contacts:streetAddress3></contacts:streetAddress3>
        <contacts:locality></contacts:locality>
        <contacts:region></contacts:region>
        <contacts:postalCode></contacts:postalCode>
        <contacts:country></contacts:country>
        <contacts:locationType>WORK</contacts:locationType>
    </contacts:addresses>
</contacts:bambooContact>
XML;
			return $xml;
		}

		/**
		 * Return the XML Schema for a Profile
		 *
		 * @return XML The XML Schema for a Profile in BSP
		 */
		public function Profile() {
  $xml =<<<XML
<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">
<person:bambooProfile person:confidential="false" person:primary="true" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact" xmlns:person="http://projectbamboo.org/bsp/BambooPerson">
<person:profileId>testid</person:profileId>
<person:bambooPersonId>personid</person:bambooPersonId>
<person:profileInformation></person:profileInformation>
  <contacts:bambooContact>
    <contacts:contactId></contacts:contactId>
  </contacts:bambooContact>
  <person:interests person:confidential="false">
  </person:interests>
  <person:expertises person:confidential="false">
  </person:expertises>
  <person:externalAffiliations></person:externalAffiliations>
  <person:preferredLanguage></person:preferredLanguage>
  <person:languageUsedInScholarships></person:languageUsedInScholarships>
  <person:otherProfiles person:confidential="false">
    <person:profileName></person:profileName>
    <person:profileUrl></person:profileUrl>
  </person:otherProfiles>
  <person:authorizedPublisher>true</person:authorizedPublisher>
</person:bambooProfile>
</person:bambooPerson>
XML;
			return $xml;

		}


		public function create(Profile $profile, Person $person, Instance $instance) {
			$xml = $this->xmlDeclaration;
			$xml .= '<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">' . "\n";
			$xml .= '<person:bambooProfile person:confidential="false" person:primary="false" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact" xmlns:person="http://projectbamboo.org/bsp/BambooPerson">' . "\n";
			$xml .= '<contacts:bambooContact>' . "\n";
			$xml .= "<contacts:contactId>urn:uuid:" . $person->getBSPUuid() . "</contacts:contactId>\n";
			$xml .= '</contacts:bambooContact>' . "\n";

			//while (list($k, $v) = each($form_state['complete form']['contacts'])) {
			while (list($k, $v) = each($form_state['values']['person']))  {
				//if (!is_array($c) || !isset($c['#name'])) continue;
				$parts = explode('-', $k);
				switch ($parts[0]) {
					case "profileInformation":
					case "externalAffiliations":
					case "preferredLanguage":
					case "languageUsedInScholarships":
						$xml .= "<$namespace:" . $parts[0] . ">" . $v . "</$namespace:" . $parts[0] . ">\n";
						break;
					case "interests":
					case "expertises":
						$singular = trim($parts[0], "s");
						$xml .= "<$namespace:" . $parts[0] . ">\n";
						$xml .= "<$namespace:$singular>" . $v . "</$namespace:$singular>\n";
						$xml .= "</$namespace:" . $parts[0] . ">\n";
						break;
					case "otherProfiles":
						$op_children[] = "<$namespace:" . $parts[1] . ">" . $v . "</$namespace:".  $parts[1] .">";
						//number of op children hard coded!
						if (count($op_children) == 2) {
							$xml .= "<$namespace:otherProfiles>\n";
							$xml .= implode("\n", $op_children);
							$xml .= "</$namespace:otherProfiles>\n";
						}
						break;
				}
			}
			$xml .= "</person:bambooProfile>\n";
			$xml .= "</person:bambooPerson>\n";
			return $xml;
		}
	}
?>